<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class division extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'divisions';

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
    protected $fillable = ['business_id', 'name', 'ref_code'];


}
