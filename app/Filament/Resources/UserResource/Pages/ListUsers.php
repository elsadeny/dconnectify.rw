<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add account'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All accounts'),
            'sellers' => Tab::make('Sellers')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', UserRole::Seller)),
            'buyers' => Tab::make('Buyers')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', UserRole::Buyer)),
            'admins' => Tab::make('Admin team')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', UserRole::Admin)),
        ];
    }
}
