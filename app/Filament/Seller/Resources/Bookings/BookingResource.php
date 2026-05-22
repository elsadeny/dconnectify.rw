<?php

namespace App\Filament\Seller\Resources\Bookings;

use App\Filament\Seller\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Seller\Resources\Bookings\Pages\EditBooking;
use App\Filament\Seller\Resources\Bookings\Pages\ListBookings;
use App\Filament\Seller\Resources\Bookings\Schemas\BookingForm;
use App\Filament\Seller\Resources\Bookings\Tables\BookingsTable;
use App\Models\Booking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|\UnitEnum|null $navigationGroup = 'Selling';

    protected static ?string $navigationLabel = 'Booking Inbox';

    public static function form(Schema $schema): Schema
    {
        return BookingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('listing', function (Builder $query) {
            $query->where('user_id', auth()->id());
        });
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }
}
