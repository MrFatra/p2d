<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{

    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'nik' => '',
            'password' => '',
        ]);
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.nik' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->autofocus()
                            ->autocomplete()
                            ->extraInputAttributes(['tabindex' => 1]),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'nik' => $data['nik'],
            'password' => $data['password'],
        ];
    }
}
