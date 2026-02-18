<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivilegesAgentBo extends Model
{
    use HasFactory;


    protected $table = 'privileges_agent_bos';
    protected $fillable = [
            'id_priv', 'id_user', 'statut','created_at','updated_at'
        ];



}
