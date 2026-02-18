<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospectors extends Model
{
    use HasFactory;

    protected $table = 'prospectors';
    protected $fillable = [
            'lastname', 'firstname', 'phonenumber','password', 'isactive', 'created_at', 'updated_at'
        ];
}
 