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
        'is_death',
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
            if (!$user->hasRole(['admin', 'cadre', 'resident', 'midwife'])) {
                $user->syncRoles(self::determineTypeOfUser($user->birth_date));
            }
        });

        static::updating(function ($user) {
            if (empty($user->password)) {
                unset($user->password);
            }

            if ($user->isDirty('birth_date') && !$user->hasRole(['admin', 'cadre', 'resident', 'midwife'])) {
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
            $query = User::query();

            // If a category is specified, filter by role name.
            if ($category) {
                $query->whereHas('roles', function ($q) use ($category) {
                    $q->where('name', $category);
                });
            }

            // This map is to find users who have NOT had a check-up this month.
            $relations = [
                'baby' => 'infants',
                'toddler' => 'toddlers',
                'child' => 'preschoolers',
                'teenager' => 'teenagers',
                'adult' => 'adults',
                'elderly' => 'elderlies',
                'pregnant' => 'pregnantPostpartumBreastfeedings',
            ];

            if ($category && array_key_exists($category, $relations)) {
                $relation = $relations[$category];
                $query->whereDoesntHave($relation, function ($q) use ($now) {
                    $q->whereYear('created_at', $now->year)
                        ->whereMonth('created_at', $now->month);
                });
            }

            // Filter by hamlet if the user is a cadre.
            if (Auth::user()->hasRole('cadre')) {
                $query->where('hamlet', $hamlet);
            }

            $query->where('is_death', false);

            return $query->get();
        });
    }

    public static function determineTypeOfUser($userBirthDate): string
    {
        if (empty($userBirthDate)) {
            return 'none';
        }

        $birthDate = Carbon::parse($userBirthDate);
        $ageInMonths = $birthDate->diffInMonths(now());

        if ($ageInMonths <= 11) { // 0-11 bulan
            return 'baby';
        } elseif ($ageInMonths <= 59) { // 1-4 tahun (12-59 bulan)
            return 'toddler';
        } elseif ($ageInMonths <= 119) { // 5-9 tahun (60-119 bulan)
            return 'child';
        } elseif ($ageInMonths < 216) { // 10-17 tahun (120-215 bulan)
            return 'teenager';
        } elseif ($ageInMonths < 720) { // 18-59 tahun (216-719 bulan)
            return 'adult';
        } elseif ($ageInMonths >= 720) { // 60+ tahun
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
        return $this->hasRole(['admin', 'cadre', 'resident', 'midwife']);
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
