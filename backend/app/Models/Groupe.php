<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $guarded = [];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function joueurs()
    {
        return $this->hasMany(Joueur::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
