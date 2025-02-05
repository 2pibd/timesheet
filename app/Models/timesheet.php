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
    protected $fillable = ['assignment_id','timesheet_date','total_pay' ,'total_charge', 'invoice_no','tax_year', 'release_date',
       'timesheet_authoriser_id','additional_expense', 'start_week', 'timesheet_week_ending_date', 'worker_id',  'employer_id',
       'timesheet_number','consultant_id','client_id','po_number','worker_status','delivery_address','invoice_address',
        'holiday_entitlement_hourly','holiday_entitlement_weeks_per_annum',
      'comments' ,'online_type','division','department','year' ,'period','internal_timesheet_status', 'extranal_timesheet_status',
        'supplier_submitted','worker_submitted', 'consultant_submitted', 'number_of_days_work','documents','status'];


}
