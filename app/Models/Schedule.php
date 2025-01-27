<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'type',
        'date_open',
        'date_closed',
        'opened_time',
        'closed_time',
        'notes',
    ];
}
