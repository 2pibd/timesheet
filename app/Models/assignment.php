<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class assignment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'assignments';

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
    protected $fillable = ['consultent_id', 'worker_surname', 'worker_forename', 'parsonal_ref', 'assignment_type_id', 'start_date', 'expected_end_date', 'actual_end_date', 'job_category', 'online_expences', 'online_expences_worker_print', 'online_escalation_type_override', 'online_timesheet_type_id', 'auth_group', 'prev_service', 'timesheet_frequency', 'assignment_en_reason', 'workflow_type', 'direct_client', 'booked_by', 'client_id', 'ts_authoriser', 'auth_group_details', 'contact_name', 'reporting_to', 'purchase_order', 'delivery_address', 'invoice_address', 'report_to_client', 'invoice_to_client', 'holiday_entitlement_hourly', 'holiday_entitlement_week_per_annum', 'worker_awr_status', 'awr_qualification_weeks', 'actual_qualificatin_date'];

    
}
