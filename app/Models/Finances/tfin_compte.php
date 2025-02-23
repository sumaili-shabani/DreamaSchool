<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_compte extends Model
{
    protected $fillable=['id','refClasse','refTypecompte','refPosition','nom_compte','numero_compte','author'];
    protected $table = 'tfin_compte';
}
