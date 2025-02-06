<div class="d-flex gap-2">
<div class="mb-3 w-50">
    <label for="my_office_name" class="block font-medium text-sm text-gray-700">{{ 'Employer Name*' }}</label>
    <select class="form-select" id="client_ref" name="client_ref" required>
        <option value="">--Select One--</option>
        @foreach($clients as $key=>$item)
            <option
                value="{{$item->external_ref}}" {{(isset($my_office->client_ref) && ($my_office->client_ref == $item->external_ref) )? 'selected': ''}} >{{$item->external_ref}}:: {{$item->company_name}}</option>
        @endforeach
    </select>
     {!! $errors->first('my_office_name', '<p>:message</p>') !!}
</div>
</div>


<div class="mb-3 w-50">
    <label for="department_ref" class="block font-medium text-sm text-gray-700">{{ 'Department' }}</label>
    <select class="form-select" id="department_ref" name="department_ref" required>
        <option value="">--Select One--</option>
        @foreach($departments as $key=>$item)
            <option
                value="{{$item->ref_code}}" {{(isset($my_office->division_ref) && ($my_office->division_ref == $item->ref_code) )? 'selected': ''}} >{{$item->ref_code}}:: {{$item->name}}</option>
        @endforeach
    </select>
    {!! $errors->first('department_ref', '<p>:message</p>') !!}
</div>



<div class="mb-3 w-50">
    <label for="division_ref" class="block font-medium text-sm text-gray-700">{{ 'Division*' }}</label>
    <select class="form-select" id="division_ref" name="division_ref" required>
        <option value="">--Select One--</option>
        @foreach($divisions as $key=>$item)
            <option
                value="{{$item->ref_code}}" {{(isset($my_office->division_ref) && ($my_office->division_ref == $item->ref_code) )? 'selected': ''}} >{{$item->ref_code}}:: {{$item->name}}</option>
        @endforeach
    </select>
   {!! $errors->first('division_ref', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4 text-end">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
