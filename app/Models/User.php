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
            $user->assignRole(self::determineTypeOfUser($user->birth_date));
        });

        static::updating(function ($user) {
            if (empty($user->password)) {
                unset($user->password);
            }

            if ($user->isDirty('birth_date')) {
                $user->assignRole(self::determineTypeOfUser($user->birth_date));
            }
        });
    }

    public function getUsers($kategori = null)
    {
        $now = Carbon::now();

        switch ($kategori) {
            case 'bayi':
                return User::whereDate('birth_date', '>', $now->copy()->subYear())->get();

            case 'balita':
                return User::whereDate('birth_date', '<=', $now->copy()->subYear())
                    ->whereDate('birth_date', '>', $now->copy()->subYears(5))
                    ->get();

            case 'remaja':
                return User::whereDate('birth_date', '<=', $now->copy()->subYears(18))
                    ->whereDate('birth_date', '>', $now->copy()->subYears(12))
                    ->get();

            case 'lansia':
                return User::whereDate('birth_date', '<=', $now->copy()->subYears(60))->get();

            case 'ibu':
                return User::where('gender', 'P')
                    ->whereDate('birth_date', '<=', $now->copy()->subYears(12))
                    ->whereDate('birth_date', '>', $now->copy()->subYears(60))
                    ->get();

            default:
                return User::all();
        }
    }

    public function getUsersByPosyanduCategory($kategori = null)
    {
        $users = User::all();

        $result = [
            'bayi' => [],
            'balita' => [],
            'remaja' => [],
            'lansia' => [],
            'ibu' => [],
        ];

        foreach ($users as $user) {
            $age = Carbon::parse($user->tanggal_lahir)->age;

            if ($age < 1) {
                $result['bayi'][] = $user;
            }

            if ($age >= 1 && $age < 5) {
                $result['balita'][] = $user;
            }

            if ($age >= 12 && $age < 18) {
                $result['remaja'][] = $user;
            }

            if ($age >= 60) {
                $result['lansia'][] = $user;
            }

            if ($user->jenis_kelamin === 'P' && $age >= 12 && $age < 60) {
                $result['ibu'][] = $user;
            }
        }

        // parameter kategori dikirim, ambil hanya data itu
        if ($kategori && array_key_exists($kategori, $result)) {
            return $result[$kategori];
        }

        // tidak, kembalikan semua
        return $result;
    }

    private static function determineTypeOfUser($userBirthDate)
    {
        if (empty($userBirthDate)) {
            return 'none';
        }

        $now = now();
        $age = Carbon::parse($userBirthDate)->diffInYears($now);

        if ($age < 0) {
            return 'baby';
        } elseif ($age < 5) {
            return 'toddler';
        } elseif ($age < 12) {
            return 'child';
        } elseif ($age < 18) {
            return 'teenager';
        } elseif ($age < 60) {
            return 'adult';
        } elseif ($age >= 60) {
            return 'elderly';
        } else {
            return 'none';
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
        return $this->hasOne(Elderly::class);
    }

    // Relasi ke banyak laporan
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
