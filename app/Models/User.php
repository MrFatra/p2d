<?php

namespace App\Models;

use App\Helpers\Auth;
use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'family_card_number',
        'national_id',
        'name',
        'password',
        'birth_date',
        'gender',
        'email',
        'phone_number',
        'rt',
        'rw',
        'address',
        'hamlet',
        'otp',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->hasRole(['admin', 'cadre', 'resident'])) {
                $user->syncRoles(self::determineTypeOfUser($user->birth_date));
            }
        });

        static::updating(function ($user) {
            if (empty($user->password)) {
                unset($user->password);
            }

            if ($user->isDirty('birth_date') && !$user->hasRole(['admin', 'cadre', 'resident'])) {
                $user->syncRoles(self::determineTypeOfUser($user->birth_date));
            }
        });

        static::deleting(function ($user) {
            $user->syncRoles([]);
        });
    }

    public static function getUsers($category = null, $hamlet)
    {
        $now = Carbon::now();

        $categories = [
            'baby' => [
                'min' => 0,
                'max' => 1,
                'relation' => 'infants',
            ],
            'toddler' => [
                'min' => 1,
                'max' => 5,
                'relation' => 'toddlers',
            ],
            'teenager' => [
                'min' => 12,
                'max' => 18,
                'relation' => 'teenagers',
            ],
            'adult' => [
                'min' => 18,
                'max' => 60,
                'relation' => 'adults',
            ],
            'child' => [
                'min' => 6,
                'max' => 12,
                'relation' => 'preschoolers',
            ],
            'elderly' => [
                'min' => 60,
                'max' => null,
                'relation' => 'elderlies',
            ],
            'mother' => [
                'min' => 12,
                'max' => 60,
                'relation' => 'pregnantPostpartumBreastfeedings',
                'gender' => 'P',
            ],
        ];

        if (!$category || !array_key_exists($category, $categories)) {
            return User::all();
        }

        $config = $categories[$category];
        $query = User::query();

        if (!empty($config['max'])) {
            $query->whereDate('birth_date', '>', $now->copy()->subYears($config['max']));
        }

        if (!empty($config['min'])) {
            $query->whereDate('birth_date', '<=', $now->copy()->subYears($config['min']));
        }

        if (isset($config['gender'])) {
            $query->where('gender', $config['gender']);
        }

        $query->whereDoesntHave($config['relation'], function ($q) use ($now) {
            $q->whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month);
        });

        if (Auth::user()->hasRole('cadre')) {
            $query->where('hamlet', $hamlet);
        }

        return $query->get();
    }

    public static function determineTypeOfUser($userBirthDate): string
    {
        if (empty($userBirthDate)) {
            return 'none';
        }

        $now = now();
        $age = Carbon::parse($userBirthDate)->diffInYears($now);

        if ($age <= 1) {
            return 'baby';
        } elseif ($age > 1 && $age <= 5) {
            return 'toddler';
        } elseif ($age >= 6 && $age < 12) {
            return 'child';
        } elseif ($age >= 12 && $age < 18) {
            return 'teenager';
        } elseif ($age >= 18 && $age < 60) {
            return 'adult';
        } elseif ($age >= 60) {
            return 'elderly';
        }

        return 'none';
    }

    public function getAgeCategoryAttribute(): string
    {
        return self::determineTypeOfUser($this->birth_date);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['admin', 'cadre', 'resident']);
    }

    // === Relationships ===
    public function infants()
    {
        return $this->hasMany(Infant::class);
    }

    public function toddlers()
    {
        return $this->hasMany(Toddler::class);
    }

    public function teenagers()
    {
        return $this->hasMany(Teenager::class);
    }

    public function adults()
    {
        return $this->hasMany(Adult::class);
    }

    public function pregnantPostpartumBreastfeedings()
    {
        return $this->hasMany(PregnantPostpartumBreastfeending::class);
    }

    public function elderlies()
    {
        return $this->hasMany(Elderly::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function preschoolers()
    {
        return $this->hasMany(Preschooler::class);
    }
}
