<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_classe extends Model
{
    protected $fillable=['id','nom_classe','numero_classe','author'];
    protected $table = 'tfin_classe';
}
