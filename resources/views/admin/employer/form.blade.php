<div>
    <label for="emp_ref" class="block font-medium text-sm text-gray-700">{{ 'Emp Ref' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="emp_ref" name="emp_ref" type="text" value="{{ isset($employer->emp_ref) ? $employer->emp_ref : ''}}" required>
    {!! $errors->first('emp_ref', '<p>:message</p>') !!}
</div>
<div>
    <label for="location_id" class="block font-medium text-sm text-gray-700">{{ 'Location Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="location_id" name="location_id" type="text" value="{{ isset($employer->location_id) ? $employer->location_id : ''}}" >
    {!! $errors->first('location_id', '<p>:message</p>') !!}
</div>
<div>
    <label for="division_id" class="block font-medium text-sm text-gray-700">{{ 'Division Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="division_id" name="division_id" type="text" value="{{ isset($employer->division_id) ? $employer->division_id : ''}}" >
    {!! $errors->first('division_id', '<p>:message</p>') !!}
</div>
<div>
    <label for="department_id" class="block font-medium text-sm text-gray-700">{{ 'Department Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="department_id" name="department_id" type="text" value="{{ isset($employer->department_id) ? $employer->department_id : ''}}" >
    {!! $errors->first('department_id', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
