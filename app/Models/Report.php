<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // Nama tabel
    protected $table = 'reports';

    // Kolom yang bisa di-*mass assign*
    protected $fillable = [
        'user_id',
        'file_name',
        'file_type',
        'description',
        'uploaded_at',
        'file_path',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
