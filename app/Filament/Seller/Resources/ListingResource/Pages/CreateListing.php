<?php

namespace App\Filament\Seller\Resources\ListingResource\Pages;

use App\Filament\Seller\Resources\ListingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateListing extends CreateRecord
{
    protected static string $resource = ListingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['is_featured'] = false;
        $data['is_verified'] = false;

        return $data;
    }
}