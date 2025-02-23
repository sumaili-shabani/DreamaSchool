<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_categorie_produit extends Model
{
    protected $fillable=['id','designation','author'];
    protected $table = 'tvente_categorie_produit';


    public function produit()
    {
        return $this->belongsTo(tvente_produit::class, 'refCategorie');
    }
}
