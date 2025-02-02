<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{


    public function  zone(){
        return $this->hasMany('App\Models\state' , 'country_id'  )->where('is_default','1');
    }
}
