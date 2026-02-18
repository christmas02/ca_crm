<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffectationOpportunites extends Model
{
    use HasFactory;

    protected $table = 'affectationopportunite';
    protected $fillable = [
            'idopportunite', 'idagentbackoffice', 'donebyuser' ,'created_at', 'updated_at','status','date_affect'
        ];



    public function Opportunites (){

        return $this->hasMany('App\Models\ProspectionClient','id','idopportunite');
    }

    public function commentaire(){
        return $this->hasMany('App\Models\NoteOpportunites','idopportunite','idopportunite');
    }


    public function AgentBackoffice (){

        return $this->hasMany('App\Models\AgentBackoffices','id','idagentbackoffice');
    }


    public function AuteurAffecation (){

        return $this->hasMany('App\Models\AgentBackoffices','id','donebyuser');
    }



    public function scopeCheckRelationships($query){
      return $query->has("Opportunites")->has("commentaire");
    }


}
