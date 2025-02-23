<?php

namespace App\Models\Backend\Ecole;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    //
    protected $fillable = [
        'idAvenue', 'nomEleve',
        'postNomEleve', 'preNomEleve',
        'etatCivilEleve', 'sexeEleve',
        'nomPere', 'nomMere',
        'numPere', 'numMere',
        'photoEleve','codeEleve',
        'numAdresseEleve','dateNaisEleve',

    ];
}
