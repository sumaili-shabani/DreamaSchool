<?php

namespace App\Models\Backend\Paiement;

use Illuminate\Database\Eloquent\Model;

class Clauture extends Model
{
    //
    protected $fillable = [
        'idAnne','idOption',
        'idClasse','idSection',
        'refMois','mois',
        'effectifClasse','effectifAbandon',
        'effectifTotal',

    ];
}
