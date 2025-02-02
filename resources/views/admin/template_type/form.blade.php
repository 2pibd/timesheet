<div class="row">
<div class="form-group col-md-12">
    <label for="type" class="block font-medium text-sm text-gray-700">{{ 'Type' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm  form-control" id="type" name="type" type="text" value="{{ isset($template_type->type) ? $template_type->type : ''}}" required>
    {!! $errors->first('type', '<p>:message</p>') !!}
</div>

<div class="form-group  mt-2">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Status' }}</label>
    <select class="form-select" id="status" name="status" >
        @foreach($status as $key=>$item)
            <option value="{{$item}}" {{(isset($template_type->status)&& ($template_type->status == $item) )? 'selected': ''}} >{{$item}}</option>
        @endforeach
    </select>
    {!! $errors->first('status', '<p>:message</p>') !!}
</div>


<div class="form-group text-right mt-2">
    <button type="submit" class="btn btn-primary rounded-md font-semibold   uppercase ">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
</div>
