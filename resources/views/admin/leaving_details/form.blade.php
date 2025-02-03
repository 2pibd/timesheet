<div>
    <label for="employer_id" class="block font-medium text-sm text-gray-700">{{ 'Employer Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="employer_id" name="employer_id" type="text" value="{{ isset($leaving_detail->employer_id) ? $leaving_detail->employer_id : ''}}" required>
    {!! $errors->first('employer_id', '<p>:message</p>') !!}
</div>
<div>
    <label for="personal_ref" class="block font-medium text-sm text-gray-700">{{ 'Personal Ref' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="personal_ref" name="personal_ref" type="text" value="{{ isset($leaving_detail->personal_ref) ? $leaving_detail->personal_ref : ''}}" >
    {!! $errors->first('personal_ref', '<p>:message</p>') !!}
</div>
<div>
    <label for="leaving_date" class="block font-medium text-sm text-gray-700">{{ 'Leaving Date' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="leaving_date" name="leaving_date" type="text" value="{{ isset($leaving_detail->leaving_date) ? $leaving_detail->leaving_date : ''}}" >
    {!! $errors->first('leaving_date', '<p>:message</p>') !!}
</div>
<div>
    <label for="leaving_reason" class="block font-medium text-sm text-gray-700">{{ 'Leaving Reason' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="leaving_reason" name="leaving_reason" type="text" value="{{ isset($leaving_detail->leaving_reason) ? $leaving_detail->leaving_reason : ''}}" >
    {!! $errors->first('leaving_reason', '<p>:message</p>') !!}
</div>
<div>
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Status' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="status" name="status" type="text" value="{{ isset($leaving_detail->status) ? $leaving_detail->status : ''}}" >
    {!! $errors->first('status', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
