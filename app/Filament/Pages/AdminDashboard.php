<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminWorkspace;
use App\Filament\Widgets\MarketplaceOverview;
use App\Models\Booking;
use App\Models\Listing;
use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\View\View;

class AdminDashboard extends BaseDashboard
{
    protected static ?string $title = 'Admin Dashboard';

    public function getColumns(): int | array
    {
        return 1;
    }

    public function getHeader(): ?View
    {
        return view('filament.admin.dashboard-header', [
            'stats' => [
                'listings' => Listing::query()->count(),
                'pending' => Listing::query()->where('status', 'pending')->count(),
                'sellers' => User::query()->where('role', 'seller')->count(),
                'bookings' => Booking::query()->count(),
            ],
        ]);
    }

    public function getWidgets(): array
    {
        return [
            MarketplaceOverview::class,
            AdminWorkspace::class,
        ];
    }
}
