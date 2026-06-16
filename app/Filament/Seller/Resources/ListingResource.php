<?php

namespace App\Filament\Seller\Resources;

use App\Filament\Seller\Resources\ListingResource\Pages\CreateListing;
use App\Filament\Seller\Resources\ListingResource\Pages\EditListing;
use App\Filament\Seller\Resources\ListingResource\Pages\ListListings;
use App\Models\Listing;
use App\Support\ListingImageFields;
use App\Support\MarketplaceOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-briefcase';

    protected static string | \UnitEnum | null $navigationGroup = 'Selling';

    protected static ?string $navigationLabel = 'My Ads';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Your listing')
                ->columns(2)
                ->schema([
                    Hidden::make('user_id')->default(fn (): ?int => auth()->id()),
                    TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
                    Select::make('type')
                        ->options(MarketplaceOptions::listingTypeOptions())
                        ->required(),
                    Select::make('transaction_type')
                        ->options(MarketplaceOptions::transactionTypeOptions())
                        ->required(),
                    Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'pending' => 'Pending Review',
                            'published' => 'Published',
                        ])
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
                        ->afterStateUpdated(fn ($set) => $set('city', null))
                        ->required(),
                    Select::make('city')
                        ->options(fn ($get): array => MarketplaceOptions::cityOptions($get('country')))
                        ->searchable()
                        ->disabled(fn ($get): bool => blank($get('country')))
                        ->required(),
                    TextInput::make('area'),
                    TextInput::make('currency')->required()->default('USD')->maxLength(8),
                    TextInput::make('price')->numeric(),
                    TextInput::make('salary_min')->numeric(),
                    TextInput::make('salary_max')->numeric(),
                    Textarea::make('description')->rows(6)->required()->columnSpanFull(),
                    TextInput::make('contact_name')->default(fn (): ?string => auth()->user()?->name),
                    TextInput::make('whatsapp_number')->default(fn (): ?string => auth()->user()?->whatsapp_number),
                    ListingImageFields::coverImage(),
                    ListingImageFields::gallery(),
                    TagsInput::make('highlights')->separator(',')->columnSpanFull(),
                    KeyValue::make('details')->columnSpanFull(),
                    DateTimePicker::make('published_at'),
                    Toggle::make('is_featured')->disabled()->dehydrated(false),
                    Toggle::make('is_verified')->disabled()->dehydrated(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => MarketplaceOptions::listingTypeOptions()[$state instanceof \BackedEnum ? $state->value : $state] ?? (string) ($state instanceof \BackedEnum ? $state->value : $state)),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => MarketplaceOptions::listingStatusOptions()[$state instanceof \BackedEnum ? $state->value : $state] ?? (string) ($state instanceof \BackedEnum ? $state->value : $state)),
                TextColumn::make('availability')
                    ->badge()
                    ->colors([
                        'success' => 'available',
                        'danger' => 'sold',
                    ]),
                TextColumn::make('city'),
                TextColumn::make('formattedPrimaryValue')->label('Price / Salary'),
                TextColumn::make('updated_at')->since()->label('Updated'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(MarketplaceOptions::listingTypeOptions()),
                SelectFilter::make('transaction_type')
                    ->options(MarketplaceOptions::transactionTypeOptions()),
                SelectFilter::make('status')
                    ->options(MarketplaceOptions::listingStatusOptions()),
                SelectFilter::make('availability')
                    ->options([
                        'available' => 'Available',
                        'sold' => 'Sold',
                    ]),
                SelectFilter::make('country')
                    ->options(MarketplaceOptions::countryOptions())
                    ->searchable(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()?->isAdmin()) {
            return $query;
        }

        return $query->where('user_id', auth()->id());
    }

    public static function getRelations(): array
    {
        return [
            ListingResource\RelationManagers\BookingsRelationManager::class,
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
        return (string) static::getEloquentQuery()->count();
    }
}
