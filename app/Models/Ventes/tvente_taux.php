<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_taux extends Model
{
    protected $fillable=['id','taux','author'];
    protected $table = 'tvente_taux';
}
