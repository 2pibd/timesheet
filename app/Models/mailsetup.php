<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mailsetup extends Model
{
    //
    protected $table = 'mailsetups';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'host', 'port', 'encryption', 'username', 'password','protocol','status'];

}
