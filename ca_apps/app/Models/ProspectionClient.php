<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectionClient extends Model
{
    use HasFactory;

    protected $table = 'prospection_clients';
    protected $fillable = [
            'nom', 'prenoms', 'telephone', 'echeance', 'lieuprospection', 
            'observation', 'urlcarte_grise', 'url_attestationassurance', 
            'realiserpar','assureur_actuel' ,'periode_soucription', 
            'montant_soucription' ,'created_at', 'updated_at','isasap','
            idagentbackoffice','telephone2','isvisible','urlcarte_grise_terrain' ,
            'url_attestationassurance_terrain', 'statut_discours','statut_carte_grise',
            'statut_attestation','plaque_immatriculation','canal','author_doublon_check',
            'doublon_check','date_auth_doublon'
        ];


    public function AgentTerrain(){
        return $this->hasOne('App\Models\Prospectors','id','realiserpar');
    }


    public function commentaires(){
        return $this->hasMany('App\Models\NoteOpportunites','idopportunite','id');
    }


    public function affectation(){
        return $this->hasMany('App\Models\AffectationOpportunites','idopportunite','id');
    }


    public function AgentEnligne(){
        return $this->hasOne('App\Models\AgentBackoffices','id','idagentbackoffice');
    }
}
