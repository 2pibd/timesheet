<div class="col-md-3">

<div class="form-group {{ $errors->has('structure_code') ? 'has-error' : ''}} "   >
    <label for="structure_code" class="control-label">{{ 'Segment Combination code' }}</label>
    <select class="form-control selectpicker "   data-live-search="true" data-all="false" name="seg_combination_setup_id" id="seg_combination_setup_id" required       >
        <option value="">--Select One--</option>
        @foreach($segment_combo as $key=>$value)
            <option value="{{$value->id}}"
                    @if(isset($info->structure_code) && $info->structure_code == $value->id || old('structure_code') == $value ) selected="selected" @endif>{{$value->seg_comb_code}} :  {{$value->structure_code}} </option>
        @endforeach
    </select>

    {!! $errors->first('structure_code', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('Client') ? 'has-error' : ''}} "   >
    <label for="structure_code" class="control-label">{{ 'Client Ref' }}</label>
    <select class="form-control  selectpicker " multiple data-live-search="true" data-all="false" name="client_id[]" id="client_id" required       >
        <option value="">--Select All--</option>

    </select>

    {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
</div>

<div id="segmentPanel">

</div>
</div>



<div class="col-md-9">
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>


    <table class="table table-striped table-bordered small">
        <thead>
        <tr>
            <th>Default Selected</th>
            <th style="width:60%"><strong>Allocate User(s)</strong></th>

            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="text" >

        @if(isset($info->allocated_users))
            <?php
            foreach($info->allocated_users as $key=>$value){
            ?>
            <input type='hidden'  name="allocated_user[{{$key}}][id]"  value="<?=$value->id?>" class="form-control" />


            <tr>
                <td><input type="radio" name="default_allocated_user" value="{{ $value->user_id  }}"  @if( $value->user_id == $info->default_allocated_user)  checked  @endif ></td>
                <td>
                    <select  name="allocated_user[{{$key}}][user_id]"  class="form-control allocated_user" required>

                        @foreach($treeuser as $k=>$item)
                            <option value="{{ $item['id']}}"    @if( $value->user_id == $item['id']) selected="selected" @endif > {{  $item['name']   }}  ({{ $item['role'] }} )</option>
                        @endforeach
                    </select>

                </td>

                <td>
                    <input  type="text" name="allocated_user[{{$key}}][start_date]" id="start_date" data-provide="datepicker"
                            data-date-format="dd/mm/yyyy" class="form-control" value="{{  date('d/m/Y', strtotime($value->start_date)) ?? ''}}"
                            value="" required>
                </td>
                <td>
                    <input  type="text" name="allocated_user[{{$key}}][end_date]" id="end_date" data-provide="datepicker"
                            data-date-format="dd/mm/yyyy" class="form-control" value="{{  date('d/m/Y', strtotime($value->end_date)) ?? ''}}"   required>
                </td>
                </td>

                <td><button  type="button" class="btn btn-danger btn-flat ng-scope deletebtn  btn-sm"   data-id="{{$value->id}}"><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="Remove" ></i></button>  </td>
            </tr>
            <?php } ?>

        @endif
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4"></td>
            <td class="text-left"><button type="button" onClick="addInput(),addErase()" id="addHead" data-toggle="tooltip" title="Add Item Option" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
        </tr>
        </tfoot>
    </table>
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
</div>

<script language="javascript">
    $(document).ready(function() {
        // $('#seg_combination_setup_id option[value=2]').hide();

         /////////////load CLient/////////
        $(document).on('change', '#seg_combination_setup_id', function () {
            defaultuid =    $(this).val();
            $(this).parents('tr').find('input[name="default_allocated_user"]').val(defaultuid);
            $.fn.loadCombinationSegmentData();
        });

        $.fn.loadCombinationSegmentData = function () {

            setup_id =  $('#seg_combination_setup_id option:selected').val();
            $('#client_id').selectpicker('destroy');

            $('#client_id, .seg').empty();      $('#client_id').selectpicker();
            $('#segmentPanel').html('')
            $.ajax({
                url: "{{URL::to('/loadCombinationSegmentData')}}",
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'setup_id': setup_id},
                success: function (responce) {
                   // alert(responce)
                    // $('#consultantInfo').html(responce)
                    $('#client_id').selectpicker('destroy');
                    $('.seg').selectpicker('destroy');


                        $.each(responce.clientObj, function (key, obj) {

                            html = '<option value="' + obj.clients.id  + '" >' + obj.clients.company_name + '</option> ';

                            $('#client_id').append(html);
                        })
                      //  $('#CombinationContent').append(html);
                       $('#client_id').selectpicker();
                        ///////////////////////////////////////////////////////////////////

                        segmentHtml = '';
                        $.each(responce.headObj, function (key, obj) {

                            segmentHtml += '<div class="form-group"> <label for="structure_code" class="control-label">'+ obj.seg_head.seg_name +'</label>'
                            segmentHtml += '<select class="form-control  selectpicker seg" multiple  data-live-search="true" data-all="false" name="segment_val[]" id="client_id" required >'
                            segmentHtml +=' <option value="">--Select All--</option>'
                                $.each(obj.com_head_value, function (k, item) {
                                  // alert( item.com_head_seg_detail.details)
                                   segmentHtml += '<option value="' + item.com_head_seg_detail.id  + '" >' + item.com_head_seg_detail.details + '</option> ';

                                })
                            segmentHtml +='</select></div>';


                        } )


                        $('#segmentPanel').html(segmentHtml);
                        $('.selectpicker').selectpicker();
                        /////////////////////////////////////////////


                }
            })
        }

        $.fn.loadCombinationSegmentData()
        //////////////////////////////////////
        $("select").change(function(){
            $(this).find("option:selected").each(function(){
                var optionValue = $(this).attr("value");
                if(optionValue){
                    $(".box").not("." + optionValue).hide();
                    $("." + optionValue).show();
                } else{
                    $(".box").hide();
                }
            });
        }).change();
    });

</script>



<script src="{{asset('js')}}/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="{{asset('css')}}/bootstrap-datepicker.min.css"/>

<link rel="stylesheet" href="{{asset('plugins')}}/select2/bootstrap-select.min.css" type="text/css" />
<script src="{{asset('plugins')}}/select2/bootstrap-select.min.js"></script>
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
<script language="javascript">
    $(document).ready(function() {

        $('.code').keyup(function(){
            $(this).val($(this).val().toUpperCase())
        })


        $('.deletebtn').click(function(){
            if(!confirm('Confirm delete?')){
                return false
            }
            id =  $(this).data('id');

            $.ajax({
                url: "{{URL::to('/del_com_head')}}",
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'id': id},
                success: function (responce) {
                    $('#loadcandidate').html(responce)

                }
            })
            this.parentNode.parentNode.remove(this.parentNode);
        })

        fields =0; //Number($('.allocated_user').length);

        var js_data = '<?php echo  json_encode($treeuser); ?>';
        var roles = JSON.parse(js_data );
        selectItem ='';

        $.each(roles, function (key, obj) {
            selectItem +='<option value="' + obj.id + '"   >' + obj.name  +'</option>' ;
        });


        $('#addHead').click(function(){

            html= "";

            if (fields != 10) {
                selectRole = '<select name="allocated_user['+ fields + '][user_id]" class="form-control allocated_user" required> <option value="">--select One -- </option>' + selectItem + '</select>';

                // html+=se;
                html='<tr><td><input type="radio" name="default_allocated_user"  value=""  ></td><td> '+ selectRole + '  </td><td><input type="text"  name="allocated_user['+fields+'][start_date]"  id="start_date" data-provide="datepicker"\n' +
                    '                                data-date-format="dd/mm/yyyy" class="form-control"  required/> <input type="hidden"  name="allocated_user['+fields+'][id]"  value="" class="form-control" /></td><td><input type="text"  name="allocated_user['+fields+'][end_date]"  id="end_date" data-provide="datepicker"\n' +
                    '                                data-date-format="dd/mm/yyyy" class="form-control"  required /> <input type="hidden"  name="allocated_user['+fields+'][id]"  value="" class="form-control" /></td>' +
                    '<td><button  type="button" class="btn btn-danger btn-flat btn-sm ng-scope deletebtn" onclick="this.parentNode.parentNode.remove(this.parentNode);" ><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="Remove" ></i></button></td></tr>';
                fields +=  Number(1) ;

                //$('#openoptions table').addClass('.table');
            }else   {
                html= "<br />Only 10 data entries allowed.";
                $('#addInput').attr('disabled','disabled');
                //document.form.add.disabled=true;
            }

            $('#text').append(html);

        })
///////////////////////////////////////////
        $(document).on('change', ' .allocated_user ', function () {
            defaultuid =    $(this).val();
            $(this).parents('tr').find('input[name="default_allocated_user"]').val(defaultuid);
        });


    });
</script>
