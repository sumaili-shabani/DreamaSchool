<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_souscompte extends Model
{
    protected $fillable=['id','refCompte','nom_souscompte','numero_souscompte','author'];
    protected $table = 'tfin_souscompte';
    
}
