<div class="mb-3">
    <label for="name" class="block font-medium text-sm text-gray-700">{{ 'Name' }}</label>
    <input class="form-control" id="name" name="name" type="text" value="{{ isset($division->name) ? $division->name : ''}}" required>
    {!! $errors->first('name', '<p>:message</p>') !!}
</div>


<div class="text-end mb-3">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
