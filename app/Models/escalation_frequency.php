<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class escalation_frequency extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'escalation_frequencies';

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

    protected $fillable = ['description', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday',
        'start_time', 'end_time', 'interval'];

}
