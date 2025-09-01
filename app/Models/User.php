<?php

namespace App\Models;

use App\Helpers\Auth;
use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'family_card_number',
        'national_id',
        'father_id',
        'mother_id',
        'name',
        'password',
        'birth_date',
        'place_of_birth',
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

        $key = "users_{$category}_{$hamlet}_month_{$now->format('Ym')}";

        return Cache::remember($key, 90, function () use ($category, $hamlet, $now) {

            $categories = [
                'baby' => [
                    'min_month' => 0,
                    'max_month' => 11,
                    'relation' => 'infants'
                ],
                'toddler' => [
                    'min_month' => 12,
                    'max_month' => 59,
                    'relation' => 'toddlers'
                ],
                'child' => [
                    'min_month' => 60,
                    'max_month' => 72,
                    'relation' => 'preschoolers'
                ],
                'teenager' => [
                    'min_year' => 10,
                    'max_year' => 17,
                    'relation' => 'teenagers'
                ],
                'adult' => [
                    'min_year' => 18,
                    'max_year' => 59,
                    'relation' => 'adults'
                ],
                'elderly' => [
                    'min_year' => 60,
                    'max_year' => null,
                    'relation' => 'elderlies'
                ],
                'mother' => [
                    'min_year' => 12,
                    'max_year' => 60,
                    'relation' => 'pregnantPostpartumBreastfeedings',
                    'gender' => 'P'
                ],
            ];


            if (!$category || !array_key_exists($category, $categories)) {
                return User::all();
            }

            $config = $categories[$category];
            $query = User::query();

            if (isset($config['max_month'])) {
                $query->whereDate('birth_date', '>', $now->copy()->subMonths($config['max_month'] + 1));
            }

            if (isset($config['min_month'])) {
                $query->whereDate('birth_date', '<=', $now->copy()->subMonths($config['min_month']));
            }

            if (isset($config['max_year'])) {
                $query->whereDate('birth_date', '>', $now->copy()->subYears($config['max_year'] + 1));
            }

            if (isset($config['min_year'])) {
                $query->whereDate('birth_date', '<=', $now->copy()->subYears($config['min_year']));
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
        });
    }

    public static function determineTypeOfUser($userBirthDate): string
    {
        if (empty($userBirthDate)) {
            return 'none';
        }

        $now = now();
        $birthDate = Carbon::parse($userBirthDate);

        $ageInMonths = $birthDate->diffInMonths($now);
        $ageInYears  = $birthDate->diffInYears($now);

        // 1. Bayi 0–11 bulan
        if ($ageInMonths >= 0 && $ageInMonths <= 11) {
            return 'baby';
        }

        // 2. Balita 12–59 bulan
        if ($ageInMonths >= 12 && $ageInMonths <= 59) {
            return 'toddler';
        }

        // 3. Anak Pra-Sekolah 60–72 bulan
        if ($ageInMonths >= 60 && $ageInMonths <= 72) {
            return 'child';
        }

        // 4. Remaja 10–17 tahun
        if ($ageInYears >= 10 && $ageInYears <= 17) {
            return 'teenager';
        }

        // 5. Dewasa 18–59 tahun
        if ($ageInYears >= 18 && $ageInYears <= 59) {
            return 'adult';
        }

        // 6. Lansia 60 tahun ke atas
        if ($ageInYears >= 60) {
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

    public function father()
    {
        return $this->belongsTo(User::class, 'father_id');
    }

    public function mother()
    {
        return $this->belongsTo(User::class, 'mother_id');
    }
}
