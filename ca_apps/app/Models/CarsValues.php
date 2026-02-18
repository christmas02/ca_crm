<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarsValues extends Model
{
    use HasFactory;

    protected $table = 'cars_values';
    protected $fillable = [
            'date', 'amount', 'car_code', 
        ];


    public function Carfamily(){
        return $this->hasOne('App\Models\Cars','car_code','car_code');
    }

}
