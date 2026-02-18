<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Primenergie extends Model
{
    use HasFactory;

    protected $fillable = [
            'cv', 'essence', 'diesel', 
        ];

}
