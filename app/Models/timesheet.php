<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class timesheet extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timesheets';

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
    protected $fillable = ['worker_id', 'assignment_id', 'timesheet_date', 'timesheet_number', 'tax_year', 'timesheet_authoriser_id', 'start_week', 'additional_expense'];

    
}
