<div class="mb-3">
    <label for="name" class="block font-medium text-sm text-gray-700">{{ 'Name*' }}</label>
    <input class="form-control" id="name" name="name" type="text" value="{{ isset($department->name) ? $department->name : ''}}" required>
    {!! $errors->first('name', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="ref_code" class="block font-medium text-sm text-gray-700">{{ 'Ref Code*' }}</label>
    <input class="form-control" id="ref_code" name="ref_code" required type="text" value="{{ isset($department->ref_code) ? $department->ref_code : ''}}" >
    {!! $errors->first('ref_code', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4 text-end">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
