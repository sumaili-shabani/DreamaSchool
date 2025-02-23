<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_detail_requisition extends Model
{
    protected $fillable=['id','refEnteteCmd','refProduit','puCmd','devise','taux','qteCmd','author'];
    protected $table = 'tvente_detail_requisition';
}
