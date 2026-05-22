<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Tabs\Tab;
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

    public function getTabsContentComponent(): Component
    {
        return parent::getTabsContentComponent()->hidden();
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
            'verified_email' => Tab::make('Verified email')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('email_verified_at')),
            'companies' => Tab::make('Companies')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereNotNull('company_name')
                    ->where('company_name', '!=', '')),
            'whatsapp_ready' => Tab::make('WhatsApp')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereNotNull('whatsapp_number')
                    ->where('whatsapp_number', '!=', '')),
            'rwanda' => Tab::make('Rwanda')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('country', 'Rwanda')),
            'kenya' => Tab::make('Kenya')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('country', 'Kenya')),
        ];
    }
}
