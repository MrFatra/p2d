<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'consultation_history_id',
        'sender_id',
        'receiver_id',
        'message',
    ];

    public function consultationHistory()
    {
        return $this->belongsTo(ConsultationHistory::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
