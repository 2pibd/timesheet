<div>
    <label for="worker_id" class="block font-medium text-sm text-gray-700">{{ 'Worker Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="worker_id" name="worker_id" type="text" value="{{ isset($timesheet->worker_id) ? $timesheet->worker_id : ''}}" required>
    {!! $errors->first('worker_id', '<p>:message</p>') !!}
</div>
<div>
    <label for="assignment_id" class="block font-medium text-sm text-gray-700">{{ 'Assignment Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="assignment_id" name="assignment_id" type="text" value="{{ isset($timesheet->assignment_id) ? $timesheet->assignment_id : ''}}" >
    {!! $errors->first('assignment_id', '<p>:message</p>') !!}
</div>
<div>
    <label for="timesheet_date" class="block font-medium text-sm text-gray-700">{{ 'Timesheet Date' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="timesheet_date" name="timesheet_date" type="text" value="{{ isset($timesheet->timesheet_date) ? $timesheet->timesheet_date : ''}}" >
    {!! $errors->first('timesheet_date', '<p>:message</p>') !!}
</div>
<div>
    <label for="timesheet_number" class="block font-medium text-sm text-gray-700">{{ 'Timesheet Number' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="timesheet_number" name="timesheet_number" type="text" value="{{ isset($timesheet->timesheet_number) ? $timesheet->timesheet_number : ''}}" >
    {!! $errors->first('timesheet_number', '<p>:message</p>') !!}
</div>
<div>
    <label for="tax_year" class="block font-medium text-sm text-gray-700">{{ 'Tax Year' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="tax_year" name="tax_year" type="text" value="{{ isset($timesheet->tax_year) ? $timesheet->tax_year : ''}}" >
    {!! $errors->first('tax_year', '<p>:message</p>') !!}
</div>
<div>
    <label for="timesheet_authoriser_id" class="block font-medium text-sm text-gray-700">{{ 'Timesheet Authoriser Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="timesheet_authoriser_id" name="timesheet_authoriser_id" type="text" value="{{ isset($timesheet->timesheet_authoriser_id) ? $timesheet->timesheet_authoriser_id : ''}}" >
    {!! $errors->first('timesheet_authoriser_id', '<p>:message</p>') !!}
</div>
<div>
    <label for="start_week" class="block font-medium text-sm text-gray-700">{{ 'Start Week' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="start_week" name="start_week" type="text" value="{{ isset($timesheet->start_week) ? $timesheet->start_week : ''}}" >
    {!! $errors->first('start_week', '<p>:message</p>') !!}
</div>
<div>
    <label for="additional_expense" class="block font-medium text-sm text-gray-700">{{ 'Additional Expense' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="additional_expense" name="additional_expense" type="text" value="{{ isset($timesheet->additional_expense) ? $timesheet->additional_expense : ''}}" >
    {!! $errors->first('additional_expense', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
