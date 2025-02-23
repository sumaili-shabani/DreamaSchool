<?php

namespace App\Models\Backend\Cours;

use Illuminate\Database\Eloquent\Model;

class AttributionCours extends Model
{
    //
    protected $fillable = [
        'idCours','idEnseignant',
        'idPeriode','idAnne',
        'idOption','idClasse',
        'maximale','codeAt',
        
    ];
}
