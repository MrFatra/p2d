<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public static function isSimple(): bool
    {
        return false;
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return \Filament\Forms\Components\TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->dehydrated(false);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        \Filament\Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->minLength(16)
                            ->maxLength(16),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
                    ->inlineLabel(! static::isSimple()),
            ),
        ];
    }
}
