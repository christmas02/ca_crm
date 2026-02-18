<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrands extends Model
{
    use HasFactory;

      protected $table = 'car_brands';
      protected $fillable = [
        'libelle', 'isvisible', 
    ];
}
