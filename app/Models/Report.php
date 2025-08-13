<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
        'babies',
        'toddlers',
        'children',
        'teenagers',
        'pregnants',
        'elderlies',
        'hamlet',
        'month',
        'year',
    ];
}
