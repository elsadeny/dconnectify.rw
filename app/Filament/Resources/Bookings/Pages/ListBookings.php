<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Enums\ListingType;
use App\Filament\Resources\Bookings\BookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Create booking'),
        ];
    }

    public function getTabsContentComponent(): Component
    {
        return parent::getTabsContentComponent()->hidden();
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All bookings'),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending')),
            'confirmed' => Tab::make('Confirmed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'confirmed')),
            'completed' => Tab::make('Completed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')),
            'cancelled' => Tab::make('Cancelled')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'cancelled')),
            'cars' => Tab::make('Cars')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereHas('listing', fn (Builder $listingQuery) => $listingQuery->where('type', ListingType::Vehicle))),
            'estate' => Tab::make('Estate')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereHas('listing', fn (Builder $listingQuery) => $listingQuery->where('type', ListingType::Property))),
            'jobs' => Tab::make('Jobs')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereHas('listing', fn (Builder $listingQuery) => $listingQuery->where('type', ListingType::Job))),
            'services' => Tab::make('Services')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereHas('listing', fn (Builder $listingQuery) => $listingQuery->where('type', ListingType::Service))),
            'rent' => Tab::make('Rent')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereHas('listing', fn (Builder $listingQuery) => $listingQuery->where('transaction_type', 'rent'))),
            'sale' => Tab::make('Sale')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereHas('listing', fn (Builder $listingQuery) => $listingQuery->where('transaction_type', 'sale'))),
            'upcoming' => Tab::make('Upcoming')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('start_date', '>=', now()->toDateString())),
            'this_month' => Tab::make('This month')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereBetween('start_date', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])),
        ];
    }
}
