<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    //
    protected $fillable = [
        'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube'
    ];
}
