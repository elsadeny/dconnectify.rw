<?php

namespace App\Filament\Resources\ListingResource\Pages;

use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Filament\Resources\ListingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
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
            'car_sales' => Tab::make('Car sales')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('type', ListingType::Vehicle)
                    ->where('transaction_type', 'sale')),
            'car_hire' => Tab::make('Car hire')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('type', ListingType::Vehicle)
                    ->where('transaction_type', 'hire')),
            'homes_for_sale' => Tab::make('Estate sale')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('type', ListingType::Property)
                    ->where('transaction_type', 'sale')),
            'rentals' => Tab::make('Estate rent')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('type', ListingType::Property)
                    ->where('transaction_type', 'rent')),
            'jobs' => Tab::make('Jobs')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', ListingType::Job)),
            'services' => Tab::make('Services')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', ListingType::Service)),
            'rwanda' => Tab::make('Rwanda')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('country', 'Rwanda')),
            'kenya' => Tab::make('Kenya')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('country', 'Kenya')),
            'pending_review' => Tab::make('Pending review')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ListingStatus::Pending)),
            'drafts' => Tab::make('Drafts')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ListingStatus::Draft)),
            'live' => Tab::make('Live')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ListingStatus::Published)),
            'sold' => Tab::make('Sold')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('availability', 'sold')),
            'featured' => Tab::make('Featured')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_featured', true)),
            'verified' => Tab::make('Verified')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_verified', true)),
            'archived' => Tab::make('Archived')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', ListingStatus::Archived)),
        ];
    }
}
