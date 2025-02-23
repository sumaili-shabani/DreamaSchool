<?php

namespace App\Models\Backend\Ecole;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    //
    protected $fillable = [
        'idEleve','idAnne',
        'idOption','idClasse',
        'idDivision','dateInscription',
        'codeInscription','reductionPaiement',
        'fraisinscription','restoreinscription',

    ];
}
