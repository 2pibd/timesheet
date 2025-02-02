<div class="row">
    <div class="col-md-3 m-0">
<div class="form-group {{ $errors->has('seg_comb_code') ? 'has-error' : ''}} mb-3">
    <label for="seg_comb_code" class="control-label">{{ 'Segment Combination Code' }}</label>
    @if(isset($info->seg_comb_code) )
        <input class="form-control" name="seg_comb_code" type="text" id="seg_comb_code" readonly
               value="{{ isset($info->seg_comb_code) ? $info->seg_comb_code : ''}}"
               required>
    @else
    <input class="form-control" name="seg_comb_code" type="text" id="seg_comb_code"
           value="{{ isset($info->seg_comb_code) ? $info->seg_comb_code : ''}}"
           required>
    @endif
    {!! $errors->first('seg_comb_code', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group  {{ $errors->has('structure_code') ? 'has-error' : ''}}  mb-3 "     @if(!empty($info->structure_code)) readonly="readonly" @endif>
    <label for="structure_code" class="control-label">{{ 'Structure  code' }}</label>
    @if(isset($info->structure_code) )
        <input class="form-control" name="structure_code" type="text" id="structure_code" readonly
               value="{{ isset($info->structure_code) ? $info->structure_code : ''}}"
               required>
     @else
    <select class="selectpicker border border-1 dark:border-gray-600 rounded-3 d-block w-100"  data-live-search="true" data-all="false" name="structure_code" id="structure_code" required>
        <option value="">--Select One--</option>
        @foreach($segment_structure_info as $key=>$value)
            <option value="{{$value->structure_code}}"
                    @if(isset($info->structure_code) && $info->structure_code == $value->structure_code || old('structure_code') == $value ) selected="selected" @endif>{{$value->structure_code}}</option>
        @endforeach
    </select>
     @endif
    {!! $errors->first('structure_code', '<p class="help-block">:message</p>') !!}
</div>

{{--
<div class="form-group {{ $errors->has('client_id') ? 'has-error' : ''}}  ">
    <label for="client_id" class="control-label">{{ 'Client Ref.' }}</label>
    <select class="form-control selectpicker" name="client_id[]"  data-selected-text-format="count>2" multiple id="client_id"  data-live-search="true" data-all="true"  required>

        <option value="All" >All Clients</option>
        @foreach($clients as $key=>$value)
            <option value="{{$value->id}}"
                    @if(isset($selectclient) &&  in_array( $value->id, $selectclient) || old('client_id') == $value ) selected="selected" @endif>{{$value->company_name}}  {{ $value->id}}</option>
        @endforeach
    </select>

    {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
</div>



        <div class="form-group {{ $errors->has('client_id') ? 'has-error' : ''}}  ">
            <label for="client_id" class="control-label">{{ 'Default User Allocate' }}</label>
            <select class="form-control selectpicker" name="default_allocated_user"  data-selected-text-format="count>2"   id="default_allocated_user"  data-live-search="true" data-all="true"  required>

                <option value="" >--Select Default User--</option>
                @foreach($treeuser as $key=>$value)
                    <option value="{{$value['id']}}"
                            @if(isset($info->default_allocated_user) &&    ($value['id'] == $info->default_allocated_user) || old('client_id') == $value['id'] ) selected="selected" @endif>{{$value['name']}}  </option>
                @endforeach
            </select>

            {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
        </div>
--}}


        <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}} mb-3">
            <label for="status" class="control-label">{{ 'Status' }}</label>

            <select class="form-select" name="status" id="status">

                @foreach($enumstatus as $key=>$value)
                    <option value="{{$value}}"
                            @if(isset($info->status) && $info->status == $value || old('status') == $value ) selected="selected" @endif>{{$value}} </option>
                @endforeach
            </select>
            {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
        </div>



</div>

<div class="col-md-8"  >
    <label for="seg_comb_code" class="control-label">Segment combination setup</label>
    <table class="table table-striped table-bordered small">

        <tbody id="segmentArea" >



        @if(isset($segments))
         @foreach($segments->structure as $key=>$value)
        <tr>
            <td width="30%"> {{ $value->segments->seg_name ?? ''  }} </td>
            <td>

                <input type="hidden" name="seg[{{  $key }}][head_id]" value="{{ $value->segments->id ?? ''  }}">
                <select class="form-control selectpicker"    data-selected-text-format="count>2" multiple  data-live-search="true" data-all="true"  name="seg[{{ $key  }}][segment_value_id][]" id="structure_code" required>
                    <option value="All" >All  {{ $value->segments->seg_name ?? ''  }}</option>
                    @foreach($value->segments->segment_details as $index=>$item)
                    <option value="{{ $item->id  }}"  @if( in_array($item->id,$options)) selected="selected" @endif >{{ $item->seg_code  }}:{{ $item->details  }}</option>
                    @endforeach
                </select>

            </td>
        </tr>

        @endforeach
        @endif
        </tbody>
    </table>



</div>

</div>

<div class="row mb-3">
<div class="form-group col-md-12 text-end">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
</div>



<script src="{{asset('js')}}/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="{{asset('css')}}/bootstrap-datepicker.min.css"/>



<script>
    $(function () {
        function toggleSelectAll(control) {
            var allOptionIsSelected = (control.val() || []).indexOf("All") > -1;
            function valuesOf(elements) {
                return $.map(elements, function(element) {
                    return element.value;
                });
            }

            if (control.data('allOptionIsSelected') != allOptionIsSelected) {
                // User clicked 'All' option
                if (allOptionIsSelected) {
                    // Can't use .selectpicker('selectAll') because multiple "change" events will be triggered
                    control.selectpicker('val', valuesOf(control.find('option')));
                } else {
                    control.selectpicker('val', []);
                }
            } else {
                // User clicked other option
                if (allOptionIsSelected && control.val().length != control.find('option').length) {
                    // All options were selected, user deselected one option
                    // => unselect 'All' option
                    control.selectpicker('val', valuesOf(control.find('option:selected[value!=All]')));
                    allOptionIsSelected = false;
                } else if (!allOptionIsSelected && control.val().length == control.find('option').length - 1) {
                    // Not all options were selected, user selected all options except 'All' option
                    // => select 'All' option too
                    control.selectpicker('val', valuesOf(control.find('option')));
                    allOptionIsSelected = true;
                }
            }
            control.data('allOptionIsSelected', allOptionIsSelected);
        }

        $('.selectpicker').selectpicker(); //.change(function(){toggleSelectAll($(this));}).trigger('change');
        $(document).on('change', ' .selectpicker ', function () {
             //toggleSelectAll($(this)) ;
        })
      // $('#structure_code').trigger('change')



       // $('.selectpicker').on('change', function(){
            $(document).on('change', ' .selectpicker ', function () {
            var thisObj = $(this);
            var isAllSelected = thisObj.find('option[value="All"]').prop('selected');
            var lastAllSelected = $(this).data('all');
            var selectedOptions = (thisObj.val())?thisObj.val():[];
            var allOptionsLength = thisObj.find('option[value!="All"]').length;

            console.log(selectedOptions);
            var selectedOptionsLength = selectedOptions.length;

            if(isAllSelected == lastAllSelected){

                if($.inArray("All", selectedOptions) >= 0){
                    selectedOptionsLength -= 1;
                }

                if(allOptionsLength <= selectedOptionsLength){

                    thisObj.find('option[value="All"]').prop('selected', true).parent().selectpicker('refresh');
                    isAllSelected = true;
                }else{
                    thisObj.find('option[value="All"]').prop('selected', false).parent().selectpicker('refresh');
                    isAllSelected = false;
                }

            }else{
                thisObj.find('option').prop('selected', isAllSelected).parent().selectpicker('refresh');
            }

            $(this).data('all', isAllSelected);
        }).trigger('change');
    });

</script>
<script>

    $(document).ready(function () {

        $.fn.loadSegmentData = function () {
            var  structure_code = $('#structure_code option:selected').val() ;

            $('#segmentArea').empty();
            $.ajax({
                url: "{{URL::to('admin/getsegmnets')}}",
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'structure_code': structure_code},
                success: function (responce) {
                    $.each(responce, function (key, obj) {
                        sltid= 'slt'+key;
                        select = '<input type="hidden" name="seg['+ key +'][head_id]" value="'+obj.seg_head_id+'">';
                        select += '<select class="form-control selectpicker" id="'+sltid+'"   data-selected-text-format="count>2" multiple  data-live-search="true" data-all="true"  name="seg['+ key +'][segment_value_id][]" id="structure_code" required> <option value="All" >All  '+ obj.segments.seg_name +'</option> ';
                            $.each(obj.segments.segment_details , function (k , opt) {
                                select += ' <option value="'+opt.id+'">'+ opt.seg_code +':'+  opt.details + '</option>';
                            })
                        select +=  '</select>';

                        html = '<tr><td>' + obj.segments.seg_name + '</td> <td> ' + select + ' </td></tr>';

                        $('#segmentArea').append(html);
                        $('#'+sltid).selectpicker();
                        $('#'+sltid).trigger('change')
                    })
                }
            })
        }


      //  $.fn.loadSegmentData();

        $('#structure_code').change(function(){
            $.fn.loadSegmentData();
        })


    });

</script>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

