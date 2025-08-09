<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Toddler extends Model
{
    protected $table = 'toddlers';

    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'upper_arm_circumference',
        'nutrition_status',
        'vitamin_a',
        'imunization_followup',
        'food_supplement',
        'parenting_education',
        'motor_development',
        'checkup_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
