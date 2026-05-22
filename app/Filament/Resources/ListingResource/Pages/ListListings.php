<?php

namespace App\Filament\Resources\ListingResource\Pages;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Filament\Resources\ListingResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListListings extends ListRecords
{
    protected static string $resource = ListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create ad'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All ads'),
            'cars' => Tab::make('Cars')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', ListingType::Vehicle)),
            'homes_for_sale' => Tab::make('Homes for sale')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('type', ListingType::Property)
                    ->where('transaction_type', 'sale')),
            'rentals' => Tab::make('Rentals')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('type', ListingType::Property)
                    ->where('transaction_type', 'rent')),
            'jobs' => Tab::make('Jobs')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', ListingType::Job)),
            'services' => Tab::make('Services')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', ListingType::Service)),
            'pending_review' => Tab::make('Pending review')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ListingStatus::Pending)),
            'live' => Tab::make('Live')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ListingStatus::Published)),
            'sold' => Tab::make('Sold')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('availability', 'sold')),
            'featured' => Tab::make('Featured')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_featured', true)),
        ];
    }
}
