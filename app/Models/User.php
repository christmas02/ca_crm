<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'identification',
        'password',
        'role_id',
        'team_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function createdOpportunities()
    {
        return $this->hasMany(Opportunity::class, 'created_by');
    }

    public function assignedOpportunities()
    {
        return $this->hasMany(Opportunity::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function hasRole($slug)
    {
        return $this->role && $this->role->slug === $slug;
    }

    public function hasAnyRole(array $slugs)
    {
        return $this->role && in_array($this->role->slug, $slugs);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isLead()
    {
        return $this->hasRole('lead');
    }

    public function isAgentConseil()
    {
        return $this->hasRole('agent_conseil');
    }

    public function isAgentTerrain()
    {
        return $this->hasRole('agent_terrain');
    }
}
