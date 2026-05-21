<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use App\Support\MarketplaceOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'People';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('User profile')
            ->columns(2)
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('email')->email()->required()->maxLength(255),
                TextInput::make('password')
                ->password()
                ->dehydrated(fn(?string $state): bool => filled($state))
                ->required(fn(string $operation): bool => $operation === 'create'),
                Select::make('role')
                ->options(MarketplaceOptions::userRoleOptions())
                ->required(),
                TextInput::make('company_name'),
                TextInput::make('phone'),
                TextInput::make('whatsapp_number'),
                TextInput::make('country'),
                TextInput::make('city'),
                Textarea::make('bio')->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('role')
            ->badge()
            ->formatStateUsing(fn($state): string => MarketplaceOptions::userRoleOptions()[$state instanceof \BackedEnum ? $state->value : $state] ?? (string)($state instanceof \BackedEnum ? $state->value : $state)),
            TextColumn::make('company_name')->label('Company'),
            TextColumn::make('city')->searchable(),
            TextColumn::make('country')->searchable(),
        ])
            ->filters([
            SelectFilter::make('role')
                ->options(MarketplaceOptions::userRoleOptions()),
            SelectFilter::make('country')
                ->options(MarketplaceOptions::countryOptions())
                ->searchable(),
        ])
            ->actions([
            \Filament\Actions\EditAction::make(),
            \Filament\Actions\DeleteAction::make(),
        ])
            ->bulkActions([
            \Filament\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
