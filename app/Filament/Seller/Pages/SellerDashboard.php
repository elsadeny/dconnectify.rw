<?php

namespace App\Filament\Seller\Pages;

use App\Filament\Seller\Widgets\SellerOverview;
use App\Filament\Seller\Widgets\SellerWorkspace;
use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Contracts\View\View;
use Filament\Pages\Dashboard as BaseDashboard;

class SellerDashboard extends BaseDashboard
{
    protected static ?string $title = 'Seller Dashboard';

    public function getColumns(): int | array
    {
        return 1;
    }

    public function getHeader(): ?View
    {
        $listingQuery = Listing::query()->where('user_id', auth()->id());

        return view('filament.seller.dashboard-header', [
            'stats' => [
                'listings' => (clone $listingQuery)->count(),
                'published' => (clone $listingQuery)->where('status', 'published')->count(),
                'pending' => (clone $listingQuery)->whereIn('status', ['draft', 'pending'])->count(),
                'bookings' => Booking::query()
                    ->whereHas('listing', fn ($query) => $query->where('user_id', auth()->id()))
                    ->count(),
            ],
        ]);
    }

    public function getWidgets(): array
    {
        return [
            SellerOverview::class,
            SellerWorkspace::class,
        ];
    }
}
