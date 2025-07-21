<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nik',
        'no_kk',
        'name',
        'password',
        'birth_date',
        'age',
        'gender',
        'phone_number',
        'address',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->type_of_user = self::determineTypeOfUser($user->birth_date);
        });

        static::updating(function ($user) {
            if (empty($user->password)) {
                unset($user->password);
            }

            if ($user->isDirty('birth_date')) {
                $user->type_of_user = self::determineTypeOfUser($user->birth_date);
            }
        });
    }

    private static function determineTypeOfUser($userBirthDate)
    {
        if (empty($userBirthDate)) {
            return '-';
        }

        $now = now();
        $age = Carbon::parse($userBirthDate)->diffInYears($now);

        if ($age < 0) {
            return 'bayi';
        } elseif ($age < 5) {
            return 'balita';
        } elseif ($age < 12) {
            return 'anak';
        } elseif ($age < 18) {
            return 'remaja';
        } elseif ($age < 60) {
            return 'dewasa';
        } elseif ($age >= 60) {
            return 'lansia';
        } else {
            return '-';
        }
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    // Relasi untuk data remaja
public function teenager()
{
    return $this->hasOne(Teenagers::class);
}

// Relasi untuk data bayi
public function infant()
{
    return $this->hasOne(Infant::class);
}

// Relasi untuk data ibu hamil/nifas/menyusui
public function pregnantPostpartumBreastfeeding()
{
    return $this->hasOne(PregnantPostpartumBreastfeending::class);
}

// Relasi untuk data lansia
public function elderly()
{
    return $this->hasOne(Erderly::class);
}

// Relasi ke banyak laporan
public function reports()
{
    return $this->hasMany(Report::class);
}

}
