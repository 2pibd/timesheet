<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class boundary_validation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'boundary_validations';

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
    protected $fillable = ['division_id', 'hour_day_min', 'hour_day_max', 'days_day_min', 'days_day_max', 'hour_week_min', 'hour_week_max', 'days_week_min', 'days_week_max',
        'hour_month_min','hour_month_max','days_month_min', 'days_month_max', 'status'];


    public function division(){
        return $this->belongsTo('App\Models\division', 'division_id'   );
    }


}
