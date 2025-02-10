<div class="mb-3">
    <label for="employer_id" class="block font-medium text-sm text-gray-700">{{ 'Employer Ref.*' }}</label>
    <select class="form-select" name="employer_id">
        <option value="">--Select--</option>
        @foreach($employers as $item)
            <option
                value="{{$item->id}}" {{(isset($leaving_detail->employer_id) && ($leaving_detail->employer_id == $item->id) )? 'selected': ''}} >{{$item->external_ref}} :: {{$item->company_name}}</option>

        @endforeach
    </select>
     {!! $errors->first('employer_id', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="personal_ref" class="block font-medium text-sm text-gray-700">{{ 'Personal Ref' }}</label>
    <input class="form-control" id="personal_ref" name="personal_ref" type="text" value="{{ isset($leaving_detail->personal_ref) ? $leaving_detail->personal_ref : ''}}" >
    {!! $errors->first('personal_ref', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="leaving_date" class="block font-medium text-sm text-gray-700">{{ 'Leaving Date' }}</label>
    <input class="form-control" id="leaving_date" name="leaving_date" type="date" value="{{ isset($leaving_detail->leaving_date) ? $leaving_detail->leaving_date : ''}}" >
    {!! $errors->first('leaving_date', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="leaving_reason" class="block font-medium text-sm text-gray-700">{{ 'Leaving Reason' }}</label>
    <input class="form-control" id="leaving_reason" name="leaving_reason" type="text" value="{{ isset($leaving_detail->leaving_reason) ? $leaving_detail->leaving_reason : ''}}" >
    {!! $errors->first('leaving_reason', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Status' }}</label>
    <select class="form-select" name="language_id" required>
        <option value="">--Select--</option>
        @foreach($status as $item)
            <option @if((isset($leaving_detail->status) && $leaving_detail->status==$item)  ) selected @endif value="{{$item}}">{{$item}}</option>
        @endforeach
    </select>

    {!! $errors->first('status', '<p>:message</p>') !!}
</div>


<div class="flex items-center text-end gap-4">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
