<div class="row">
<div class="form-group {{ $errors->has('strcture_code') ? 'has-error' : ''}} col-md-4">
    <label for="strcture_code" class="control-label">{{ 'Strcture Code' }}</label>
    <input class="form-control strcture_code" name="strcture_code" type="text" id="strcture_code" value="{{ $structure_code ?? ''}}" required >
    {!! $errors->first('strcture_code', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}  col-md-4">
    <label for="status" class="control-label">{{ 'Status' }}</label>

    <select class="form-control" name="status"  id="status">
        @foreach($enumstatus as $key=>$value)
            <option value="{{$value}}" @if(isset($segment_structure_info->status) && $segment_structure_info->status == $value || old('status') == $value ) selected="selected" @endif>{{$value}} </option>
        @endforeach
    </select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>


<div class="col-md-8 mt-3 table-responsive">
<table class="table table-striped table-bordered small">
    <thead>
    <tr>  <th style="width:60%"><strong>Segment Head</strong></th>

        <th>Actions</th>
    </tr>
    </thead>
    <tbody id="text" >

    @if(isset($segment_structure_info))
     @foreach($segment_structure_info as $key=>$value)

        <input type='hidden'  name="head[{{$key}}][id]"  value="<?=$value->id?>" class="form-control" />
        <tr>

            <td>
                <select  name="head[{{$key}}][head_id]"   class="form-control seg_header" required >
                    <option value="">-- Select One--</option>
                    @foreach($segment_heads as $k=>$item)
                    <option value="{{ $item->id }}"  @if(isset($value->seg_head_id) && $value->seg_head_id == $item->id   ) selected="selected" @endif >{{ $item->seg_name }}</option>
                    @endforeach

                </select>
            </td>

            <td><button  type="button" class="btn btn-danger btn-flat ng-scope deletebtn  btn-sm"   data-id="{{$value->id}}"><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="Remove" ></i></button>  </td>
        </tr>
     @endforeach

    @endif
    </tbody>
    <tfoot>
    <tr>
        <td ></td>
        <td class="text-left"><button type="button" onClick="addInput(),addErase()" id="addHead" data-toggle="tooltip" title="Add Item Option" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
    </tr>
    </tfoot>
</table>
</div>
</div>

<div class="form-group text-end">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>


<script language="javascript">
    $(document).ready(function () {

        $('.strcture_code').keyup(function(){
            $(this).val($(this).val().toUpperCase())
        })

        var selethead =  JSON.parse('<?=$segment_heads?>');
        selopt= ' <option value="">-- Select One--</option>';
        $.each(selethead, function (key, obj) {
            selopt +='<option value="'+ obj.id +'"  >'+ obj.seg_name +'</option>';
        })

        fields = $('.seg_header').length;


        $('.deletebtn').click(function(){
            if(!confirm('Confirm delete?')){
                return false
            }
            id =  $(this).data('id');
alert(id)
            $.ajax({
                url: "{{URL::to('/del_seg_head')}}",
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'id': id},
                success: function (responce) {

                    $.snackbar({content: "Copied Successfully", timeout: 10000});
                }
            })
            this.parentNode.parentNode.remove(this.parentNode);
        })



        $('#addHead').click(function(){

            html= "";

            if (fields != 10) {


                // html+=se;
                html='<tr><td> <select  name="head['+fields+'][head_id]"  class="form-control seg_header" required >' + selopt + ' </select></td><td><button  type="button" class="btn btn-danger btn-flat btn-sm ng-scope deletebtn" onclick="this.parentNode.parentNode.remove(this.parentNode);" ><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="Remove" ></i></button></td></tr>';
                fields +=  Number(1) ;

                //$('#openoptions table').addClass('.table');
            }else   {
                html= "<br />Only 10 data entries allowed.";
                $('#addInput').attr('disabled','disabled');
                //document.form.add.disabled=true;
            }

            $('#text').append(html);

        })



    });
</script>
