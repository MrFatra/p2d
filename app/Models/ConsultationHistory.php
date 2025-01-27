<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationHistory extends Model
{
    protected $fillable = [
        'user_id',
        'reply_id',
        'title',
        'description',
        'reply',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reply()
    {
        return $this->belongsTo(User::class, 'reply_id');
    }
}
