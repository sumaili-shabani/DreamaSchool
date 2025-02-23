<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_fournisseur extends Model
{
    protected $fillable=['id','noms','contact','mail','adresse','author'];
    protected $table = 'tvente_fournisseur';
}
