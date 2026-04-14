<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $guarded = [];

    protected $casts = [
        'est_present' => 'boolean',
    ];

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function joueur()
    {
        return $this->belongsTo(Joueur::class);
    }
}
