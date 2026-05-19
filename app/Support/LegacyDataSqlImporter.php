<?php

namespace App\Support;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Enums\UserRole;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use InvalidArgumentException;

class LegacyDataSqlImporter
{
    /**
     * @return array{users:int,listings:int,bookings:int,saved_listings:int}
     */
    public function import(string $path, bool $fresh = false): array
    {
        if (! is_file($path)) {
            throw new InvalidArgumentException("Legacy SQL file not found: {$path}");
        }

        $sql = file_get_contents($path);

        if ($sql === false) {
            throw new InvalidArgumentException("Unable to read legacy SQL file: {$path}");
        }

        $tables = $this->parseInsertStatements($sql);

        return DB::transaction(function () use ($tables, $fresh): array {
            if ($fresh) {
                $this->clearMarketplaceTables();
            }

            $legacyUsers = $this->tableRows($tables, 'users');
            $legacyCars = $this->tableRows($tables, 'cars');
            $legacyCarImages = $this->tableRows($tables, 'car_images');
            $legacyBookings = $this->tableRows($tables, 'bookings');
            $legacyWishlists = $this->tableRows($tables, 'wishlists');
            $legacyWishlistCars = $this->tableRows($tables, 'wishlist_cars');

            $sellerLegacyIds = collect($legacyCars)
                ->pluck('owner')
                ->filter()
                ->unique()
                ->values()
                ->all();

            $userCount = $this->importUsers($legacyUsers, $sellerLegacyIds);

            $importedUsers = User::query()
                ->whereNotNull('legacy_id')
                ->get(['id', 'legacy_id', 'name', 'email', 'phone', 'whatsapp_number', 'role']);

            $userIdMap = $importedUsers->pluck('id', 'legacy_id')->all();
            $userDataByLegacyId = $importedUsers->keyBy('legacy_id');

            $imagesByCarId = collect($legacyCarImages)
                ->groupBy('car_id')
                ->map(function ($rows) {
                    return collect($rows)
                        ->sortBy(fn (array $row) => (int) ($row['position'] ?? 0))
                        ->pluck('image_url')
                        ->filter(fn ($url) => filled($url))
                        ->values()
                        ->all();
                })
                ->all();

            $listingCount = $this->importListings($legacyCars, $userIdMap, $userDataByLegacyId->all(), $imagesByCarId);

            $listingIdMap = Listing::query()
                ->whereNotNull('legacy_id')
                ->pluck('id', 'legacy_id')
                ->all();

            $bookingCount = $this->importBookings($legacyBookings, $listingIdMap, $userDataByLegacyId->all());

            $savedListingCount = $this->importSavedListings($legacyWishlists, $legacyWishlistCars, $userIdMap, $listingIdMap);
            $this->promoteFeaturedListings();

            return [
                'users' => $userCount,
                'listings' => $listingCount,
                'bookings' => $bookingCount,
                'saved_listings' => $savedListingCount,
            ];
        });
    }

    /**
     * @return array<string, array{columns: array<int, string>, rows: array<int, array<int, mixed>>}>
     */
    protected function parseInsertStatements(string $sql): array
    {
        $offset = 0;
        $length = strlen($sql);
        $tables = [];

        while (($start = strpos($sql, 'INSERT INTO `', $offset)) !== false) {
            $tableStart = $start + strlen('INSERT INTO `');
            $tableEnd = strpos($sql, '`', $tableStart);

            if ($tableEnd === false) {
                break;
            }

            $table = substr($sql, $tableStart, $tableEnd - $tableStart);

            $columnsStart = strpos($sql, '(', $tableEnd);
            $columnsEnd = strpos($sql, ') VALUES', $columnsStart);
            $valuesKeyword = strpos($sql, ' VALUES', $columnsStart);

            if ($columnsStart === false || $columnsEnd === false || $valuesKeyword === false) {
                break;
            }

            $columnsString = substr($sql, $columnsStart + 1, $columnsEnd - $columnsStart - 1);
            $columns = array_map(
                static fn (string $column): string => trim($column, " \t\n\r\0\x0B`"),
                explode(',', $columnsString),
            );

            $valuesStart = $valuesKeyword + strlen(' VALUES');
            $statementEnd = $this->findStatementEnd($sql, $valuesStart);
            $valuesString = substr($sql, $valuesStart, $statementEnd - $valuesStart);

            $rows = $this->parseValueRows($valuesString);

            if (! isset($tables[$table])) {
                $tables[$table] = [
                    'columns' => $columns,
                    'rows' => [],
                ];
            }

            foreach ($rows as $row) {
                $tables[$table]['rows'][] = $row;
            }

            $offset = $statementEnd + 1;
            if ($offset >= $length) {
                break;
            }
        }

        return $tables;
    }

    protected function findStatementEnd(string $sql, int $offset): int
    {
        $length = strlen($sql);
        $inString = false;
        $escaped = false;

        for ($i = $offset; $i < $length; $i++) {
            $char = $sql[$i];

            if ($inString) {
                if ($escaped) {
                    $escaped = false;
                    continue;
                }

                if ($char === '\\') {
                    $escaped = true;
                    continue;
                }

                if ($char === "'") {
                    if (($sql[$i + 1] ?? null) === "'") {
                        $i++;
                        continue;
                    }

                    $inString = false;
                }

                continue;
            }

            if ($char === "'") {
                $inString = true;
                continue;
            }

            if ($char === ';') {
                return $i;
            }
        }

        return $length;
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function parseValueRows(string $values): array
    {
        $rows = [];
        $currentRow = [];
        $token = '';
        $inString = false;
        $rowOpen = false;
        $escaped = false;
        $tokenWasQuoted = false;
        $length = strlen($values);

        for ($i = 0; $i < $length; $i++) {
            $char = $values[$i];

            if ($inString) {
                if ($escaped) {
                    $token .= $this->decodeEscapedCharacter($char);
                    $escaped = false;
                    continue;
                }

                if ($char === '\\') {
                    $escaped = true;
                    continue;
                }

                if ($char === "'") {
                    if (($values[$i + 1] ?? null) === "'") {
                        $token .= "'";
                        $i++;
                        continue;
                    }

                    $inString = false;
                    continue;
                }

                $token .= $char;
                continue;
            }

            if (! $rowOpen) {
                if ($char === '(') {
                    $rowOpen = true;
                    $currentRow = [];
                    $token = '';
                    $tokenWasQuoted = false;
                }

                continue;
            }

            if ($char === "'") {
                $inString = true;
                $tokenWasQuoted = true;
                continue;
            }

            if ($char === ',') {
                $currentRow[] = $this->coerceSqlValue($token, $tokenWasQuoted);
                $token = '';
                $tokenWasQuoted = false;
                continue;
            }

            if ($char === ')') {
                $currentRow[] = $this->coerceSqlValue($token, $tokenWasQuoted);
                $rows[] = $currentRow;
                $currentRow = [];
                $token = '';
                $rowOpen = false;
                $tokenWasQuoted = false;
                continue;
            }

            if (trim($char) === '' && $token === '') {
                continue;
            }

            $token .= $char;
        }

        return $rows;
    }

    protected function decodeEscapedCharacter(string $char): string
    {
        return match ($char) {
            'n' => "\n",
            'r' => "\r",
            't' => "\t",
            '0' => "\0",
            default => $char,
        };
    }

    protected function coerceSqlValue(string $value, bool $wasQuoted = false): mixed
    {
        if ($wasQuoted) {
            return $value;
        }

        $value = trim($value);

        if ($value === '' || strtoupper($value) === 'NULL') {
            return null;
        }

        if (preg_match('/^-?\d+$/', $value) === 1) {
            return (int) $value;
        }

        if (preg_match('/^-?\d+\.\d+$/', $value) === 1) {
            return (float) $value;
        }

        return $value;
    }

    /**
     * @param  array<string, array{columns: array<int, string>, rows: array<int, array<int, mixed>>}>  $tables
     * @return array<int, array<string, mixed>>
     */
    protected function tableRows(array $tables, string $table): array
    {
        if (! isset($tables[$table])) {
            return [];
        }

        return array_map(function (array $row) use ($tables, $table): array {
            return array_combine($tables[$table]['columns'], $row);
        }, $tables[$table]['rows']);
    }

    protected function clearMarketplaceTables(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('listing_user')->delete();
        DB::table('bookings')->delete();
        DB::table('listings')->delete();
        DB::table('users')->delete();

        Schema::enableForeignKeyConstraints();
    }

    /**
     * @param  array<int, array<string, mixed>>  $legacyUsers
     * @param  array<int, string>  $sellerLegacyIds
     */
    protected function importUsers(array $legacyUsers, array $sellerLegacyIds): int
    {
        $count = 0;
        $usedEmails = [];

        foreach ($legacyUsers as $legacyUser) {
            $legacyId = (string) ($legacyUser['_id'] ?? '');

            if ($legacyId === '') {
                continue;
            }

            $email = $this->resolveLegacyEmail((string) ($legacyUser['email'] ?? ''), $legacyId, $usedEmails);
            $role = $this->mapLegacyRole((string) ($legacyUser['role'] ?? ''), in_array($legacyId, $sellerLegacyIds, true));
            $phone = $this->nullableString($legacyUser['phone'] ?? null);

            DB::table('users')->updateOrInsert(
                ['legacy_id' => $legacyId],
                [
                    'name' => $this->legacyUserName($legacyUser),
                    'email' => $email,
                    'email_verified_at' => $email ? $this->normalizeTimestamp($legacyUser['createdAt'] ?? null) : null,
                    'password' => $this->normalizePasswordHash($legacyUser['password'] ?? null),
                    'role' => $role->value,
                    'phone' => $phone,
                    'whatsapp_number' => $phone,
                    'company_name' => null,
                    'country' => null,
                    'city' => null,
                    'bio' => $this->legacyBio($legacyUser),
                    'remember_token' => null,
                    'created_at' => $this->normalizeTimestamp($legacyUser['createdAt'] ?? null),
                    'updated_at' => $this->normalizeTimestamp($legacyUser['updatedAt'] ?? null),
                ],
            );

            $count++;
        }

        return $count;
    }

    /**
     * @param  array<int, array<string, mixed>>  $legacyCars
     * @param  array<string, int>  $userIdMap
     * @param  array<string, User>  $userDataByLegacyId
     * @param  array<string, array<int, string>>  $imagesByCarId
     */
    protected function importListings(
        array $legacyCars,
        array $userIdMap,
        array $userDataByLegacyId,
        array $imagesByCarId,
    ): int {
        $count = 0;
        $fallbackUserId = User::query()->orderBy('id')->value('id');

        foreach ($legacyCars as $legacyCar) {
            $legacyId = (string) ($legacyCar['_id'] ?? '');

            if ($legacyId === '') {
                continue;
            }

            $ownerLegacyId = (string) ($legacyCar['owner'] ?? '');
            $seller = $ownerLegacyId !== '' ? ($userDataByLegacyId[$ownerLegacyId] ?? null) : null;
            $userId = $userIdMap[$ownerLegacyId] ?? $fallbackUserId;

            if ($userId === null) {
                continue;
            }

            $title = $this->buildListingTitle($legacyCar);
            $location = $this->normalizeLocation((string) ($legacyCar['location'] ?? ''));
            $gallery = $this->buildGallery($legacyCar, $imagesByCarId[$legacyId] ?? []);
            $coverImage = $this->resolveCoverImage($legacyCar, $gallery);
            $availability = $this->normalizeAvailability((string) ($legacyCar['status'] ?? ''));
            $price = $this->normalizeDecimal($legacyCar['price'] ?? null);
            $details = array_filter([
                'year' => $legacyCar['year'] ?? null,
                'make' => $this->nullableString($legacyCar['make'] ?? null),
                'model' => $this->nullableString($legacyCar['model'] ?? null),
                'body_type' => $this->nullableString($legacyCar['bodyType'] ?? null),
                'fuel_type' => $this->nullableString($legacyCar['fuelType'] ?? null),
                'transmission' => $this->nullableString($legacyCar['transmission'] ?? null),
                'color' => $this->nullableString($legacyCar['color'] ?? null),
                'mileage_km' => $legacyCar['mileage'] ?? null,
            ], fn ($value) => filled($value));

            $highlights = array_values(array_filter([
                $this->nullableString($legacyCar['bodyType'] ?? null),
                $this->nullableString($legacyCar['fuelType'] ?? null),
                $this->nullableString($legacyCar['transmission'] ?? null),
                filled($legacyCar['year'] ?? null) ? (string) $legacyCar['year'] : null,
            ]));

            DB::table('listings')->updateOrInsert(
                ['legacy_id' => $legacyId],
                [
                    'user_id' => $userId,
                    'title' => $title,
                    'slug' => $this->buildUniqueSlug($title, $legacyId),
                    'type' => ListingType::Vehicle->value,
                    'transaction_type' => 'sale',
                    'status' => $this->mapLegacyListingStatus($availability)->value,
                    'availability' => $availability,
                    'country' => $location['country'],
                    'city' => $location['city'],
                    'area' => $location['area'],
                    'price' => $price,
                    'salary_min' => null,
                    'salary_max' => null,
                    'currency' => 'RWF',
                    'description' => $this->buildListingDescription($legacyCar, $title),
                    'contact_name' => $seller?->name,
                    'whatsapp_number' => $seller?->whatsapp_number ?: $seller?->phone,
                    'cover_image' => $coverImage,
                    'gallery' => $this->encodeJson($gallery),
                    'details' => $this->encodeJson($details),
                    'highlights' => $this->encodeJson($highlights),
                    'is_featured' => false,
                    'is_verified' => filled($seller?->whatsapp_number) || $seller?->role === UserRole::Admin,
                    'published_at' => $this->normalizeTimestamp($legacyCar['updatedAt'] ?? $legacyCar['createdAt'] ?? null),
                    'created_at' => $this->normalizeTimestamp($legacyCar['createdAt'] ?? null),
                    'updated_at' => $this->normalizeTimestamp($legacyCar['updatedAt'] ?? null),
                ],
            );

            $count++;
        }

        return $count;
    }

    /**
     * @param  array<int, array<string, mixed>>  $legacyBookings
     * @param  array<string, int>  $listingIdMap
     * @param  array<string, User>  $userDataByLegacyId
     */
    protected function importBookings(array $legacyBookings, array $listingIdMap, array $userDataByLegacyId): int
    {
        $count = 0;

        foreach ($legacyBookings as $legacyBooking) {
            $legacyId = (string) ($legacyBooking['_id'] ?? '');
            $listingId = $listingIdMap[(string) ($legacyBooking['car'] ?? '')] ?? null;

            if ($legacyId === '' || $listingId === null) {
                continue;
            }

            $legacyUserId = (string) ($legacyBooking['user'] ?? '');
            $legacyUser = $legacyUserId !== '' ? ($userDataByLegacyId[$legacyUserId] ?? null) : null;

            DB::table('bookings')->updateOrInsert(
                ['legacy_id' => $legacyId],
                [
                    'listing_id' => $listingId,
                    'client_name' => $legacyUser?->name ?? 'Legacy booking',
                    'client_contact' => $legacyUser?->whatsapp_number ?: $legacyUser?->phone ?: $legacyUser?->email,
                    'start_date' => $this->normalizeDate($legacyBooking['createdAt'] ?? null),
                    'end_date' => $this->normalizeDate($legacyBooking['expiresAt'] ?? $legacyBooking['createdAt'] ?? null),
                    'status' => $this->nullableString($legacyBooking['status'] ?? null) ?: 'pending',
                    'total_price' => null,
                    'notes' => $this->nullableString($legacyBooking['notes'] ?? null),
                    'created_at' => $this->normalizeTimestamp($legacyBooking['createdAt'] ?? null),
                    'updated_at' => $this->normalizeTimestamp($legacyBooking['updatedAt'] ?? null),
                ],
            );

            $count++;
        }

        return $count;
    }

    /**
     * @param  array<int, array<string, mixed>>  $legacyWishlists
     * @param  array<int, array<string, mixed>>  $legacyWishlistCars
     * @param  array<string, int>  $userIdMap
     * @param  array<string, int>  $listingIdMap
     */
    protected function importSavedListings(
        array $legacyWishlists,
        array $legacyWishlistCars,
        array $userIdMap,
        array $listingIdMap,
    ): int {
        $wishlistOwners = [];
        $wishlistTimestamps = [];

        foreach ($legacyWishlists as $wishlist) {
            $wishlistId = (string) ($wishlist['_id'] ?? '');
            $userLegacyId = (string) ($wishlist['user'] ?? '');

            if ($wishlistId === '' || ! isset($userIdMap[$userLegacyId])) {
                continue;
            }

            $wishlistOwners[$wishlistId] = $userIdMap[$userLegacyId];
            $wishlistTimestamps[$wishlistId] = $this->normalizeTimestamp($wishlist['updatedAt'] ?? $wishlist['createdAt'] ?? null);
        }

        $existingPairs = DB::table('listing_user')
            ->select('user_id', 'listing_id')
            ->get()
            ->map(fn ($row) => $row->user_id.':'.$row->listing_id)
            ->all();

        $seenPairs = array_fill_keys($existingPairs, true);
        $payload = [];

        foreach ($legacyWishlistCars as $wishlistCar) {
            $wishlistId = (string) ($wishlistCar['wishlist_id'] ?? '');
            $userId = $wishlistOwners[$wishlistId] ?? null;
            $listingId = $listingIdMap[(string) ($wishlistCar['car_id'] ?? '')] ?? null;

            if ($userId === null || $listingId === null) {
                continue;
            }

            $pairKey = $userId.':'.$listingId;

            if (isset($seenPairs[$pairKey])) {
                continue;
            }

            $seenPairs[$pairKey] = true;
            $timestamp = $wishlistTimestamps[$wishlistId] ?? now()->toDateTimeString();

            $payload[] = [
                'user_id' => $userId,
                'listing_id' => $listingId,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        if ($payload !== []) {
            DB::table('listing_user')->insert($payload);
        }

        return count($payload);
    }

    protected function promoteFeaturedListings(): void
    {
        DB::table('listings')->update(['is_featured' => false]);

        $featuredIds = Listing::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(6)
            ->pluck('id');

        if ($featuredIds->isEmpty()) {
            return;
        }

        DB::table('listings')
            ->whereIn('id', $featuredIds)
            ->update(['is_featured' => true]);
    }

    protected function resolveLegacyEmail(string $email, string $legacyId, array &$usedEmails): string
    {
        $email = Str::lower(trim($email));

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = "legacy-{$legacyId}@legacy.connectify.local";
        }

        $baseEmail = $email;
        $suffix = 1;

        while (
            isset($usedEmails[$email]) ||
            User::query()
                ->where('email', $email)
                ->where(function ($query) use ($legacyId) {
                    $query
                        ->where('legacy_id', '!=', $legacyId)
                        ->orWhereNull('legacy_id');
                })
                ->exists()
        ) {
            $localPart = Str::before($baseEmail, '@');
            $domain = Str::after($baseEmail, '@');
            $email = "{$localPart}+{$suffix}@{$domain}";
            $suffix++;
        }

        $usedEmails[$email] = true;

        return $email;
    }

    /**
     * @param  array<string, mixed>  $legacyUser
     */
    protected function legacyUserName(array $legacyUser): string
    {
        $name = $this->nullableString($legacyUser['fullname'] ?? null);

        if ($name) {
            return $name;
        }

        $email = $this->nullableString($legacyUser['email'] ?? null);

        if ($email) {
            return Str::headline(Str::before($email, '@'));
        }

        return 'Legacy User';
    }

    /**
     * @param  array<string, mixed>  $legacyUser
     */
    protected function legacyBio(array $legacyUser): ?string
    {
        $parts = array_values(array_filter([
            $this->nullableString($legacyUser['driverLicense'] ?? null),
            $this->nullableString($legacyUser['drivingExperience'] ?? null),
        ]));

        if ($parts === []) {
            return null;
        }

        return implode(' | ', $parts);
    }

    protected function mapLegacyRole(string $legacyRole, bool $isSeller): UserRole
    {
        return match (Str::lower(trim($legacyRole))) {
            'admin' => UserRole::Admin,
            default => $isSeller ? UserRole::Seller : UserRole::Buyer,
        };
    }

    protected function normalizePasswordHash(mixed $password): string
    {
        $password = is_string($password) ? trim($password) : '';

        if ($password === '') {
            return bcrypt(Str::random(32));
        }

        if (str_starts_with($password, '$2b$')) {
            return '$2y$'.substr($password, 4);
        }

        return $password;
    }

    /**
     * @param  array<string, mixed>  $legacyCar
     */
    protected function buildListingTitle(array $legacyCar): string
    {
        $parts = array_values(array_filter([
            filled($legacyCar['year'] ?? null) ? (string) $legacyCar['year'] : null,
            $this->nullableString($legacyCar['make'] ?? null),
            $this->nullableString($legacyCar['model'] ?? null),
        ]));

        if ($parts !== []) {
            return implode(' ', $parts);
        }

        return 'Legacy Vehicle';
    }

    protected function buildUniqueSlug(string $title, string $legacyId): string
    {
        $suffix = Str::lower(substr($legacyId, -8));
        $base = Str::slug($title);
        $slug = trim($base.'-'.$suffix, '-');

        return Str::limit($slug, 255, '');
    }

    /**
     * @param  array<string, mixed>  $legacyCar
     * @param  array<int, string>  $gallery
     */
    protected function resolveCoverImage(array $legacyCar, array $gallery): ?string
    {
        $cover = $this->nullableString($legacyCar['primaryImage'] ?? null);

        if ($cover) {
            return $cover;
        }

        return $gallery[0] ?? 'https://placehold.co/1200x800?text=Connectify';
    }

    /**
     * @param  array<string, mixed>  $legacyCar
     * @param  array<int, string>  $carImages
     * @return array<int, string>
     */
    protected function buildGallery(array $legacyCar, array $carImages): array
    {
        $images = collect($carImages);
        $primary = $this->nullableString($legacyCar['primaryImage'] ?? null);

        if ($primary) {
            $images->prepend($primary);
        }

        return $images
            ->filter(fn ($image) => filled($image))
            ->unique()
            ->values()
            ->all();
    }

    protected function normalizeAvailability(string $status): string
    {
        $status = Str::lower(trim($status));

        return match ($status) {
            'listed' => 'available',
            'booked' => 'reserved',
            default => $status !== '' ? $status : 'available',
        };
    }

    protected function mapLegacyListingStatus(string $availability): ListingStatus
    {
        return match ($availability) {
            'deleted', 'archived', 'sold' => ListingStatus::Archived,
            default => ListingStatus::Published,
        };
    }

    /**
     * @return array{country:string,city:string,area:?string}
     */
    protected function normalizeLocation(string $location): array
    {
        $location = trim($location);

        if ($location === '') {
            return [
                'country' => 'Rwanda',
                'city' => 'Kigali',
                'area' => null,
            ];
        }

        $location = preg_replace('/\s+/', ' ', $location) ?? $location;
        $normalized = Str::lower($location);

        if (str_contains($normalized, 'kigali')) {
            $parts = array_map('trim', explode(',', $location, 2));

            return [
                'country' => 'Rwanda',
                'city' => 'Kigali',
                'area' => count($parts) > 1 ? $parts[1] : null,
            ];
        }

        if (in_array($normalized, ['rwanda', 'uganda', 'burundi', 'drc', 'kenya', 'tanzania', 'south sudan', 'uae'], true)) {
            return [
                'country' => Str::upper($normalized) === 'UAE' ? 'UAE' : Str::headline($location),
                'city' => $this->defaultCityForCountry(Str::upper($normalized) === 'UAE' ? 'UAE' : Str::headline($location)),
                'area' => null,
            ];
        }

        return [
            'country' => Str::title($location),
            'city' => Str::title($location),
            'area' => null,
        ];
    }

    protected function defaultCityForCountry(string $country): string
    {
        return match ($country) {
            'UAE' => 'Dubai',
            'Uganda' => 'Kampala',
            'Burundi' => 'Bujumbura',
            'DRC' => 'Goma',
            'Kenya' => 'Nairobi',
            'Tanzania' => 'Dar es Salaam',
            'South Sudan' => 'Juba',
            default => 'Kigali',
        };
    }

    /**
     * @param  array<string, mixed>  $legacyCar
     */
    protected function buildListingDescription(array $legacyCar, string $title): string
    {
        $description = $this->nullableString($legacyCar['description'] ?? null);

        if ($description) {
            return $description;
        }

        $parts = array_values(array_filter([
            $title,
            $this->nullableString($legacyCar['bodyType'] ?? null),
            $this->nullableString($legacyCar['fuelType'] ?? null),
            $this->nullableString($legacyCar['transmission'] ?? null),
        ]));

        return implode(' | ', $parts);
    }

    protected function normalizeTimestamp(mixed $value): ?string
    {
        $string = $this->nullableString($value);

        if (! $string) {
            return null;
        }

        return Carbon::parse($string)->toDateTimeString();
    }

    protected function normalizeDate(mixed $value): string
    {
        $string = $this->nullableString($value);

        return $string ? Carbon::parse($string)->toDateString() : now()->toDateString();
    }

    protected function normalizeDecimal(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return number_format((float) $value, 2, '.', '');
    }

    /**
     * @param  array<string, mixed>|array<int, mixed>  $value
     */
    protected function encodeJson(array $value): ?string
    {
        if ($value === []) {
            return null;
        }

        return json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    protected function nullableString(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
