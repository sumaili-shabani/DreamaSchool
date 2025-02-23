<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_entete_operationcompte extends Model
{
    protected $fillable=['id','libelleOperation','dateOpration','refTresorerie','numOpereation','tauxdujour','author'];
    protected $table = 'tfin_entete_operationcompte';
}
