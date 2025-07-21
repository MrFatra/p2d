<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adult extends Model
{
    protected $table = 'adults';

    protected $fillable = [
        'user_id',
        'blood_pressure',
        'blood_glucose',
        'cholesterol',
        'bmi'
    ];
}
