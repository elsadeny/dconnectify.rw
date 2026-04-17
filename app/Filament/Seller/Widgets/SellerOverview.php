<?php

namespace App\Filament\Seller\Widgets;

use App\Models\Listing;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SellerOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Your Connectify Performance';

    protected function getStats(): array
    {
        $query = Listing::query()->where('user_id', auth()->id());

        return [
            Stat::make('Total listings', (clone $query)->count())
                ->description('All records you manage')
                ->color('primary'),
            Stat::make('Published', (clone $query)->where('status', 'published')->count())
                ->description('Visible to buyers')
                ->color('success'),
            Stat::make('Draft or pending', (clone $query)->whereIn('status', ['draft', 'pending'])->count())
                ->description('Needs updates or review')
                ->color('warning'),
        ];
    }
}