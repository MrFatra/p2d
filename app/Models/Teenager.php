<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

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

    public function scopeExclude($query, $columnsToExclude = [])
    {
        $table = $this->getTable();
        $allColumns = Schema::getColumnListing($table);
        $columns = array_diff($allColumns, (array) $columnsToExclude);

        return $query->select($columns);
    }


    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
