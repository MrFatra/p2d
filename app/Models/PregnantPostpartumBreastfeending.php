<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PregnantPostpartumBreastfeending extends Model
{
    // Nama tabel eksplisit
    protected $table = 'pregnant_postpartum_breastfeeding';

    // Field yang dapat di-*mass assign*
    protected $fillable = [
        'user_id',
        'pregnancy_status',
        'muac',
        'blood_pressure',
        'tetanus_immunization',
        'iron_tablets',
        'anc_schedule',
    ];

    protected static function booted()
    {
        static::created(function ($record) {
            $record->user->syncRoles('pregnant');
        });

        static::deleted(function ($record) {
            if (!$record->user->pregnantPostpartumBreastfeedings()->exists()) {
                $record->user->removeRole('pregnant');
            }
        });
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
