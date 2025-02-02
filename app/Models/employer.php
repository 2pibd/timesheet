<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employers';

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
    protected $fillable = ['emp_ref', 'location_id', 'division_id', 'department_id'];

    
}
