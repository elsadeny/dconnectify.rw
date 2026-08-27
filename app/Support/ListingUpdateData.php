<?php

namespace App\Support;

use App\Models\Listing;
use BackedEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ListingUpdateData
{
    /**
     * @var array<int, string>
     */
    protected static array $preserveWhenAccidentallyCleared = [
        'cover_image',
        'gallery',
        'highlights',
        'details',
    ];

    /**
     * Keep the existing listing values unless the submitted field actually changed.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function onlyChanged(array $data, Listing $listing): array
    {
        $changed = [];

        foreach ($data as $key => $value) {
            $current = $listing->{$key} ?? null;

            if (self::valuesEqual($current, $value)) {
                continue;
            }

            if (self::wasAccidentallyCleared($key, $value, $current, $data, $listing)) {
                continue;
            }

            $changed[$key] = $value;
        }

        return $changed;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function wasAccidentallyCleared(string $key, mixed $value, mixed $current, array $data, Listing $listing): bool
    {
        if (in_array($key, self::$preserveWhenAccidentallyCleared, true) && self::isEmpty($value) && ! self::isEmpty($current)) {
            return true;
        }

        if (
            $key === 'city'
            && blank($value)
            && filled($current)
            && (string) ($data['country'] ?? $listing->country) === (string) $listing->country
        ) {
            return true;
        }

        return false;
    }

    protected static function valuesEqual(mixed $current, mixed $incoming): bool
    {
        if ($current instanceof BackedEnum) {
            $current = $current->value;
        }

        if ($incoming instanceof BackedEnum) {
            $incoming = $incoming->value;
        }

        if ($current instanceof Carbon) {
            $current = $current->toJSON();
        }

        if ($incoming instanceof Carbon) {
            $incoming = $incoming->toJSON();
        }

        if (is_array($current) || is_array($incoming)) {
            return json_encode(self::normalizeArray($current)) === json_encode(self::normalizeArray($incoming));
        }

        if (is_bool($current) || is_bool($incoming)) {
            return (bool) $current === (bool) $incoming;
        }

        if (is_numeric($current) && is_numeric($incoming)) {
            return (float) $current === (float) $incoming;
        }

        return (string) ($current ?? '') === (string) ($incoming ?? '');
    }

    /**
     * @return array<int|string, mixed>
     */
    protected static function normalizeArray(mixed $value): array
    {
        if (! is_array($value)) {
            return Arr::wrap($value);
        }

        $normalized = [];

        foreach ($value as $key => $item) {
            $normalized[$key] = is_array($item) ? self::normalizeArray($item) : $item;
        }

        ksort($normalized);

        return $normalized;
    }

    protected static function isEmpty(mixed $value): bool
    {
        if ($value === null || $value === '' || $value === []) {
            return true;
        }

        if (is_array($value)) {
            return collect($value)->filter(fn (mixed $item): bool => filled($item))->isEmpty();
        }

        return blank($value);
    }
}
