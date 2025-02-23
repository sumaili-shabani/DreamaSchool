<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_typecompte extends Model
{
    protected $fillable=['id','nom_typecompte','author'];
    protected $table = 'tfin_typecompte';

}
