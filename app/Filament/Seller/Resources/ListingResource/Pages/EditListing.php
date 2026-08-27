<?php

namespace App\Filament\Seller\Resources\ListingResource\Pages;

use App\Filament\Seller\Resources\ListingResource;
use App\Models\Listing;
use App\Support\ListingUpdateData;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditListing extends EditRecord
{
    protected static string $resource = ListingResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->id();
        unset($data['is_featured'], $data['is_verified']);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        /** @var Listing $record */
        $record->update(ListingUpdateData::onlyChanged($data, $record));

        return $record;
    }
}