<?php

namespace App\Filament\Seller\Auth;

use App\Enums\UserRole;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;

class Register extends BaseRegister
{
    protected Width | string | null $maxWidth = Width::TwoExtraLarge;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                $this->fullWidth($this->getNameFormComponent()),
                $this->fullWidth($this->getEmailFormComponent()),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])
            ->columns([
                'default' => 1,
                'sm' => 2,
            ]);
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['role'] = UserRole::Seller;

        return $data;
    }

    protected function fullWidth(Component $component): Component
    {
        return $component->columnSpanFull();
    }
}
