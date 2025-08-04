<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EditProfile extends BaseEditProfile implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.profile';

    protected static ?string $navigationLabel = 'Profil Saya';

    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return ['editProfileForm', 'editPasswordForm'];
    }

    public static function isSimple(): bool
    {
        return false;
    }

    public function editProfileForm(Form $form): Form
    {
        return $form->schema([
            Section::make('Data Akun')
                ->schema([
                    TextInput::make('family_card_number')
                        ->label('Nomor Kartu Keluarga')
                        ->required()
                        ->minLength(16)
                        ->maxLength(16),
                    TextInput::make('national_id')
                        ->label('NIK')
                        ->required()
                        ->minLength(16)
                        ->maxLength(16),
                    $this->getNameFormComponent()->autofocus(false),
                    DatePicker::make('birth_date')
                        ->native(false)
                        ->required()
                        ->label('Tanggal Lahir'),
                    ToggleButtons::make('gender')
                        ->required()
                        ->inline()
                        ->options([
                            'L' => 'Laki-Laki',
                            'P' => 'Perempuan'
                        ])
                        ->colors([
                            'L' => 'info',
                            'P' => 'pink'
                        ])
                        ->icons([
                            'L' => 'ionicon-male',
                            'P' => 'ionicon-female'
                        ]),
                    TextInput::make('phone_number')
                        ->label('Nomor Telepon')
                        ->required(),
                    TextInput::make('hamlet')
                        ->label('Dusun')
                        ->required(),
                    TextInput::make('rt')
                        ->label('RT')
                        ->required(),
                    TextInput::make('rw')
                        ->label('RW')
                        ->required(),
                    Textarea::make('address')
                        ->label('Alamat Lengkap')
                        ->required(),

                ])
        ])
            ->operation('edit')
            ->model($this->getUser())
            ->statePath('profileData')
            ->inlineLabel(!static::isSimple());
    }

    public function editPasswordForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Privasi & Keamanan Akun')
                    ->schema([
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
            ])
            ->statePath('passwordData');
    }

    public function updateProfile(): void
    {
        $this->getUser()->update($this->profileData);
        Notification::make()
            ->title('Profil berhasil diperbarui')
            ->success()
            ->send();
    }

    public function updatePassword(): void
    {
        if ($this->passwordData['password'] !== $this->passwordData['passwordConfirmation']) {
            $this->addError('passwordData.passwordConfirmation', 'Konfirmasi password tidak cocok.');
            return;
        } else {
            $this->resetErrorBag('passwordData.passwordConfirmation');
        }

        $this->getUser()->update([
            'password' => Hash::make($this->passwordData['password']),
        ]);

        $this->passwordData = [];

        Notification::make()
            ->title('Password berhasil diperbarui')
            ->success()
            ->send();
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [Action::make('save')->label('Simpan')->submit('updateProfile')];
    }

    protected function getUpdatePasswordFormActions(): array
    {
        return [Action::make('change')->label('Ganti Password')->submit('updatePassword')];
    }

    public function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (! $user instanceof Model) throw new \Exception('User harus model Eloquent.');
        return $user;
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->toArray();
        $this->editProfileForm->fill($data);
    }
}
