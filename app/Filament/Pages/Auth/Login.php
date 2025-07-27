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
            'national_id' => config('app.env') === 'local' ? '3174011501950003' : '',
            'password' => config('app.env') === 'local' ? 'password' : '',
        ]);
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.national_id' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('national_id')
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
            'national_id' => $data['national_id'],
            'password' => $data['password'],
        ];
    }
}
