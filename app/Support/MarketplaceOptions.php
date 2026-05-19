<?php

namespace App\Support;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Enums\UserRole;
use App\Models\Listing;
use Illuminate\Support\Facades\Schema;

class MarketplaceOptions
{
    public static function countryOptions(): array
    {
        $countries = [
            'Rwanda' => 'Rwanda',
            'Uganda' => 'Uganda',
            'Burundi' => 'Burundi',
            'DRC' => 'DRC',
            'Kenya' => 'Kenya',
            'Tanzania' => 'Tanzania',
            'South Sudan' => 'South Sudan',
            'UAE' => 'UAE',
        ];

        if (! Schema::hasTable('listings')) {
            return $countries;
        }

        return array_replace(
            $countries,
            Listing::query()
                ->whereNotNull('country')
                ->where('country', '!=', '')
                ->distinct()
                ->orderBy('country')
                ->pluck('country', 'country')
                ->all(),
        );
    }

    public static function cityOptions(?string $country = null): array
    {
        $cities = [
            'Rwanda' => [
                'Kigali' => 'Kigali',
                'Huye' => 'Huye',
                'Musanze' => 'Musanze',
                'Rubavu' => 'Rubavu',
                'Rusizi' => 'Rusizi',
                'Rwamagana' => 'Rwamagana',
            ],
            'Uganda' => [
                'Kampala' => 'Kampala',
                'Entebbe' => 'Entebbe',
                'Jinja' => 'Jinja',
                'Mbarara' => 'Mbarara',
                'Gulu' => 'Gulu',
                'Mbale' => 'Mbale',
            ],
            'Burundi' => [
                'Bujumbura' => 'Bujumbura',
                'Gitega' => 'Gitega',
                'Ngozi' => 'Ngozi',
                'Rumonge' => 'Rumonge',
                'Muyinga' => 'Muyinga',
                'Kayanza' => 'Kayanza',
            ],
            'DRC' => [
                'Goma' => 'Goma',
                'Bukavu' => 'Bukavu',
                'Kinshasa' => 'Kinshasa',
                'Lubumbashi' => 'Lubumbashi',
                'Kisangani' => 'Kisangani',
                'Kolwezi' => 'Kolwezi',
            ],
            'Kenya' => [
                'Nairobi' => 'Nairobi',
                'Mombasa' => 'Mombasa',
                'Kisumu' => 'Kisumu',
                'Nakuru' => 'Nakuru',
                'Eldoret' => 'Eldoret',
                'Thika' => 'Thika',
            ],
            'Tanzania' => [
                'Dar es Salaam' => 'Dar es Salaam',
                'Arusha' => 'Arusha',
                'Dodoma' => 'Dodoma',
                'Mwanza' => 'Mwanza',
                'Mbeya' => 'Mbeya',
                'Zanzibar City' => 'Zanzibar City',
            ],
            'South Sudan' => [
                'Juba' => 'Juba',
                'Wau' => 'Wau',
                'Malakal' => 'Malakal',
                'Yei' => 'Yei',
                'Aweil' => 'Aweil',
                'Bor' => 'Bor',
            ],
            'UAE' => [
                'Dubai' => 'Dubai',
                'Abu Dhabi' => 'Abu Dhabi',
                'Sharjah' => 'Sharjah',
            ],
        ];

        if (Schema::hasTable('listings')) {
            $dynamicCities = Listing::query()
                ->whereNotNull('country')
                ->where('country', '!=', '')
                ->whereNotNull('city')
                ->where('city', '!=', '')
                ->select('country', 'city')
                ->distinct()
                ->orderBy('city')
                ->get()
                ->groupBy('country')
                ->map(fn ($group) => $group->pluck('city', 'city')->all())
                ->all();

            foreach ($dynamicCities as $countryName => $countryCities) {
                $cities[$countryName] = array_replace($cities[$countryName] ?? [], $countryCities);
            }
        }

        if ($country !== null) {
            return $cities[$country] ?? [];
        }

        return $cities;
    }

    public static function listingTypeOptions(): array
    {
        return collect(ListingType::cases())
            ->mapWithKeys(fn (ListingType $type) => [$type->value => $type->label()])
            ->all();
    }

    public static function listingStatusOptions(): array
    {
        return collect(ListingStatus::cases())
            ->mapWithKeys(fn (ListingStatus $status) => [$status->value => $status->label()])
            ->all();
    }

    public static function userRoleOptions(): array
    {
        return collect(UserRole::cases())
            ->mapWithKeys(fn (UserRole $role) => [$role->value => $role->label()])
            ->all();
    }

    public static function transactionTypeOptions(): array
    {
        return [
            'sale' => 'Sale',
            'rent' => 'Rent',
            'hire' => 'Hire',
            'service' => 'Service',
        ];
    }
}
