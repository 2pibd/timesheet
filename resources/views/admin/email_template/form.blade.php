<div class="form-group {{ $errors->has('tplname') ? 'has-error' : ''}} mb-2">
    <label for="tplname" class="control-label">{{ 'Tplname' }}</label>
    <input class="form-control" name="tplname" type="text" id="tplname" value="{{ isset($email_template->tplname) ? $email_template->tplname : ''}}" required>
    {!! $errors->first('tplname', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('language_id') ? 'has-error' : ''}} d-none">
    <label for="language_id" class="control-label">{{ 'Language Id' }}</label>
    <input class="form-control" name="language_id" type="text" id="language_id" value="{{ isset($email_template->language_id) ? $email_template->language_id : '1'}}" >
    {!! $errors->first('language_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}  mb-2">
    <label for="subject" class="control-label">{{ 'Subject' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($email_template->subject) ? $email_template->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group  mb-2">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Template Type' }}</label>
    <select class="form-select" id="template_type_id" name="template_type_id" >
        <option value="">--Select All--</option>
        @foreach($template_types as $key=>$item)
            <option value="{{$item->id}}" {{(isset($email_template->template_type_id) && ($email_template->template_type_id == $item->id) )? 'selected': ''}} >{{$item->type}}</option>
        @endforeach
    </select>
    {!! $errors->first('status', '<p>:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('message') ? 'has-error' : ''}}  mb-2">
    <label for="message" class="control-label">{{ 'Message' }}</label>
    <textarea class="form-control editor"  name="message"   id="message" >{!! $email_template->message ?? '' !!}</textarea>
    {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('message_keyword') ? 'has-error' : ''}}  mb-2">
    <label for="message_keyword" class="control-label">{{ 'Message Params' }}</label>
    <textarea class="form-control" name="param"  id="param">{{ isset($email_template->param) ? $email_template->param : ''}}</textarea>
    {!! $errors->first('message_keyword', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group  mb-2">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Status' }}</label>
    <select class="form-select" id="status" name="status" >
        @foreach($status as $key=>$item)
            <option value="{{$item}}" {{(isset($email_template->status) && ($email_template->status == $item) )? 'selected': ''}} >{{$item}}</option>
        @endforeach
    </select>
    {!! $errors->first('status', '<p>:message</p>') !!}
</div>

{{--<div class="form-group {{ $errors->has('send') ? 'has-error' : ''}}">
    <label for="send" class="control-label">{{ 'Send' }}</label>
    <input class="form-control" name="send" type="text" id="send" value="{{ isset($email_template->send) ? $email_template->send : ''}}" >
    {!! $errors->first('send', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('core') ? 'has-error' : ''}}">
    <label for="core" class="control-label">{{ 'Core' }}</label>
    <input class="form-control" name="core" type="text" id="core" value="{{ isset($email_template->core) ? $email_template->core : ''}}" >
    {!! $errors->first('core', '<p class="help-block">:message</p>') !!}
</div>--}}


<div class="form-group text-right float-end">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

<script src="{{asset('/plugins/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }
    $(document).ready(function() {



        var editor = CKEDITOR.replace( 'message',  {
            filebrowserBrowseUrl: '{{ url("ckeditor/browsefile") }}?dir={{'userprofile/'. Auth::id()}}/&title=Browse File',
            filebrowserUploadUrl: '{{ url("ckeditor/upload")}}?dir={{'userprofile/'. Auth::id()}}/&title=Browse File'
        }, {height:['200px'],  toolbar: [
                [ 'Bold', 'Italic','Underline','Strike','Subscript','Superscript', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','' ],[ 'Styles', 'Format', 'Font', 'FontSize','TextColor', 'BGColor','Image' ,'Source'  ],['colors','tools'],  [   'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe','Link', 'Unlink', 'Anchor' ] ,[ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ],
                [ 'list', 'indent', 'blocks', 'align', 'bidi' ],  [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ]
            ]} );

    });
</script>
