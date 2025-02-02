<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('consultent_id')->nullable();
            $table->string('worker_surname')->nullable();
            $table->string('worker_forename')->nullable();
            $table->string('parsonal_ref')->nullable();
            $table->string('assignment_type_id')->nullable();
            $table->string('start_date')->nullable();
            $table->string('expected_end_date')->nullable();
            $table->string('actual_end_date')->nullable();
            $table->string('job_category')->nullable();
            $table->string('online_expences')->nullable();
            $table->string('online_expences_worker_print')->nullable();
            $table->string('online_escalation_type_override')->nullable();
            $table->string('online_timesheet_type_id')->nullable();
            $table->string('auth_group')->nullable();
            $table->string('prev_service')->nullable();
            $table->string('timesheet_frequency')->nullable();
            $table->string('assignment_en_reason')->nullable();
            $table->string('workflow_type')->nullable();
            $table->string('direct_client')->nullable();
            $table->string('booked_by')->nullable();
            $table->string('client_id')->nullable();
            $table->string('ts_authoriser')->nullable();
            $table->string('auth_group_details')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('reporting_to')->nullable();
            $table->string('purchase_order')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('invoice_address')->nullable();
            $table->string('report_to_client')->nullable();
            $table->string('invoice_to_client')->nullable();
            $table->string('holiday_entitlement_hourly')->nullable();
            $table->string('holiday_entitlement_week_per_annum')->nullable();
            $table->string('worker_awr_status')->nullable();
            $table->string('awr_qualification_weeks')->nullable();
            $table->string('actual_qualificatin_date')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assignments');
    }
}
