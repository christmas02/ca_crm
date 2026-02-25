<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'created_by', 'assigned_to', 'status_id', 'team_id',
        'nom', 'prenoms', 'telephone', 'telephone2',
        'title', 'observation', 'canal', 'source',
        'plaque_immatriculation', 'echeance', 'relance', 'lieuprospection',
        'assureur_actuel', 'periode_souscription', 'montant_souscription', 'isasap',
        'urlcarte_grise_terrain', 'url_attestationassurance_terrain',
        'urlcarte_grise', 'url_attestationassurance',
        'statut_discours', 'statut_carte_grise', 'statut_attestation',
        'author_doublon_check', 'doublon_check', 'date_auth_doublon',
        'isvisible',
    ];

    protected $casts = [
        'echeance' => 'datetime',
        'relance' => 'datetime',
        'date_auth_doublon' => 'datetime',
        'doublon_check' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        return trim(($this->prenoms ?? '') . ' ' . ($this->nom ?? ''));
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
