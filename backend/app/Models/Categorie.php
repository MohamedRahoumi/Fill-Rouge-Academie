<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $guarded = [];

    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }

    public function joueurs()
    {
        return $this->hasMany(Joueur::class);
    }
}
