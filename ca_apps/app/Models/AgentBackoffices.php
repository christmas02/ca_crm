<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentBackoffices extends Model
{
    use HasFactory;

    protected $table = 'agentbackoffice';
    protected $fillable = [
            'lastname', 'firstname', 'PhoneNumber','login','password','privilege', 'isactive', 'donebyuser','profile_picture','created_at', 'updated_at','status'
        ];


        public function Affectations (){

        return $this->hasMany('App\Models\AffectationOpportunites','idagentbackoffice','id');
    }
}
