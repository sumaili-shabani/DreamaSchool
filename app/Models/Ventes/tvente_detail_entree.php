<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_detail_entree extends Model
{
    protected $fillable=['id','refEnteteEntree','refProduit','puEntree','devise','taux','qteEntree','unite_paquet','puPaquet','qtePaquet','author'];
    protected $table = 'tvente_detail_entree';
}
