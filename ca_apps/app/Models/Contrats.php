<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrats extends Model
{
    use HasFactory;

    protected $table = 'contrats';
    protected $fillable = [
            'idopportunite','numpolice','commentaire'
        ];

    public function Opportunite(){
        
        return $this->hasOne('App\Models\ProspectionClient','id','idopportunite');
    }

    public function commentaire(){
        return $this->hasOne('App\Models\NoteOpportunites','id','commentaire');
    }
}
