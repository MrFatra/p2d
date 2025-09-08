<?php

namespace App\Models;

use App\Helpers\MyClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Infant extends Model
{
    protected $table = 'infants';

    // Field yang bisa di-*mass assign*
    protected $fillable = [
        'user_id',
        'birth_weight',
        'birth_height',
        'weight',
        'height',
        'head_circumference',
        'upper_arm_circumference',
        'nutrition_status',
        'complete_immunization',
        'vitamin_a',
        'stunting_status',
        'exclusive_breastfeeding',
        'complementary_feeding',
        'motor_development',
        'checkup_date',
        'one_day',
        'hb_immunization',
        'one_month',
        'two_month',
        'three_month',
        'four_month',
        'nine_month',
        'ten_month',
        'one_year',
    ];

    protected $casts = [
        'one_month' => 'array',
        'two_month' => 'array',
        'three_month' => 'array',
        'four_month' => 'array',
        'nine_month' => 'array',
        'ten_month' => 'array',
        'one_year' => 'array', 
    ];

    // Relasi ke user
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

        static::creating(function ($infant) {
            if (
                $infant->height &&
                $infant->weight &&
                $infant->head_circumference &&
                $infant->user &&
                $infant->user->birth_date
            ) {
                // Konversi gender dari P/L menjadi female/male
                $gender = strtolower($infant->user->gender ?? 'L') === 'p' ? 'female' : 'male';

                $result = MyClass::calculateStuntingStatus(
                    $infant->user->birth_date,
                    $infant->height,
                    $infant->weight,
                    $infant->head_circumference,
                    $gender
                );

                $infant->stunting_status = $result['status']; // Ambil status
            }
        });

        static::updating(function ($infant) {
            if (
                $infant->height &&
                $infant->weight &&
                $infant->head_circumference &&
                $infant->user &&
                $infant->user->birth_date
            ) {
                $gender = strtolower($infant->user->gender ?? 'L') === 'p' ? 'female' : 'male';

                $result = MyClass::calculateStuntingStatus(
                    $infant->user->birth_date,
                    $infant->height,
                    $infant->weight,
                    $infant->head_circumference,
                    $gender
                );

                $infant->stunting_status = $result['status'];
            }
        });
    }
}
