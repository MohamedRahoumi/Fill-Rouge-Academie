<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationAcademie extends Model
{
    protected $table = 'notifications_academie';

    protected $guarded = [];

    protected $casts = [
        'est_lu' => 'boolean',
    ];

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
