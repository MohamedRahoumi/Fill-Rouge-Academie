<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // === SUPER ADMIN ===
    public function notificationsEnvoyees()
    {
        return $this->hasMany(NotificationAcademie::class, 'sender_id');
    }

    // === COACH ===
    public function groupesGeres()
    {
        return $this->hasMany(Groupe::class, 'coach_id');
    }

    public function evaluationsRedigees()
    {
        return $this->hasMany(Evaluation::class, 'coach_id');
    }

    public function seancesAnimees()
    {
        return $this->hasMany(Seance::class, 'coach_id');
    }

    // === PARENT ===
    public function joueurs()
    {
        return $this->hasMany(Joueur::class, 'parent_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'parent_id');
    }

    // === TOUS ===
    public function notificationsRecues()
    {
        return $this->hasMany(NotificationAcademie::class, 'user_id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isCoach(): bool
    {
        return $this->role === 'coach';
    }

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }
}
