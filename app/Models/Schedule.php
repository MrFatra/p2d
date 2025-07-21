<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $fillable = [
        'type',
        'date_open',
        'date_closed',
        'time_opened',
        'time_closed',
        'notes',
    ];
}
