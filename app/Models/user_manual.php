<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_manual extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_manuals';

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
    protected $fillable = ['name', 'description', 'client','worker','supplier','consultant', 'status', 'file'];


}
