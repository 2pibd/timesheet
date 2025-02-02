<div class="row  col-md-4">
<div class="form-group {{ $errors->has('seg_name') ? 'has-error' : ''}} ">
    <label for="seg_name" class="control-label">{{ 'Segment  Name' }}</label>
    <input class="form-control" name="seg_name" type="text" id="seg_name" value="{{ isset($segment_head->seg_name) ? $segment_head->seg_name : ''}}" required>
    {!! $errors->first('seg_name', '<p class="help-block">:message</p>') !!}
</div>
    <div class="row ">
<div class="form-group {{ $errors->has('min_length') ? 'has-error' : ''}}  mt-2  col-md-4">
    <label for="min_length" class="control-label">{{ 'Min length' }}</label>
    <input class="form-control" name="min_length" type="text" id="min_length" value="{{ isset($segment_head->min_length) ? $segment_head->min_length : ''}}" >
    {!! $errors->first('min_length', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('max_length') ? 'has-error' : ''}}   mt-2 col-md-4">
    <label for="max_length" class="control-label">{{ 'Max length' }}</label>
    <input class="form-control" name="max_length" type="text" id="max_length" value="{{ isset($segment_head->max_length) ? $segment_head->max_length : ''}}" >
    {!! $errors->first('max_length', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}} mt-2 col-md-4">
    <label for="status" class="control-label">{{ 'Status' }}</label>

    <select class="form-control" name="status"  id="status">

        @foreach($enumstatus as $key=>$value)
            <option value="{{$value}}" @if(isset($segment_head->status) && $segment_head->status == $value ) selected="selected" @endif>{{$value}} </option>
        @endforeach
    </select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>

<div class="mt-2 col-md-12 text-end">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
    </div>
</div>
