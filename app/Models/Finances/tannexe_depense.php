<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tannexe_depense extends Model
{
    protected $fillable=['id','noms_annexe','refDepense','annexe','author'];
    protected $table = 'tannexe_depense';
}
