<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Infant extends Model
{
    protected $table = 'infants';

    // Field yang bisa di-*mass assign*
    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'nutrition_status',
        'complete_immunization',
        'vitamin_a',
        'exclusive_breastfeeding',
        'complementary_feeding',
        'motor_development',
    ];

        public function scopeExclude($query, $columnsToExclude = [])
    {
        $table = $this->getTable();
        $allColumns = Schema::getColumnListing($table);
        $columns = array_diff($allColumns, (array) $columnsToExclude);

        return $query->select($columns);
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
