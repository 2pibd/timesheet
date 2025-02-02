<div class="row">
    <div class="col-md-6 col-sm-12">
<div class="mb-3 d-flex">
    <label for="user_login_id" class="w-50">{{ 'User Login Id' }}</label>
    <input class="form-control" id="user_login_id" name="user_login_id" type="text" value="{{ isset($worker->user_login_id) ? $worker->user_login_id : ''}}" required>
    {!! $errors->first('user_login_id', '<p>:message</p>') !!}
</div>

<div class="mb-3">
    <label for="emp_ref" class="block font-medium text-sm text-gray-700">{{ 'Emp Ref' }}</label>
    <input class="form-control" id="emp_ref" name="emp_ref" type="text" value="{{ isset($worker->emp_ref) ? $worker->emp_ref : ''}}" >
    {!! $errors->first('emp_ref', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="personal_ref" class="block font-medium text-sm text-gray-700">{{ 'Personal Ref' }}</label>
    <input class="form-control" id="personal_ref" name="personal_ref" type="text" value="{{ isset($worker->personal_ref) ? $worker->personal_ref : ''}}" >
    {!! $errors->first('personal_ref', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="first_forename" class="block font-medium text-sm text-gray-700">{{ 'First Forename' }}</label>
    <input class="form-control" id="first_forename" name="first_forename" type="text" value="{{ isset($worker->first_forename) ? $worker->first_forename : ''}}" >
    {!! $errors->first('first_forename', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="second_forename" class="block font-medium text-sm text-gray-700">{{ 'Second Forename' }}</label>
    <input class="form-control" id="second_forename" name="second_forename" type="text" value="{{ isset($worker->second_forename) ? $worker->second_forename : ''}}" >
    {!! $errors->first('second_forename', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="third_forename" class="block font-medium text-sm text-gray-700">{{ 'Third Forename' }}</label>
    <input class="form-control" id="third_forename" name="third_forename" type="text" value="{{ isset($worker->third_forename) ? $worker->third_forename : ''}}" >
    {!! $errors->first('third_forename', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="surname" class="block font-medium text-sm text-gray-700">{{ 'Surname' }}</label>
    <input class="form-control" id="surname" name="surname" type="text" value="{{ isset($worker->surname) ? $worker->surname : ''}}" >
    {!! $errors->first('surname', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="paye_code" class="block font-medium text-sm text-gray-700">{{ 'Paye Code' }}</label>
    <input class="form-control" id="paye_code" name="paye_code" type="text" value="{{ isset($worker->paye_code) ? $worker->paye_code : ''}}" >
    {!! $errors->first('paye_code', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="ni_number" class="block font-medium text-sm text-gray-700">{{ 'Ni Number' }}</label>
    <input class="form-control" id="ni_number" name="ni_number" type="text" value="{{ isset($worker->ni_number) ? $worker->ni_number : ''}}" >
    {!! $errors->first('ni_number', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="gender" class="block font-medium text-sm text-gray-700">{{ 'Gender' }}</label>
    <input class="form-control" id="gender" name="gender" type="text" value="{{ isset($worker->gender) ? $worker->gender : ''}}" >
    {!! $errors->first('gender', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="address_line1" class="block font-medium text-sm text-gray-700">{{ 'Address Line1' }}</label>
    <input class="form-control" id="address_line1" name="address_line1" type="text" value="{{ isset($worker->address_line1) ? $worker->address_line1 : ''}}" >
    {!! $errors->first('address_line1', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="address_line2" class="block font-medium text-sm text-gray-700">{{ 'Address Line2' }}</label>
    <input class="form-control" id="address_line2" name="address_line2" type="text" value="{{ isset($worker->address_line2) ? $worker->address_line2 : ''}}" >
    {!! $errors->first('address_line2', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="address_line3" class="block font-medium text-sm text-gray-700">{{ 'Address Line3' }}</label>
    <input class="form-control" id="address_line3" name="address_line3" type="text" value="{{ isset($worker->address_line3) ? $worker->address_line3 : ''}}" >
    {!! $errors->first('address_line3', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="address_line4" class="block font-medium text-sm text-gray-700">{{ 'Address Line4' }}</label>
    <input class="form-control" id="address_line4" name="address_line4" type="text" value="{{ isset($worker->address_line4) ? $worker->address_line4 : ''}}" >
    {!! $errors->first('address_line4', '<p>:message</p>') !!}
</div>
    </div>



    <div class="col-md-6 col-sm-12">
<div class="mb-3">
    <label for="address_line5" class="block font-medium text-sm text-gray-700">{{ 'Address Line5' }}</label>
    <input class="form-control" id="address_line5" name="address_line5" type="text" value="{{ isset($worker->address_line5) ? $worker->address_line5 : ''}}" >
    {!! $errors->first('address_line5', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="post_code" class="block font-medium text-sm text-gray-700">{{ 'Post Code' }}</label>
    <input class="form-control" id="post_code" name="post_code" type="text" value="{{ isset($worker->post_code) ? $worker->post_code : ''}}" >
    {!! $errors->first('post_code', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="country_id" class="block font-medium text-sm text-gray-700">{{ 'Country Id' }}</label>
    <input class="form-control" id="country_id" name="country_id" type="text" value="{{ isset($worker->country_id) ? $worker->country_id : ''}}" >
    {!! $errors->first('country_id', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="tel_number" class="block font-medium text-sm text-gray-700">{{ 'Tel Number' }}</label>
    <input class="form-control" id="tel_number" name="tel_number" type="text" value="{{ isset($worker->tel_number) ? $worker->tel_number : ''}}" >
    {!! $errors->first('tel_number', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="mobile_number" class="block font-medium text-sm text-gray-700">{{ 'Mobile Number' }}</label>
    <input class="form-control" id="mobile_number" name="mobile_number" type="text" value="{{ isset($worker->mobile_number) ? $worker->mobile_number : ''}}" >
    {!! $errors->first('mobile_number', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="email" class="block font-medium text-sm text-gray-700">{{ 'Email' }}</label>
    <input class="form-control" id="email" name="email" type="text" value="{{ isset($worker->email) ? $worker->email : ''}}" >
    {!! $errors->first('email', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="dob" class="block font-medium text-sm text-gray-700">{{ 'Dob' }}</label>
    <input class="form-control" id="dob" name="dob" type="text" value="{{ isset($worker->dob) ? $worker->dob : ''}}" >
    {!! $errors->first('dob', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="worker_type" class="block font-medium text-sm text-gray-700">{{ 'Worker Type' }}</label>
    <input class="form-control" id="worker_type" name="worker_type" type="text" value="{{ isset($worker->worker_type) ? $worker->worker_type : ''}}" >
    {!! $errors->first('worker_type', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="awr_type" class="block font-medium text-sm text-gray-700">{{ 'Awr Type' }}</label>
    <input class="form-control" id="awr_type" name="awr_type" type="text" value="{{ isset($worker->awr_type) ? $worker->awr_type : ''}}" >
    {!! $errors->first('awr_type', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="non_cis_utr" class="block font-medium text-sm text-gray-700">{{ 'Non Cis Utr' }}</label>
    <input class="form-control" id="non_cis_utr" name="non_cis_utr" type="text" value="{{ isset($worker->non_cis_utr) ? $worker->non_cis_utr : ''}}" >
    {!! $errors->first('non_cis_utr', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="known_as" class="block font-medium text-sm text-gray-700">{{ 'Known As' }}</label>
    <input class="form-control" id="known_as" name="known_as" type="text" value="{{ isset($worker->known_as) ? $worker->known_as : ''}}" >
    {!! $errors->first('known_as', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Status' }}</label>
    <input class="form-control" id="status" name="status" type="text" value="{{ isset($worker->status) ? $worker->status : ''}}" >
    {!! $errors->first('status', '<p>:message</p>') !!}
</div>

</div>
<div class="flex text-end gap-4">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
