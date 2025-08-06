<?php

namespace App\Filament\Pages\Auth;

use App\Mail\OtpMail;
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
use Illuminate\Support\Facades\Mail;

class EditProfile extends BaseEditProfile implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.profile';

    protected static ?string $navigationLabel = 'Profil Saya';

    public ?array $profileData = [];
    public ?array $passwordData = [];
    public ?array $otpData = [];
    public bool $isOtpStep = false;

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return ['editProfileForm', 'editPasswordForm', 'otpForm'];
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

    public function otpForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Verifikasi OTP')
                    ->schema([
                        TextInput::make('otp')
                            ->label('Kode OTP')
                            ->numeric()
                            ->length(6)
                            ->required(),
                    ])
            ])
            ->statePath('otpData');
    }

    public function updateProfile(): void
    {
        $this->getUser()->update($this->profileData);
        Notification::make()
            ->title('Profil berhasil diperbarui.')
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

        session([
            'otp_user_id' => $this->getUser()->id,
            'otp_new_password' => Hash::make($this->passwordData['password']),
        ]);

        $this->passwordData = [];

        $otp = rand(100000, 999999);

        $this->getUser()->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::to($this->getUser()->email)->send(new OtpMail($otp, $this->getUser()->name));
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal mengirimkan OTP ke email yang bersangkutan.')
                ->danger()
                ->send();
            return;
        }

        $this->isOtpStep = true;

        Notification::make()
            ->title('Kode OTP telah dikirim ke email Anda.')
            ->success()
            ->send();
    }

    public function verifyOtp(): void
    {
        $user = $this->getUser();
        $otpInput = $this->otpData['otp'] ?? null;

        if (
            $user->otp !== $otpInput ||
            $user->otp_expires_at->isPast()
        ) {
            $this->addError('otpData.otp', 'OTP tidak valid atau telah kedaluwarsa.');
            return;
        }

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        $user->password = session('otp_new_password');
        $user->save();

        session()->forget(['otp_user_id', 'otp_new_password']);
        $this->otpData = [];
        $this->isOtpStep = false;

        Notification::make()
            ->title('Password berhasil diubah.')
            ->success()
            ->send();
    }


    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('save')->label('Simpan')->submit('updateProfile')
        ];
    }

    protected function getOtpFormActions(): array
    {
        return [
            Action::make('verify')->label('Verifikasi OTP')->submit('verifyOtp'),
        ];
    }


    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('change')->label('Ganti Password')->submit('updatePassword')
        ];
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
