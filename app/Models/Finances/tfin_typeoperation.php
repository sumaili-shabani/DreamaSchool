<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_typeoperation extends Model
{
    protected $fillable=['id','nom_typeoperation','author'];
    protected $table = 'tfin_typeoperation';  

}
