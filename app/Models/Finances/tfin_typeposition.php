<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfin_typeposition extends Model
{
    protected $fillable=['id','nom_typeposition','author'];
    protected $table = 'tfin_typeposition';   
}
