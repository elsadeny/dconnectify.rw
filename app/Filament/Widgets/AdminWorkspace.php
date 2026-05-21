<?php

namespace App\Filament\Widgets;

use App\Enums\ListingType;
use App\Models\Booking;
use App\Models\Listing;
use App\Models\User;
use Filament\Widgets\Widget;

class AdminWorkspace extends Widget
{
    protected string $view = 'filament.widgets.admin-workspace';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'typeCounts' => collect(ListingType::cases())->map(function (ListingType $type): array {
                return [
                    'label' => $type->label(),
                    'count' => Listing::query()->where('type', $type)->count(),
                ];
            }),
            'statusCounts' => [
                ['label' => 'Pending review', 'count' => Listing::query()->where('status', 'pending')->count()],
                ['label' => 'Published', 'count' => Listing::query()->where('status', 'published')->count()],
                ['label' => 'Archived', 'count' => Listing::query()->where('status', 'archived')->count()],
                ['label' => 'Bookings', 'count' => Booking::query()->count()],
            ],
            'sellerStats' => [
                ['label' => 'Verified sellers', 'count' => User::query()->where('role', 'seller')->whereNotNull('whatsapp_number')->count()],
                ['label' => 'Buyer accounts', 'count' => User::query()->where('role', 'buyer')->count()],
            ],
        ];
    }
}
