<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infant extends Model
{
    protected $table = 'infants';

    // Field yang bisa di-*mass assign*
    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'nutrition_status',
        'complete_immunization',
        'vitamin_a',
        'exclusive_breastfeeding',
        'complementary_feeding',
        'motor_development',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
