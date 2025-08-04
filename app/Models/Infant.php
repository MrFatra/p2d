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
        'nutrition_status',
        'complete_immunization',
        'vitamin_a',
        'stunting_status',
        'exclusive_breastfeeding',
        'complementary_feeding',
        'motor_development',
        'checkup_date',
    ];

    public function scopeExclude($query, $columnsToExclude = [])
    {
        $table = $this->getTable();
        $allColumns = Schema::getColumnListing($table);
        $columns = array_diff($allColumns, (array) $columnsToExclude);

        return $query->select($columns);
    }

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
