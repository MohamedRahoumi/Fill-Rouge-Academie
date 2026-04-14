<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date_evaluation' => 'date',
    ];

    public function joueur()
    {
        return $this->belongsTo(Joueur::class);
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }
}
