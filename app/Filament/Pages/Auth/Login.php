<?php

namespace App\Filament\Pages\Auth;

use App\Forms\Components\Link;
use Filament\Forms\Components\Component;
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
                            ->minLength(16)
                            ->maxLength(16)
                            ->autocomplete()
                            ->rules(['digits:16'])
                            ->validationMessages([
                                'required' => 'NIK wajib diisi.',
                                'numeric' => 'NIK harus berupa angka.',
                                'min' => 'NIK minimal harus terdiri dari 16 digit.',
                                'max' => 'NIK maksimal harus terdiri dari 16 digit.',
                                'digits' => 'NIK harus tepat 16 digit.',
                            ])
                            ->extraInputAttributes(['tabindex' => 1]),
                        $this->getPasswordFormComponent(),

                        \Filament\Forms\Components\Field::make('auth_footer')
                            ->label(false)
                            ->view('forms.components.auth.footer')
                            ->childComponents([
                                $this->getRememberFormComponent()->key('remember'),
                                // self::getForgotPasswordComponent()->key('forgot'),
                            ])

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

    protected function getForgotPasswordComponent(): Component
    {
        return Link::make('forgot_password')
            ->label('Lupa Password?')
            ->href(route('password.index'))
            ->color('primary');
    }
}
