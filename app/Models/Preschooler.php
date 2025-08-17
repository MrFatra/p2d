<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preschooler extends Model
{
    use HasFactory;

    protected $table = 'preschoolers';

    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'head_circumference',
        'upper_arm_circumference',
        'nutrition_status',
        'motor_development',
        'language_development',
        'social_development',
        'vitamin_a',
        'complete_immunization',
        'exclusive_breastfeeding',
        'complementary_feeding',
        'parenting_education',
        // 'stunting_status',
        'checkup_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
