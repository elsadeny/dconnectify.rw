<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Listing;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MarketplaceOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Marketplace Snapshot';

    protected ?string $description = 'A fast read on moderation pressure, seller quality, and booking flow.';

    protected function getStats(): array
    {
        $typeChart = [
            Listing::query()->where('type', 'vehicle')->count(),
            Listing::query()->where('type', 'property')->count(),
            Listing::query()->where('type', 'job')->count(),
            Listing::query()->where('type', 'service')->count(),
        ];

        return [
            Stat::make('Published listings', Listing::query()->where('status', 'published')->count())
                ->description('Live across all markets')
                ->descriptionIcon(Heroicon::OutlinedGlobeAlt, IconPosition::Before)
                ->icon(Heroicon::OutlinedRectangleStack)
                ->chart($typeChart)
                ->color('primary'),
            Stat::make('Verified sellers', User::query()->where('role', 'seller')->whereNotNull('whatsapp_number')->count())
                ->description('Ready for buyer chats')
                ->descriptionIcon(Heroicon::OutlinedCheckBadge, IconPosition::Before)
                ->icon(Heroicon::OutlinedUsers)
                ->chart([
                    User::query()->where('role', 'buyer')->count(),
                    User::query()->where('role', 'seller')->count(),
                    User::query()->where('role', 'admin')->count(),
                ])
                ->color('success'),
            Stat::make('Pending review', Listing::query()->where('status', 'pending')->count())
                ->description('Listings needing moderation')
                ->descriptionIcon(Heroicon::OutlinedClock, IconPosition::Before)
                ->icon(Heroicon::OutlinedShieldCheck)
                ->chart([
                    Listing::query()->where('status', 'draft')->count(),
                    Listing::query()->where('status', 'pending')->count(),
                    Listing::query()->where('status', 'archived')->count(),
                ])
                ->color('warning'),
            Stat::make('Bookings', Booking::query()->count())
                ->description('Marketplace activity logged')
                ->descriptionIcon(Heroicon::OutlinedCalendarDays, IconPosition::Before)
                ->icon(Heroicon::OutlinedClipboardDocumentList)
                ->chart([
                    Booking::query()->where('status', 'pending')->count(),
                    Booking::query()->where('status', 'confirmed')->count(),
                    Booking::query()->where('status', 'completed')->count(),
                ])
                ->color('info'),
        ];
    }
}
