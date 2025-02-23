<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_paiement extends Model
{
    protected $fillable=['id','refEnteteVente','montant_paie','devise','taux',
    'date_paie','modepaie','libellepaie','refBanque','numeroBordereau','author'];
    protected $table = 'tvente_paiement';
}
