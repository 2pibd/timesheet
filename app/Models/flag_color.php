<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class flag_color extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'flag_colors';

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
    protected $fillable = ['color_code', 'color_rgba','color_opacity', 'title'];


}
