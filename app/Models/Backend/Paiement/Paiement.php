<?php

namespace App\Models\Backend\Paiement;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    //
    protected $fillable = [
        'idTranche','idFrais',
        'idInscription','montant',
        'datePaiement','codePaiement',
        'idUser','etatPaiement',
        'refBanque','numeroBordereau'

    ];
}
