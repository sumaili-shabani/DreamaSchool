<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_client extends Model
{
    protected $fillable=['id','noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece',
    'dateLivrePiece','lieulivraisonCarte','nationnalite',
    'datenaissance','lieunaissance','profession','occupation','nombreEnfant',
    'dateArriverGoma','arriverPar','refCategieClient',
    'photo','slug','author'];
    protected $table = 'tvente_client';
}


   