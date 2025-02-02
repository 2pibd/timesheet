<div class="row">

<div class="form-group {{ $errors->has('seg_head_id') ? 'has-error' : ''}}  col-md-4">
    <label for="seg_head_id" class="control-label">{{ 'Segment Head ' }}</label>
    <select class="form-select" name="seg_head_id"  id="seg_head_id" required>
        <option value="">--Select One--</option>
        @foreach($segment_head as $key=>$value)
            <option value="{{$value->id}}" data-min="{{$value->min_length}}"  data-max="{{$value->max_length}}" @if(isset($segment_head_detail->seg_head_id) && $segment_head_detail->seg_head_id == $value->id  || old('seg_head_id') == $value) selected="selected" @endif>{{$value->seg_name}} </option>
        @endforeach
    </select>
      {!! $errors->first('seg_head_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('seg_code') ? 'has-error' : ''}}   col-md-4">
    <label for="seg_code" class="control-label">{{ 'Segment Code' }}</label>
    <input class="form-control seg_code" name="seg_code" type="text" id="seg_code" max="1" required min="1" minlength="1" maxlength="1" value="{{ isset($segment_head_detail->seg_code) ? $segment_head_detail->seg_code :  old('seg_code')}}"  pattern="[0-9, A-Z]*"  >
    {!! $errors->first('seg_code', '<p class="help-block">:message</p>') !!}
</div>

    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}  col-md-4">
        <label for="status" class="control-label">{{ 'Status' }}</label>

        <select class="form-control" name="status"  id="status">

            @foreach($enumstatus as $key=>$value)
                <option value="{{$value}}" @if(isset($segment_head_detail->status) && $segment_head_detail->status == $value || old('status') == $value ) selected="selected" @endif>{{$value}} </option>
            @endforeach
        </select>
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>

<div class="form-group {{ $errors->has('details') ? 'has-error' : ''}}   col-md-12">
    <label for="details" class="control-label">{{ 'Details' }}</label>
    <input class="form-control" name="details" type="text" id="details" value="{{ isset($segment_head_detail->details) ? $segment_head_detail->details :  old('details') }}"  required>
    {!! $errors->first('details', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group  text-end mt-2 col-md-12">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
</div>



<script language="javascript">
    $(document).ready(function() {

        $('.seg_code').keyup(function(){
            $(this).val($(this).val().toUpperCase())
        })

   $('#seg_head_id').change(function(){
       minlen = $('#seg_head_id option:selected').data('min');
       maxlen = $('#seg_head_id option:selected').data('max');


       $('#seg_code').attr('min', minlen)
       $('#seg_code').attr('max', maxlen)
       $('#seg_code').attr('maxlength', maxlen)
       $('#seg_code').attr('minlength', maxlen)
   })
        $('#seg_head_id').trigger('change')
    });
</script>
