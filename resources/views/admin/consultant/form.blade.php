<div>
    <label for="user_id" class="block font-medium text-sm text-gray-700">{{ 'User Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="user_id" name="user_id" type="text" value="{{ isset($consultant->user_id) ? $consultant->user_id : ''}}" required>
    {!! $errors->first('user_id', '<p>:message</p>') !!}
</div>
<div>
    <label for="user_ref" class="block font-medium text-sm text-gray-700">{{ 'User Ref' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="user_ref" name="user_ref" type="text" value="{{ isset($consultant->user_ref) ? $consultant->user_ref : ''}}" >
    {!! $errors->first('user_ref', '<p>:message</p>') !!}
</div>
<div>
    <label for="ref_code" class="block font-medium text-sm text-gray-700">{{ 'Ref Code' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="ref_code" name="ref_code" type="text" value="{{ isset($consultant->ref_code) ? $consultant->ref_code : ''}}" >
    {!! $errors->first('ref_code', '<p>:message</p>') !!}
</div>
<div>
    <label for="access_code" class="block font-medium text-sm text-gray-700">{{ 'Access Code' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="access_code" name="access_code" type="text" value="{{ isset($consultant->access_code) ? $consultant->access_code : ''}}" >
    {!! $errors->first('access_code', '<p>:message</p>') !!}
</div>
<div>
    <label for="officeial_id" class="block font-medium text-sm text-gray-700">{{ 'Officeial Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="officeial_id" name="officeial_id" type="text" value="{{ isset($consultant->officeial_id) ? $consultant->officeial_id : ''}}" >
    {!! $errors->first('officeial_id', '<p>:message</p>') !!}
</div>
<div>
    <label for="work_telephone" class="block font-medium text-sm text-gray-700">{{ 'Work Telephone' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="work_telephone" name="work_telephone" type="text" value="{{ isset($consultant->work_telephone) ? $consultant->work_telephone : ''}}" >
    {!! $errors->first('work_telephone', '<p>:message</p>') !!}
</div>
<div>
    <label for="mobile_number" class="block font-medium text-sm text-gray-700">{{ 'Mobile Number' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="mobile_number" name="mobile_number" type="text" value="{{ isset($consultant->mobile_number) ? $consultant->mobile_number : ''}}" >
    {!! $errors->first('mobile_number', '<p>:message</p>') !!}
</div>
<div>
    <label for="address_line1" class="block font-medium text-sm text-gray-700">{{ 'Address Line1' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="address_line1" name="address_line1" type="text" value="{{ isset($consultant->address_line1) ? $consultant->address_line1 : ''}}" >
    {!! $errors->first('address_line1', '<p>:message</p>') !!}
</div>
<div>
    <label for="address_line2" class="block font-medium text-sm text-gray-700">{{ 'Address Line2' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="address_line2" name="address_line2" type="text" value="{{ isset($consultant->address_line2) ? $consultant->address_line2 : ''}}" >
    {!! $errors->first('address_line2', '<p>:message</p>') !!}
</div>
<div>
    <label for="address_line3" class="block font-medium text-sm text-gray-700">{{ 'Address Line3' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="address_line3" name="address_line3" type="text" value="{{ isset($consultant->address_line3) ? $consultant->address_line3 : ''}}" >
    {!! $errors->first('address_line3', '<p>:message</p>') !!}
</div>
<div>
    <label for="address_line4" class="block font-medium text-sm text-gray-700">{{ 'Address Line4' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="address_line4" name="address_line4" type="text" value="{{ isset($consultant->address_line4) ? $consultant->address_line4 : ''}}" >
    {!! $errors->first('address_line4', '<p>:message</p>') !!}
</div>
<div>
    <label for="post_code" class="block font-medium text-sm text-gray-700">{{ 'Post Code' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="post_code" name="post_code" type="text" value="{{ isset($consultant->post_code) ? $consultant->post_code : ''}}" >
    {!! $errors->first('post_code', '<p>:message</p>') !!}
</div>
<div>
    <label for="office_manager" class="block font-medium text-sm text-gray-700">{{ 'Office Manager' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="office_manager" name="office_manager" type="text" value="{{ isset($consultant->office_manager) ? $consultant->office_manager : ''}}" >
    {!! $errors->first('office_manager', '<p>:message</p>') !!}
</div>
<div>
    <label for="security_admin" class="block font-medium text-sm text-gray-700">{{ 'Security Admin' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="security_admin" name="security_admin" type="text" value="{{ isset($consultant->security_admin) ? $consultant->security_admin : ''}}" >
    {!! $errors->first('security_admin', '<p>:message</p>') !!}
</div>
<div>
    <label for="read_only_access" class="block font-medium text-sm text-gray-700">{{ 'Read Only Access' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="read_only_access" name="read_only_access" type="text" value="{{ isset($consultant->read_only_access) ? $consultant->read_only_access : ''}}" >
    {!! $errors->first('read_only_access', '<p>:message</p>') !!}
</div>
<div>
    <label for="template_id" class="block font-medium text-sm text-gray-700">{{ 'Template Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="template_id" name="template_id" type="text" value="{{ isset($consultant->template_id) ? $consultant->template_id : ''}}" >
    {!! $errors->first('template_id', '<p>:message</p>') !!}
</div>
<div>
    <label for="language_id" class="block font-medium text-sm text-gray-700">{{ 'Language Id' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="language_id" name="language_id" type="text" value="{{ isset($consultant->language_id) ? $consultant->language_id : ''}}" >
    {!! $errors->first('language_id', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
