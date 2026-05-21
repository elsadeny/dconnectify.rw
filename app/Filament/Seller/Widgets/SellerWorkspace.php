<?php

namespace App\Filament\Seller\Widgets;

use App\Models\Booking;
use App\Models\Listing;
use Filament\Widgets\Widget;

class SellerWorkspace extends Widget
{
    protected string $view = 'filament.seller.widgets.seller-workspace';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $listingQuery = Listing::query()->where('user_id', auth()->id());

        return [
            'listingStates' => [
                ['label' => 'Ready to sell', 'count' => (clone $listingQuery)->where('status', 'published')->count()],
                ['label' => 'In draft', 'count' => (clone $listingQuery)->where('status', 'draft')->count()],
                ['label' => 'Awaiting review', 'count' => (clone $listingQuery)->where('status', 'pending')->count()],
                ['label' => 'Marked sold', 'count' => (clone $listingQuery)->where('availability', 'sold')->count()],
            ],
            'bookingStats' => [
                ['label' => 'Total bookings', 'count' => Booking::query()->whereHas('listing', fn ($query) => $query->where('user_id', auth()->id()))->count()],
                ['label' => 'Confirmed', 'count' => Booking::query()->whereHas('listing', fn ($query) => $query->where('user_id', auth()->id()))->where('status', 'confirmed')->count()],
            ],
        ];
    }
}
