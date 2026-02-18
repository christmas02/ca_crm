<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'created_by', 'assigned_to', 'status_id',
        'team_id', 'title', 'description', 'source',
    ];

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
