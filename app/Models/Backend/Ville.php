<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    //
    protected $fillable = [
        'idProvince', 'nomVille'
    ];
}
