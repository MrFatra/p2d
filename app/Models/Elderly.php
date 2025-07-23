<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Elderly extends Model
{
    // Nama tabel eksplisit
    protected $table = 'elderly';

    // Field yang dapat di-*mass assign*
    protected $fillable = [
        'user_id',
        'blood_pressure',
        'blood_glucose',
        'cholesterol',
        'nutrition_status',
        'functional_ability',
        'chronic_disease_history',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
