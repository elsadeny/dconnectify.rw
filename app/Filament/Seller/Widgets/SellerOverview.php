<?php

namespace App\Filament\Seller\Widgets;

use App\Enums\ListingStatus;
use App\Models\Booking;
use App\Models\Listing;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SellerOverview extends StatsOverviewWidget
{
    protected ?string $heading = 'Your connectify Performance';

    protected ?string $description = 'Track visibility, backlog, and buyer activity without leaving the dashboard.';

    protected function getStats(): array
    {
        $query = Listing::query()->where('user_id', auth()->id());
        $bookingQuery = Booking::query()->whereHas('listing', fn ($listingQuery) => $listingQuery->where('user_id', auth()->id()));

        return [
            Stat::make('Total listings', (clone $query)->count())
                ->description('All records you manage')
                ->descriptionIcon(Heroicon::OutlinedRectangleStack, IconPosition::Before)
                ->icon(Heroicon::OutlinedSquares2x2)
                ->chart([
                    (clone $query)->where('type', 'vehicle')->count(),
                    (clone $query)->where('type', 'property')->count(),
                    (clone $query)->where('type', 'job')->count(),
                    (clone $query)->where('type', 'service')->count(),
                ])
                ->color('primary'),
            Stat::make('Published', (clone $query)->where('status', ListingStatus::Published)->count())
                ->description('Visible to buyers')
                ->descriptionIcon(Heroicon::OutlinedEye, IconPosition::Before)
                ->icon(Heroicon::OutlinedGlobeAlt)
                ->chart([
                    (clone $query)->where('availability', 'available')->count(),
                    (clone $query)->where('availability', 'sold')->count(),
                ])
                ->color('success'),
            Stat::make('Draft or pending', (clone $query)->whereIn('status', [ListingStatus::Draft, ListingStatus::Pending])->count())
                ->description('Needs updates or review')
                ->descriptionIcon(Heroicon::OutlinedClock, IconPosition::Before)
                ->icon(Heroicon::OutlinedPencilSquare)
                ->chart([
                    (clone $query)->where('status', ListingStatus::Draft)->count(),
                    (clone $query)->where('status', ListingStatus::Pending)->count(),
                ])
                ->color('warning'),
            Stat::make('Bookings', (clone $bookingQuery)->count())
                ->description('Buyer actions on your listings')
                ->descriptionIcon(Heroicon::OutlinedCalendarDays, IconPosition::Before)
                ->icon(Heroicon::OutlinedClipboardDocumentList)
                ->chart([
                    (clone $bookingQuery)->where('status', 'pending')->count(),
                    (clone $bookingQuery)->where('status', 'confirmed')->count(),
                    (clone $bookingQuery)->where('status', 'completed')->count(),
                ])
                ->color('info'),
        ];
    }
}
