<?php

namespace App\Models\Backend\Ecole;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    //
    protected $fillable = [
        'idInscription','date_entree',
        'date_sortie','statut_presence',
        'motif','mouvement',
        'date1','date2',

    ];
}
