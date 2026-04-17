<?php

namespace App\Support;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Enums\UserRole;

class MarketplaceOptions
{
    public static function countryOptions(): array
    {
        return [
            'Rwanda' => 'Rwanda',
            'Uganda' => 'Uganda',
            'Burundi' => 'Burundi',
            'DRC' => 'DRC',
            'Kenya' => 'Kenya',
            'Tanzania' => 'Tanzania',
            'South Sudan' => 'South Sudan',
        ];
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
        ];

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