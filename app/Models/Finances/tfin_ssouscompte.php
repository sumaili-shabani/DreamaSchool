<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_ssouscompte extends Model
{
    protected $fillable=['id','refSousCompte','nom_ssouscompte','numero_ssouscompte','author'];
    protected $table = 'tfin_ssouscompte';   
}
