<div class="d-flex">
<div class="mb-3 w-50">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Status Label' }}</label>
    <input class="form-control" id="status" name="status" type="text" value="{{ isset($timesheet_status->status) ? $timesheet_status->status : ''}}" >
    {!! $errors->first('status', '<p>:message</p>') !!}
</div>
<div class="mb-3 mx-2 w-25">
    <label for="code" class="block font-medium text-sm text-gray-700">{{ 'Code' }}</label>
    <input class="form-control" id="code" name="code" type="text" value="{{ isset($timesheet_status->code) ? $timesheet_status->code : ''}}" required>
    {!! $errors->first('code', '<p>:message</p>') !!}
</div>
    <div class="mb-3  w-25">
        <label for="flag_id" class="block font-medium text-sm text-gray-700">{{ 'Flag' }}</label>
        <select class="form-select" id="flag_id" name="flag_id" >
            <option value="">--Flag Color--</option>
            @foreach($flag_colors as $key=>$item)
                <option value="{{$item->id}}" {{(isset($timesheet_status->flag) && ($timesheet_status->flag == $item->id) )? 'selected': ''}} >{{$item->title}}</option>
            @endforeach
        </select>

        {!! $errors->first('flag_id', '<p>:message</p>') !!}
    </div>
</div>
<div class="mb-3">
    <label for="details" class="block font-medium text-sm text-gray-700">{{ 'Details' }}</label>
    <input class="form-control" id="details" name="details" type="text" value="{{ isset($timesheet_status->details) ? $timesheet_status->details : ''}}" >
    {!! $errors->first('details', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4 text-end">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
