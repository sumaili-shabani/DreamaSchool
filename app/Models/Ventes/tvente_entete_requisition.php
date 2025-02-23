<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_requisition extends Model
{
    protected $fillable=['id','refFournisseur','dateCmd','libelle','montant','author'];
    protected $table = 'tvente_entete_requisition';
}
