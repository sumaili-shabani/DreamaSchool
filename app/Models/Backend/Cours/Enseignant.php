<?php

namespace App\Models\Backend\Cours;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    //
    protected $fillable = [
        'idAvenue','nomEns',
        'nomUtilisateurEns','nationaliteEns',
        'telEns','tel2Ens',
        'sexeEns','etatcivilEns',
        'prefEns','degreprefEns',
        'telprefEns','codeEns',
        'numCarteEns','passwordEns',
        'imageEns',
        'numMaisonEns', 'dateNaisEns',

    ];
}
