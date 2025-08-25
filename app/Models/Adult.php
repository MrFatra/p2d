<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adult extends Model
{
    protected $table = 'adults';

    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'bmi',
        'smoking_status',
        'blood_pressure',
        'blood_glucose',
        'cholesterol',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
