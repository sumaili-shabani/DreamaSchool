<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_banque extends Model
{
    protected $fillable=['id','nom_banque','numerocompte','nom_mode','refSscompte','author'];
    protected $table = 'tconf_banque';

    //tannexe_depense
}
