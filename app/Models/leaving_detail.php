<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class leaving_detail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'leaving_details';

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
    protected $fillable = ['employer_ref', 'personal_ref', 'leaving_date', 'leaving_reason', 'status'];


}
