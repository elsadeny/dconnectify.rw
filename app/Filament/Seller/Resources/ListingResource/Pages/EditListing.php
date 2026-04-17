<?php

namespace App\Filament\Seller\Resources\ListingResource\Pages;

use App\Filament\Seller\Resources\ListingResource;
use Filament\Resources\Pages\EditRecord;

class EditListing extends EditRecord
{
    protected static string $resource = ListingResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->id();
        unset($data['is_featured'], $data['is_verified']);

        return $data;
    }
}