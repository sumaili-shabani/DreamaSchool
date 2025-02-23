<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_cloture_caisse extends Model
{
    protected $fillable=['id','refSscompte','date_cloture','montant_cloture','taux_dujour','author'];
    protected $table = 'tfin_cloture_caisse';
}
