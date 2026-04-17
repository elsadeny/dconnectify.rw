<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MarketplaceOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Marketplace Snapshot';

    protected function getStats(): array
    {
        return [
            Stat::make('Published listings', Listing::query()->where('status', 'published')->count())
                ->description('Live across all markets')
                ->color('warning'),
            Stat::make('Verified sellers', User::query()->where('role', 'seller')->whereNotNull('whatsapp_number')->count())
                ->description('Ready for buyer chats')
                ->color('success'),
            Stat::make('Pending review', Listing::query()->where('status', 'pending')->count())
                ->description('Listings needing moderation')
                ->color('info'),
        ];
    }
}