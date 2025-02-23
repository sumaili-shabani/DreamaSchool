<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_produit extends Model
{
    protected $fillable=['id','designation','pu','qte_unite','devise','taux','unite','refCategorie','author'];
    protected $table = 'tvente_produit';

    // protected $appends=[
    //         'designatioProduit'
    // ];

    // public function getDesignationProduitAttribute()
    // {
    //    return $this->categories ? $this->categories->designation : "";
    // }

    public function categories()
    {
        return $this->hasMany(tvente_categorie_produit::class, 'refCategorie');
    }

}
