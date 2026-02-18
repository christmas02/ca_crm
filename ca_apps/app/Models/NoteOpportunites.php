<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteOpportunites extends Model
{
    use HasFactory;



    protected $fillable = [
            'idopportunite', 'idagentbackoffice', 'inthabitation', 'intflotteauto', 'intsante', 'intvoyage', 'intautre', 'daterelance', 'heure_relance', 'echeance', 'observation','interetclient','resultat','assureur_actuel', 'periode_soucription', 'primenet','primettc','relance_sys','isvisible','souscrit_par','reaff_par','date_affect','paymentmode','url_preuve_paiement','url_avenant'
        ];


     public function AgentBackoffice(){

        return $this->hasOne('App\Models\AgentBackoffices','id','idagentbackoffice');
    }


     public function Opportunite(){
        
        return $this->hasOne('App\Models\ProspectionClient','id','idopportunite');
    }

     public function Affectations(){
        
        return $this->hasOne('App\Models\AffectationOpportunites','idopportunite','idopportunite');
    }


     public function reaffectation(){
        
        return $this->hasOne('App\Models\AgentBackoffices','id','reaff_par');
    }


    public function ContratGagne(){
        
        return $this->hasOne('App\Models\Contrats','commentaire','id');
    }


}
