<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nom', 'prenoms', 'telephone', 'telephone2',
        'plaque_immatriculation', 'assureur_actuel', 'lieuprospection',
    ];

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }

    public function getFullNameAttribute()
    {
        return trim(($this->prenoms ?? '') . ' ' . ($this->nom ?? ''));
    }
}
