<div class="col-md-6 col-sm-12">
    <div class="mb-3 d-flex align-items-center">
    <label for="client_id" class="block font-medium text-sm text-gray-700">{{ 'Client Name' }}</label>
    <input class="form-control w-75 ms-auto" id="client_id" name="client_id" type="text" value="{{ isset($timesheet->client_id) ? $timesheet->client_id : ''}}" required>
    {!! $errors->first('client_id', '<p>:message</p>') !!}
</div>

<div class="mb-3 d-flex align-items-center">
    <label for="assignment_id" class="block font-medium text-sm text-gray-700">{{ 'Assignment' }}</label>
    <input class="form-control w-75 ms-auto" id="assignment_id" name="assignment_id" type="text" value="{{ isset($timesheet->assignment_id) ? $timesheet->assignment_id : ''}}" >
    {!! $errors->first('assignment_id', '<p>:message</p>') !!}
</div>

<div class="mb-3 d-flex align-items-center">
    <label for="timesheet_date" class="block font-medium text-sm text-gray-700">{{ 'Timesheet Date' }}</label>
    <input class="form-control w-75 ms-auto" id="timesheet_date" name="timesheet_date" type="text" value="{{ isset($timesheet->timesheet_date) ? $timesheet->timesheet_date : ''}}" >
    {!! $errors->first('timesheet_date', '<p>:message</p>') !!}
</div>

<div class="mb-3 d-flex align-items-center">
    <label for="timesheet_number" class="block font-medium text-sm text-gray-700">{{ 'Timesheet Number' }}</label>
    <input class="form-control w-75 ms-auto" id="timesheet_number" name="timesheet_number" type="text" value="{{ isset($timesheet->timesheet_number) ? $timesheet->timesheet_number : ''}}" >
    {!! $errors->first('timesheet_number', '<p>:message</p>') !!}
</div>

<div class="mb-3 d-flex align-items-center">
    <label for="tax_year" class="block font-medium text-sm text-gray-700">{{ 'Tax Year' }}</label>
    <input class="form-control w-75 ms-auto" id="tax_year" name="tax_year" type="text" value="{{ isset($timesheet->tax_year) ? $timesheet->tax_year : ''}}" >
    {!! $errors->first('tax_year', '<p>:message</p>') !!}
</div>

<div class="mb-3 d-flex align-items-center">
    <label for="timesheet_authoriser_id" class="block font-medium text-sm text-gray-700">{{ 'Timesheet Authoriser' }}</label>
    <input class="form-control w-75 ms-auto" id="timesheet_authoriser_id" name="timesheet_authoriser_id" type="text" value="{{ isset($timesheet->timesheet_authoriser_id) ? $timesheet->timesheet_authoriser_id : ''}}" >
    {!! $errors->first('timesheet_authoriser_id', '<p>:message</p>') !!}
</div>
<div class="mb-3 d-flex align-items-center">
    <label for="start_week" class="block font-medium text-sm text-gray-700">{{ 'Start Week' }}</label>
    <input class="form-control w-75 ms-auto" id="start_week" name="start_week" type="text" value="{{ isset($timesheet->start_week) ? $timesheet->start_week : ''}}" >
    {!! $errors->first('start_week', '<p>:message</p>') !!}
</div>
<div class="mb-3 d-flex align-items-center">
    <label for="additional_expense" class="block font-medium text-sm text-gray-700">{{ 'Additional Expense' }}</label>
    <input class="form-control w-75 ms-auto" id="additional_expense" name="additional_expense" type="text" value="{{ isset($timesheet->additional_expense) ? $timesheet->additional_expense : ''}}" >
    {!! $errors->first('additional_expense', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4 text-end">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
</div>
