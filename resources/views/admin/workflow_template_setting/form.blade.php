<div class="row">
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}} col-md-6">
    <label for="title" class="control-label">{{ 'Title' }}*</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($workflow_template_setting->title) ? $workflow_template_setting->title : ''}}" required >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('ext_ref') ? 'has-error' : ''}}  col-md-6">
    <label for="ext_ref" class="control-label">{{ 'Ext Ref' }}</label>
    <input class="form-control" name="ext_ref" type="text" id="ext_ref" value="{{ isset($workflow_template_setting->ext_ref) ? $workflow_template_setting->ext_ref : ''}}" >
    {!! $errors->first('ext_ref', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('company_id') ? 'has-error' : ''}} col-md-6">
    <label for="company_id" class="control-label">{{ 'Company/Client' }}*</label>
    <select class="form-control" name="company_id" id="company_id" required  {{ isset($workflow_template_setting->company_id)? 'disabled':'' }}>
        <option value="">--Select One-- </option>
        @foreach($companies as $key=>$company)
        <option value="{{ $company->id }}"  {{ isset($workflow_template_setting->company_id)&& ($workflow_template_setting->company_id == $company->id) ?  'selected="selected"' : '' }} > {{ $company->company_name }}</option>
        @endforeach
    </select>
    {!! $errors->first('company_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('workflow_id') ? 'has-error' : ''}}  col-md-6">
    <label for="workflow_id" class="control-label">{{ 'Workflow Roles' }}*</label>
    <select class="form-control" name="workflow_id" id="workflow_id" required  {{ isset($workflow_template_setting->workflow_template_value->setting_value)? 'disabled':'' }}>
        <option value="">--Select One-- </option>
        @foreach($workflow_setting as $key=>$value)
            <option value="{{ $value->id }}"  {{ isset($workflow_template_setting->workflow_id) && ($value->id == $workflow_template_setting->workflow_id)? 'selected="selected"' : '' }}  >{{ $value->ext_ref }} {{ $value->title }}</option>
        @endforeach
    </select>
    {!! $errors->first('workflow_id', '<p class="help-block">:message</p>') !!}
</div>


    <table class="table table-striped table-bordered small">
        <thead>
        <tr>  <th style="width:60%"><strong>Role Setup</strong></th>
            <th>User</th>
        </tr>
        </thead>
        <tbody id="text" >


        @if(isset($workflow_template_setting->workflow_template_value))
            @php
                $field = 0;
            @endphp

            @foreach($workflow_template_setting->workflow_template_value as $key=>$value)

                <tr>

                    <td>
                        {{ $value->setting_value->role_name  ?? '' }}
                    </td>
                    <input type="hidden" name="user[{{$key}}][id]"  value="{{  $value->id ?? '' }}">
                    <input type="hidden" name="user[{{$key}}][role_id]"  value="{{  $value->workflow_role ?? '' }}">

                    <td> <select  name="user[{{$key}}][user_id]" class="form-control roleitem">
                            <option value="">Select One</option>
                        @foreach($treeuser as $k=>$user)
                            <option value="{{$user['id'] }}"  {{ (isset($value->value) && $value->value == $user['id'] )? 'selected="selected"':'' }} > {{$user['name'] }}  ({{$user['role'] }} )</option>
                        @endforeach
                        </select></td>
                </tr>
                @php
                    $field++ ;
                @endphp
            @endforeach
        @endif

        </tbody>
        <tfoot>

        </tfoot>
    </table>


</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="Save">
</div>



<script language="javascript">
    $(document).ready(function() {
        fields = $('.roleitem').length;

        var js_data = '<?php echo  json_encode($treeuser); ?>';
        var roles = JSON.parse(js_data );
        selectItem ='';

        $.each(roles, function (key, obj) {
            selectItem +='<option value="' + obj.id + '"   >' + obj.name  +'</option>' ;
        });


        $('#workflow_id').change(function(){
            id = $(this).val();

            $.ajax({
                url: "{{URL::to('/load_workflow_setting')}}",
                dataType: "JSON",
                type: 'POST',
                data: {'_token': $('meta[name=csrf-token]').attr('content'), 'id': id},
                success: function (responce) {
                     //alert(responce.getoptions)

                    $('#text').html('');
                    $.each(responce.getoptions, function (key, obj) {
                        selectRole = '<select name="user['+ fields + '][user_id]" class="form-control roleitem"> <option value="">--select One -- </option>' + selectItem + '</select>';
                        html = '<tr><td>' + obj.role_name + '<input type="hidden"  name="user['+fields+'][id]"  value="" class="form-control" /><input type="hidden"  name="user['+fields+'][role_id]"  value="' + obj.id + '" class="form-control" /></td> <td> '+ selectRole + '  </td></tr>';

                        $('#text').append(html);
                        fields++;
                    })
                }
            })
        })

    });
</script>
