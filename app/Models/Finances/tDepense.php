<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tDepense extends Model
{
    protected $fillable=['id','montant','montantLettre','motif','dateOperation',
    'refMvt','refCompte','modepaie','refBanque','numeroBordereau','taux_dujour',
    "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
    ,"DateApproCoordi","numeroBE",'author'];
    protected $table = 'tdepense';
}
