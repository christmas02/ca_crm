<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canals extends Model
{
    use HasFactory;

    protected $table = 'canal';
    protected $fillable = [
            'libelle','donebyuser','isactive'
        ];

    public function AgentBackoffice(){

        return $this->hasOne('App\Models\AgentBackoffices','id','donebyuser');
    }


}
