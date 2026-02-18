<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'order', 'color'];

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }
}
