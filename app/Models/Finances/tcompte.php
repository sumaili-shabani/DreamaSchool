<?php

namespace App\Models\Finances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcompte extends Model
{
    protected $fillable=['id','designation','refMvt','refSscompte'];
    protected $table = 'tcompte';
}
