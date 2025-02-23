<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_categorie_client extends Model
{
    protected $fillable=['id','designation','author'];
    protected $table = 'tvente_categorie_client';
}
