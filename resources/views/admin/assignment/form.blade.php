<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="mb-3 d-flex">
            <label for="consultant_id" class="block font-medium text-sm text-gray-700 w-25">{{ 'Consultant' }}</label>
            <div class="w-75"><input class="form-control" id="consultant_id" name="consultant_id" type="text"
                   value="{{ isset($assignment->consultant_id) ? $assignment->consultant_id : ''}}" required>
            {!! $errors->first('consultant_id', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="worker_surname" class="block font-medium text-sm text-gray-700 w-25">{{ 'Worker Surname' }}</label>
            <div class="w-75"><input class="form-control" id="worker_surname" name="worker_surname" type="text"
                   value="{{ isset($assignment->worker_surname) ? $assignment->worker_surname : ''}}">
            {!! $errors->first('worker_surname', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="worker_forename" class="block font-medium text-sm text-gray-700 w-25">{{ 'Worker Forename' }}</label>
            <div class="w-75"><input class="form-control" id="worker_forename" name="worker_forename" type="text"
                   value="{{ isset($assignment->worker_forename) ? $assignment->worker_forename : ''}}">
            {!! $errors->first('worker_forename', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="personal_ref" class="block font-medium text-sm text-gray-700 w-25">{{ 'Personal Ref' }}</label>
            <div class="w-75"><input class="form-control" id="personal_ref" name="personal_ref" type="text"
                   value="{{ isset($assignment->personal_ref) ? $assignment->personal_ref : ''}}">
            {!! $errors->first('personal_ref', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="assignment_type_id"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Assignment Type Id' }}</label>
            <div class="w-75"><input class="form-control" id="assignment_type_id" name="assignment_type_id" type="text"
                   value="{{ isset($assignment->assignment_type_id) ? $assignment->assignment_type_id : ''}}">
            {!! $errors->first('assignment_type_id', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="start_date" class="block font-medium text-sm text-gray-700 w-25">{{ 'Start Date' }}</label>
            <div class="w-75"><input class="form-control" id="start_date" name="start_date" type="text"
                   value="{{ isset($assignment->start_date) ? $assignment->start_date : ''}}">
            {!! $errors->first('start_date', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="expected_end_date"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Expected End Date' }}</label>
            <div class="w-75"><input class="form-control" id="expected_end_date" name="expected_end_date" type="text"
                   value="{{ isset($assignment->expected_end_date) ? $assignment->expected_end_date : ''}}">
            {!! $errors->first('expected_end_date', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="actual_end_date" class="block font-medium text-sm text-gray-700 w-25">{{ 'Actual End Date' }}</label>
            <div class="w-75"><input class="form-control" id="actual_end_date" name="actual_end_date" type="text"
                   value="{{ isset($assignment->actual_end_date) ? $assignment->actual_end_date : ''}}">
            {!! $errors->first('actual_end_date', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="job_category" class="block font-medium text-sm text-gray-700 w-25">{{ 'Job Category' }}</label>
            <div class="w-75"><input class="form-control" id="job_category" name="job_category" type="text"
                   value="{{ isset($assignment->job_category) ? $assignment->job_category : ''}}">
            {!! $errors->first('job_category', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="online_expenses" class="block font-medium text-sm text-gray-700 w-25">{{ 'Online Expenses' }}</label>
            <div class="w-75"><input class="form-control" id="online_expences" name="online_expenses" type="text"
                   value="{{ isset($assignment->online_expenses) ? $assignment->online_expenses : ''}}">
            {!! $errors->first('online_expenses', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="online_expenses_worker_print"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Online Expenses Worker Print' }}</label>
            <div class="w-75"><input class="form-control" id="online_expenses_worker_print" name="online_expenses_worker_print"
                   type="text"
                   value="{{ isset($assignment->online_expenses_worker_print) ? $assignment->online_expenses_worker_print : ''}}">
            {!! $errors->first('online_expenses_worker_print', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="online_escalation_type_override"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Online Escalation Type Override' }}</label>
            <div class="w-75"><input class="form-control" id="online_escalation_type_override" name="online_escalation_type_override"
                   type="text"
                   value="{{ isset($assignment->online_escalation_type_override) ? $assignment->online_escalation_type_override : ''}}">
            {!! $errors->first('online_escalation_type_override', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="online_timesheet_type_id"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Online Timesheet Type Id' }}</label>
            <div class="w-75"><input class="form-control" id="online_timesheet_type_id" name="online_timesheet_type_id" type="text"
                   value="{{ isset($assignment->online_timesheet_type_id) ? $assignment->online_timesheet_type_id : ''}}">
            {!! $errors->first('online_timesheet_type_id', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="auth_group" class="block font-medium text-sm text-gray-700 w-25">{{ 'Auth Group' }}</label>
            <div class="w-75"><input class="form-control" id="auth_group" name="auth_group" type="text"
                   value="{{ isset($assignment->auth_group) ? $assignment->auth_group : ''}}">
            {!! $errors->first('auth_group', '<p>:message</p>') !!}
            </div>
        </div>
    </div>


    <div class="col-md-4 col-sm-12">
        <div class="mb-3 d-flex">
            <label for="prev_service" class="block font-medium text-sm text-gray-700 w-25">{{ 'Prev Service' }}</label>
            <div class="w-75"><input class="form-control" id="prev_service" name="prev_service" type="text"
                   value="{{ isset($assignment->prev_service) ? $assignment->prev_service : ''}}">
            {!! $errors->first('prev_service', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="timesheet_frequency"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Timesheet Frequency' }}</label>
            <div class="w-75"><input class="form-control" id="timesheet_frequency" name="timesheet_frequency" type="text"
                   value="{{ isset($assignment->timesheet_frequency) ? $assignment->timesheet_frequency : ''}}">
            {!! $errors->first('timesheet_frequency', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="assignment_en_reason"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Assignment En Reason' }}</label>
            <div class="w-75"><input class="form-control" id="assignment_en_reason" name="assignment_en_reason" type="text"
                   value="{{ isset($assignment->assignment_en_reason) ? $assignment->assignment_en_reason : ''}}">
            {!! $errors->first('assignment_en_reason', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="workflow_type" class="block font-medium text-sm text-gray-700 w-25">{{ 'Workflow Type' }}</label>
            <div class="w-75"><input class="form-control" id="workflow_type" name="workflow_type" type="text"
                   value="{{ isset($assignment->workflow_type) ? $assignment->workflow_type : ''}}">
            {!! $errors->first('workflow_type', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="direct_client" class="block font-medium text-sm text-gray-700 w-25">{{ 'Direct Client' }}</label>
            <div class="w-75"><input class="form-control" id="direct_client" name="direct_client" type="text"
                   value="{{ isset($assignment->direct_client) ? $assignment->direct_client : ''}}">
            {!! $errors->first('direct_client', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="booked_by" class="block font-medium text-sm text-gray-700 w-25">{{ 'Booked By' }}</label>
            <div class="w-75"><input class="form-control" id="booked_by" name="booked_by" type="text"
                   value="{{ isset($assignment->booked_by) ? $assignment->booked_by : ''}}">
            {!! $errors->first('booked_by', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="client_id" class="block font-medium text-sm text-gray-700 w-25">{{ 'Client Id' }}</label>
            <div class="w-75"><input class="form-control" id="client_id" name="client_id" type="text"
                   value="{{ isset($assignment->client_id) ? $assignment->client_id : ''}}">
            {!! $errors->first('client_id', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="ts_authoriser" class="block font-medium text-sm text-gray-700 w-25">{{ 'Ts Authoriser' }}</label>
            <div class="w-75"><input class="form-control" id="ts_authoriser" name="ts_authoriser" type="text"
                   value="{{ isset($assignment->ts_authoriser) ? $assignment->ts_authoriser : ''}}">
            {!! $errors->first('ts_authoriser', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="auth_group_details"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Auth Group Details' }}</label>
            <div class="w-75"><input class="form-control" id="auth_group_details" name="auth_group_details" type="text"
                   value="{{ isset($assignment->auth_group_details) ? $assignment->auth_group_details : ''}}">
            {!! $errors->first('auth_group_details', '<p>:message</p>') !!}
            </div>
        </div>
    </div>


    <div class="col-md-4 col-sm-12">
        <div class="mb-3 d-flex">
            <label for="contact_name" class="block font-medium text-sm text-gray-700 w-25">{{ 'Contact Name' }}</label>
            <div class="w-75"><input class="form-control" id="contact_name" name="contact_name" type="text"
                   value="{{ isset($assignment->contact_name) ? $assignment->contact_name : ''}}">
            {!! $errors->first('contact_name', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="reporting_to" class="block font-medium text-sm text-gray-700 w-25">{{ 'Reporting To' }}</label>
            <div class="w-75"><input class="form-control" id="reporting_to" name="reporting_to" type="text"
                   value="{{ isset($assignment->reporting_to) ? $assignment->reporting_to : ''}}">
            {!! $errors->first('reporting_to', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="purchase_order" class="block font-medium text-sm text-gray-700 w-25">{{ 'Purchase Order' }}</label>
            <div class="w-75"><input class="form-control" id="purchase_order" name="purchase_order" type="text"
                   value="{{ isset($assignment->purchase_order) ? $assignment->purchase_order : ''}}">
            {!! $errors->first('purchase_order', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="delivery_address"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Delivery Address' }}</label>
            <div class="w-75"><input class="form-control" id="delivery_address" name="delivery_address" type="text"
                   value="{{ isset($assignment->delivery_address) ? $assignment->delivery_address : ''}}">
            {!! $errors->first('delivery_address', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="invoice_address" class="block font-medium text-sm text-gray-700 w-25">{{ 'Invoice Address' }}</label>
            <div class="w-75"><input class="form-control" id="invoice_address" name="invoice_address" type="text"
                   value="{{ isset($assignment->invoice_address) ? $assignment->invoice_address : ''}}">
            {!! $errors->first('invoice_address', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="report_to_client"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Report To Client' }}</label>
            <div class="w-75"><input class="form-control" id="report_to_client" name="report_to_client" type="text"
                   value="{{ isset($assignment->report_to_client) ? $assignment->report_to_client : ''}}">
            {!! $errors->first('report_to_client', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="invoice_to_client"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Invoice To Client' }}</label>
            <div class="w-75"><input class="form-control" id="invoice_to_client" name="invoice_to_client" type="text"
                   value="{{ isset($assignment->invoice_to_client) ? $assignment->invoice_to_client : ''}}">
            {!! $errors->first('invoice_to_client', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="holiday_entitlement_hourly"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Holiday Entitlement Hourly' }}</label>
            <div class="w-75"><input class="form-control" id="holiday_entitlement_hourly" name="holiday_entitlement_hourly" type="text"
                   value="{{ isset($assignment->holiday_entitlement_hourly) ? $assignment->holiday_entitlement_hourly : ''}}">
            {!! $errors->first('holiday_entitlement_hourly', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="holiday_entitlement_week_per_annum"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Holiday Entitlement Week Per Annum' }}</label>
            <div class="w-75"><input class="form-control" id="holiday_entitlement_week_per_annum"
                   name="holiday_entitlement_week_per_annum" type="text"
                   value="{{ isset($assignment->holiday_entitlement_week_per_annum) ? $assignment->holiday_entitlement_week_per_annum : ''}}">
            {!! $errors->first('holiday_entitlement_week_per_annum', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="worker_awr_status"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Worker Awr Status' }}</label>
            <div class="w-75"><input class="form-control" id="worker_awr_status" name="worker_awr_status" type="text"
                   value="{{ isset($assignment->worker_awr_status) ? $assignment->worker_awr_status : ''}}">
            {!! $errors->first('worker_awr_status', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="awr_qualification_weeks"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Awr Qualification Weeks' }}</label>
            <div class="w-75"><input class="form-control" id="awr_qualification_weeks" name="awr_qualification_weeks" type="text"
                   value="{{ isset($assignment->awr_qualification_weeks) ? $assignment->awr_qualification_weeks : ''}}">
            {!! $errors->first('awr_qualification_weeks', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="actual_qualification_date"
                   class="block font-medium text-sm text-gray-700 w-25">{{ 'Actual Qualification Date' }}</label>
            <div class="w-75"><input class="form-control" id="actual_qualification_date" name="actual_qualification_date" type="text"
                   value="{{ isset($assignment->actual_qualification_date) ? $assignment->actual_qualification_date : ''}}">
            {!! $errors->first('actual_qualification_date', '<p>:message</p>') !!}
            </div>
        </div>

    </div>
</div>
<div class="flex items-center gap-4 text-end">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
