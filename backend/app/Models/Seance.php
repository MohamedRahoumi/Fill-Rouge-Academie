<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date_seance' => 'date',
    ];

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}
