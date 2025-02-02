<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class time_zone extends Model
{
    protected $table = 'time_zones';

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
    protected $fillable = ['tz_name', 'country_code', 'utc_offset', 'utc_dst_offset'];
}
