<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $guarded = [];

    protected $casts = [
        'mois_concerne' => 'date',
        'montant' => 'decimal:2',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'paid'    => 'Payé',
            'pending' => 'En attente',
            'failed'  => 'Échoué',
            default   => $this->statut,
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'paid'    => 'text-green-400',
            'pending' => 'text-yellow-400',
            'failed'  => 'text-red-400',
            default   => 'text-gray-400',
        };
    }
}
