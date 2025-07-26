<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teenager extends Model
{
    protected $table = 'teenagers';

    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'bmi',
        'blood_pressure',
        'anemia',
        'iron_tablets',
        'reproductive_health',
        'mental_health',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
