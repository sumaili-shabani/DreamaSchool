<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_vente extends Model
{
    protected $fillable=['id','refClient','dateVente','libelle','montant','paie','author'];
    protected $table = 'tvente_entete_vente';
}
