<div class="row">
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}} col-md-4">
    <label for="title" class="control-label">{{ 'Title' }}*</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($workflow_setting->title) ? $workflow_setting->title : ''}}" required >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('ext_ref') ? 'has-error' : ''}}  col-md-4">
    <label for="ext_ref" class="control-label">{{ 'Ext Ref' }}</label>
    <input class="form-control" name="ext_ref" type="text" id="ext_ref" value="{{ isset($workflow_setting->ext_ref) ? $workflow_setting->ext_ref : '' }}" >
    {!! $errors->first('ext_ref', '<p class="help-block">:message</p>') !!}
</div>

    <div class="form-group {{ $errors->has('workflow_type_id') ? 'has-error' : ''}}  col-md-4">
        <label for="workflow_type_id" class="control-label">{{ 'Type' }}</label>
        <select name="workflow_type_id" class="form-control"  id="workflow_type_id" >
          <option value="">--Select One--</option>
            @foreach($workflowTypes as $key=>$item)
                <option value="{{$item->id}}" {{ (isset($workflow_setting) && $item->id == $workflow_setting->workflow_type_id)?'selected':''}}>{{$item->title}}</option>
            @endforeach
        </select>

        {!! $errors->first('workflow_type_id', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<table class="table table-striped table-bordered small">
    <thead>
    <tr>  <th style="width:60%"><strong>Role Setup</strong></th>

        <th>Actions</th>
    </tr>
    </thead>
    <tbody id="text" >

    @if(isset($workflow_setting->getoptions))
        @php
         $field = 0;
        @endphp

        @foreach($workflow_setting->getoptions as $key=>$value)

          <tr>

            <td>
                <select class="form-control roleitem" name="role[{{$field}}][role_id]" required="required">

                    <option value="">Select Role</option>

                    @foreach($roles as $role)

                        <option @if(isset($value->role_id)) {{  ($role->id == $value->role_id) ? 'selected' : '' }}  @endif data-rolename="{{ ucfirst($role->name) }}" value="{{$role->id}}">{{ ucfirst($role->name) }}</option>

                    @endforeach

                </select>
                <input type="hidden" name="role[{{$field}}][name]" class="rolename" value="{{ $value->role_name  ?? '' }}">
                <input type="hidden" name="role[{{$field}}][id]"  value="{{  $value->id ?? '' }}">
            </td>


            <td><button  type="button" class="btn btn-danger btn-flat ng-scope deletebtn  btn-sm"   data-id="{{$value->id}}" ><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="Remove" ></i></button>  </td>
        </tr>
          @php
              $field++ ;
        @endphp
       @endforeach
    @endif

    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td class="text-left"><button type="button" onClick="addInput(),addErase()" id="AddItem" data-toggle="tooltip" title="Add Item Option" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
    </tr>
    </tfoot>
</table>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="Save">
</div>


<script language="javascript">
    $(document).ready(function() {

        var js_data = '<?php echo  json_encode($roles); ?>';
        var roles = JSON.parse(js_data );
        selectItem ='';
        $.each(roles, function (key, obj) {
            selectItem +='<option value="' + obj.id + '" data-rolename="' + obj.name  +'" >' + obj.name  +'</option>' ;
        });



        fields = $('.roleitem').length;
        /////////////////////////////////////////
        $(document).on('change', '.roleitem', function () {
            rolename = $(this).find(':selected').data('rolename');
             $(this).next('.rolename').val(rolename)
        })

        $('.deletebtn').click(function(){
            if(!confirm('Confirm delete?')){
                return false
            }
            id =  $(this).data('id');

            $.ajax({
                url: "{{URL::to('/del_workflow_settings')}}",
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'id': id},
                success: function (responce) {
                    $('#loadcandidate').html(responce)
                }
            })
            this.parentNode.parentNode.remove(this.parentNode);
        })

        $('#AddItem').click(function(){
            selectRole = '<select name="role['+ fields + '][role_id]" class="form-control roleitem"> <option value="">--select One -- </option>' + selectItem + '</select>';

            html= "";

            if (fields != 10) {
                // html+=se;
                html='<tr><td> '+ selectRole + ' <input type="hidden" name="role['+fields+'][name]" class="rolename"><input type="hidden"  name="role['+fields+'][id]"  value="" class="form-control" /><td><button  type="button" class="btn btn-danger btn-flat btn-sm ng-scope deletebtn" onclick="this.parentNode.parentNode.remove(this.parentNode);" ><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="Remove" ></i></button></td></tr>';
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
