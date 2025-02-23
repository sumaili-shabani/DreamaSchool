<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_cloture_comptabilite extends Model
{
    protected $fillable=['id','dateCloture','tauxdujour','numerOperation','author'];
    protected $table = 'tfin_cloture_comptabilite';
}
