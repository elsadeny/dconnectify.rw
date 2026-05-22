<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Support\MarketplaceOptions;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('listing.title')
                    ->label('Listing')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client_name')
                    ->searchable(),
                TextColumn::make('client_contact')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('total_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ]),
                SelectFilter::make('listing_type')
                    ->label('Category')
                    ->options(MarketplaceOptions::listingTypeOptions())
                    ->query(fn (Builder $query, array $data) => $query->when(
                        filled($data['value'] ?? null),
                        fn (Builder $query) => $query->whereHas('listing', fn (Builder $listingQuery) => $listingQuery->where('type', $data['value']))
                    )),
                SelectFilter::make('transaction_type')
                    ->label('Intent')
                    ->options(MarketplaceOptions::transactionTypeOptions())
                    ->query(fn (Builder $query, array $data) => $query->when(
                        filled($data['value'] ?? null),
                        fn (Builder $query) => $query->whereHas('listing', fn (Builder $listingQuery) => $listingQuery->where('transaction_type', $data['value']))
                    )),
                SelectFilter::make('country')
                    ->options(MarketplaceOptions::countryOptions())
                    ->searchable()
                    ->query(fn (Builder $query, array $data) => $query->when(
                        filled($data['value'] ?? null),
                        fn (Builder $query) => $query->whereHas('listing', fn (Builder $listingQuery) => $listingQuery->where('country', $data['value']))
                    )),
                Filter::make('start_date')
                    ->schema([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $query, $date): Builder => $query->whereDate('start_date', '<=', $date));
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
