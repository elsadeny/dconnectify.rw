<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class JsonList implements CastsAttributes
{
    /**
     * @param  array<string, mixed>  $attributes
     * @return array<int, mixed>
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {
        return self::decode($value);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        $items = self::decode($value);

        return $items === [] ? null : json_encode(array_values($items));
    }

    /**
     * @return array<int, mixed>
     */
    public static function decode(mixed $value): array
    {
        if ($value === null || $value === '' || $value === []) {
            return [];
        }

        if (is_array($value)) {
            return self::cleanList($value);
        }

        if (! is_string($value)) {
            return [];
        }

        $value = trim($value);

        $decoded = json_decode($value, true);

        if (is_array($decoded)) {
            return self::cleanList($decoded);
        }

        if (is_string($decoded)) {
            return self::decode($decoded);
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return [$value];
        }

        return self::cleanList(explode(',', trim($value, "\"'")));
    }

    /**
     * @param  array<int|string, mixed>  $items
     * @return array<int, mixed>
     */
    protected static function cleanList(array $items): array
    {
        return collect($items)
            ->map(function (mixed $item): mixed {
                if (is_string($item)) {
                    return trim($item, " \t\n\r\0\x0B\"'");
                }

                return $item;
            })
            ->filter(fn (mixed $item): bool => $item !== null && $item !== '')
            ->values()
            ->all();
    }
}
