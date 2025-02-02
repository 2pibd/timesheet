<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_address extends Model
{
    protected $fillable = [
        'name',
        'name_title',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'gender',
        'phone',
        'photo',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User', "user_id");
    }

}
