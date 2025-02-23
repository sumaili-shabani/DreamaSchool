<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_detail_operationcompte extends Model
{
    protected $fillable=['id','refEnteteOperation','refSscompte','typeOperation','montantOpration'];
    protected $table = 'tfin_detail_operationcompte';
}
