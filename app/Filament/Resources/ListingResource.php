<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListingResource\Pages\CreateListing;
use App\Filament\Resources\ListingResource\Pages\EditListing;
use App\Filament\Resources\ListingResource\Pages\ListListings;
use App\Models\Listing;
use App\Support\MarketplaceOptions;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string|\UnitEnum|null $navigationGroup = 'Marketplace';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Listing details')
            ->columns(2)
            ->schema([
                Select::make('user_id')
                ->label('Seller')
                ->relationship('seller', 'name')
                ->searchable()
                ->preload()
                ->required(),
                TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
                TextInput::make('slug')
                ->maxLength(255),
                Select::make('type')
                ->options(MarketplaceOptions::listingTypeOptions())
                ->required(),
                Select::make('transaction_type')
                ->options(MarketplaceOptions::transactionTypeOptions())
                ->required(),
                Select::make('status')
                ->options(MarketplaceOptions::listingStatusOptions())
                ->required(),
                Select::make('availability')
                    ->options([
                        'available' => 'Available',
                        'sold' => 'Sold',
                    ])
                    ->default('available')
                    ->required(),
                Select::make('country')
                ->options(MarketplaceOptions::countryOptions())
                ->searchable()
                ->live()
                ->afterStateUpdated(fn($set) => $set('city', null))
                ->required(),
                Select::make('city')
                ->options(fn($get): array => MarketplaceOptions::cityOptions($get('country')))
                ->searchable()
                ->disabled(fn($get): bool => blank($get('country')))
                ->required(),
                TextInput::make('area'),
                TextInput::make('currency')->required()->default('USD')->maxLength(8),
                TextInput::make('price')->numeric(),
                TextInput::make('salary_min')->numeric(),
                TextInput::make('salary_max')->numeric(),
                Textarea::make('description')->rows(6)->required()->columnSpanFull(),
                TextInput::make('contact_name'),
                TextInput::make('whatsapp_number'),
                TextInput::make('cover_image')->url()->columnSpanFull()->live(onBlur: true),
                \Filament\Forms\Components\Placeholder::make('cover_image_preview')
                    ->label('Cover Image Preview')
                    ->content(fn ($get) => $get('cover_image') ? new \Illuminate\Support\HtmlString('<img src="' . htmlspecialchars($get('cover_image')) . '" style="max-height: 150px; border-radius: 8px; object-fit: contain;" />') : null)
                    ->visible(fn ($get) => filled($get('cover_image')))
                    ->columnSpanFull(),
                TagsInput::make('gallery')->separator(',')->columnSpanFull()->live(onBlur: true),
                \Filament\Forms\Components\Placeholder::make('gallery_preview')
                    ->label('Gallery Preview')
                    ->content(function ($get) {
                        $gallery = $get('gallery') ?? [];
                        if (is_string($gallery)) {
                            $gallery = explode(',', $gallery);
                        }
                        $html = '<div style="display: flex; gap: 10px; flex-wrap: wrap;">';
                        foreach ($gallery as $url) {
                            if (filled($url)) {
                                $html .= '<img src="' . htmlspecialchars(trim($url)) . '" style="max-height: 100px; border-radius: 8px; object-fit: contain;" />';
                            }
                        }
                        $html .= '</div>';
                        return new \Illuminate\Support\HtmlString($html);
                    })
                    ->visible(fn ($get) => filled($get('gallery')))
                    ->columnSpanFull(),
                TagsInput::make('highlights')->separator(',')->columnSpanFull(),
                KeyValue::make('details')->columnSpanFull(),
                DateTimePicker::make('published_at'),
                Toggle::make('is_featured'),
                Toggle::make('is_verified'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
            TextColumn::make('title')
            ->searchable()
            ->sortable()
            ->description(fn(Listing $record): string => $record->city . ', ' . $record->country),
            TextColumn::make('type')
            ->badge()
            ->formatStateUsing(fn($state): string => MarketplaceOptions::listingTypeOptions()[$state instanceof \BackedEnum ? $state->value : $state] ?? (string)($state instanceof \BackedEnum ? $state->value : $state)),
            TextColumn::make('transaction_type')->badge(),
            TextColumn::make('status')
            ->badge()
            ->formatStateUsing(fn($state): string => MarketplaceOptions::listingStatusOptions()[$state instanceof \BackedEnum ? $state->value : $state] ?? (string)($state instanceof \BackedEnum ? $state->value : $state)),
            TextColumn::make('availability')
                ->badge()
                ->colors([
                    'success' => 'available',
                    'danger' => 'sold',
                ]),
            TextColumn::make('seller.name')->label('Seller')->searchable(),
            TextColumn::make('formattedPrimaryValue')->label('Price / Salary'),
            IconColumn::make('is_verified')->boolean()->label('Verified'),
        ])
            ->actions([
            \Filament\Actions\EditAction::make(),
            \Filament\Actions\DeleteAction::make(),
        ])
            ->bulkActions([
            \Filament\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\ListingResource\RelationManagers\BookingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListListings::route('/'),
            'create' => CreateListing::route('/create'),
            'edit' => EditListing::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string)static::getModel()::query()->count();
    }
}