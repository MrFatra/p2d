<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Growth extends Model
{
    protected $fillable = [
        'user_id',
        'height',
        'weight',
        'smoking',
        'abdominal_circumference',
        'blood_sugar_levels',
        'taking_blood_supplement',
        'blood_pressure',
        'gestational_age',
        'gestational_category',
        'head_circumference',
        'arm_circumference',
        'exclusive_breastfeeding',
        'imt',
        'stunting_status',
        'imt_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
