<?php

namespace App\Filament\Seller\Resources\Bookings\Pages;

use App\Filament\Seller\Resources\Bookings\BookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Add booking'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All bookings'),
            'new_leads' => Tab::make('New leads')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending')),
            'confirmed' => Tab::make('Confirmed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'confirmed')),
            'completed' => Tab::make('Completed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')),
            'cancelled' => Tab::make('Cancelled')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'cancelled')),
            'upcoming' => Tab::make('Upcoming')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('start_date', '>=', now()->toDateString())),
        ];
    }
}
