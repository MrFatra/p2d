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
        'family_card_number',
        'national_id',
        'name',
        'password',
        'birth_date',
        'gender',
        'phone_number',
        'address',
        'latitude',
        'longitude',
        'hamlet',
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
            $user->syncRoles(self::determineTypeOfUser($user->birth_date));
        });

        static::updating(function ($user) {
            if (empty($user->password)) {
                unset($user->password);
            }

            if ($user->isDirty('birth_date') && !$user->hasRole('admin')) {
                $user->syncRoles(self::determineTypeOfUser($user->birth_date));
            }
        });
    }

    public static function getUsers($category = null)
    {
        $now = Carbon::now();

        switch ($category) {
            case 'baby':
                return User::whereDate('birth_date', '>', $now->copy()->subYear())
                    ->whereDate('birth_date', '<=', $now)
                    // TODO: This query may be used to all roles...
                    ->whereDoesntHave('infant', function ($query) use ($now) {
                        $query->whereMonth('created_at', $now->month)
                            ->whereYear('created_at', $now->year);
                    })
                    ->get();


            case 'toddler':
                return User::whereDate('birth_date', '<=', $now->copy()->subYear())
                    ->whereDate('birth_date', '>', $now->copy()->subYears(5))
                    ->get();

            case 'teenager':
                return User::whereDate('birth_date', '<=', $now->copy()->subYears(12))
                    ->whereDate('birth_date', '>', $now->copy()->subYears(18))
                    ->get();

            case 'elderly':
                return User::whereDate('birth_date', '<=', $now->copy()->subYears(60))->get();

            case 'mother':
                return User::where('gender', 'P')
                    ->whereDate('birth_date', '<=', $now->copy()->subYears(12))
                    ->whereDate('birth_date', '>', $now->copy()->subYears(60))
                    ->get();

            default:
                return User::all();
        }
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

    public function getAgeCategoryAttribute(): string
    {
        return self::determineTypeOfUser($this->birth_date);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    // Relasi untuk data remaja
    public function teenager()
    {
        return $this->hasOne(Teenager::class);
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

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
