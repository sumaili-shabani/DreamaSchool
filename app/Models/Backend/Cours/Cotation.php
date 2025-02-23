<?php

namespace App\Models\Backend\Cours;

use Illuminate\Database\Eloquent\Model;

class Cotation extends Model
{
    //
    protected $fillable = [
        'idInscription','idCours',
        'idPeriode','cote',
        'codeCote','maxima',
        
    ];
}
