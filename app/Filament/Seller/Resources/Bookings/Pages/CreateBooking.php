<?php

namespace App\Filament\Seller\Resources\Bookings\Pages;

use App\Filament\Seller\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;
}
