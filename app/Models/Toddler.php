<?php

namespace App\Models;

use App\Helpers\MyClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Toddler extends Model
{
    protected $table = 'toddlers';

    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'head_circumference',
        'upper_arm_circumference',
        'stunting_status',
        'nutrition_status',
        'vitamin_a',
        'immunization_followup',
        'eighteen_month',
        'food_supplement',
        'parenting_education',
        'motor_development',
        'checkup_date',
    ];

    protected $casts = [
        'eighteen_month' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * boot untuk mendiagnosa status stunting dan kesehatan nya
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($toddler) {
            if (
                $toddler->height &&
                $toddler->weight &&
                $toddler->head_circumference &&
                $toddler->user &&
                $toddler->user->birth_date
            ) {
                // Konversi gender dari P/L menjadi female/male
                $gender = strtolower($toddler->user->gender ?? 'L') === 'p' ? 'female' : 'male';

                $result = MyClass::calculateStuntingStatus(
                    $toddler->user->birth_date,
                    $toddler->height,
                    $toddler->weight,
                    $toddler->head_circumference,
                    $gender
                );

                $toddler->stunting_status = $result['status']; // Ambil status
            }
        });

        static::updating(function ($toddler) {
            if (
                $toddler->height &&
                $toddler->weight &&
                $toddler->head_circumference &&
                $toddler->user &&
                $toddler->user->birth_date
            ) {
                $gender = strtolower($toddler->user->gender ?? 'L') === 'p' ? 'female' : 'male';

                $result = MyClass::calculateStuntingStatus(
                    $toddler->user->birth_date,
                    $toddler->height,
                    $toddler->weight,
                    $toddler->head_circumference,
                    $gender
                );

                $toddler->stunting_status = $result['status'];
            }
        });
    }
}
