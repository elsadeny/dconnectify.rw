<?php

namespace App\Filament\Seller\Resources\ListingResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    protected static ?string $recordTitleAttribute = 'client_name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('client_name')
            ->required()
            ->maxLength(255),
            TextInput::make('client_contact')
            ->maxLength(255),
            DatePicker::make('start_date')
            ->required(),
            DatePicker::make('end_date')
            ->required(),
            Select::make('status')
            ->options([
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ])
            ->default('confirmed')
            ->required(),
            TextInput::make('total_price')
            ->numeric()
            ->prefix('$'),
            Textarea::make('notes')
            ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('client_name')
            ->columns([
            TextColumn::make('client_name')->searchable(),
            TextColumn::make('start_date')->date()->sortable(),
            TextColumn::make('end_date')->date()->sortable(),
            TextColumn::make('status')->badge()
            ->colors([
                'danger' => 'cancelled',
                'warning' => 'completed',
                'success' => 'confirmed',
            ]),
            TextColumn::make('total_price')->money(),
        ])
            ->filters([
            //
        ])
            ->headerActions([
            CreateAction::make(),
        ])
            ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ])
            ->bulkActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ]);
    }
}