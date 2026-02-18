<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;

    protected $table = 'cars';
    protected $fillable = [
            'car_code', 'type', 'brand', 'model', 'power', 'places', 
        ];



    public function carsvalues(){
        return $this->hasMany('App\Models\CarsValues','car_code','car_code');
    }
}
