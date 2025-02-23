<?php

namespace App\Models\Backend\Paiement;

use Illuminate\Database\Eloquent\Model;

class Prevision extends Model
{
    //
    protected $fillable = [
        'idTranche','idFrais',
        'idClasse','idOption',
        'idAnne','montant',
        'etatPrevision',
        'date_debit_prev','date_fin_prev',
        

    ];
}
