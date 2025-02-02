<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
            Client Profile
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="logo-tab" data-bs-toggle="tab" data-bs-target="#logo" type="button" role="tab" aria-controls="details" aria-selected="false" disabled>
            Logo
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="review" aria-selected="false" disabled>
            Address
        </button>
    </li>


    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab" aria-controls="review" aria-selected="false" disabled>
            Contact Person
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="compliance-tab" data-bs-toggle="tab" data-bs-target="#compliance" type="button" role="tab" aria-controls="review" aria-selected="false" disabled>
            Compliance
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false" disabled>
            Additional Information
        </button>
    </li>




</ul>

<div class="tab-content mt-3" id="myTabContent">
    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">

    <div class="row">
<div class="form-group {{ $errors->has('tplname') ? 'has-error' : ''}} mb-2 col-md-8">
    <label for="tplname" class="control-label">{{ 'Client/Company' }}</label>
    <input class="form-control" name="tplname" type="text" id="tplname" value="{{ isset($client->tplname) ? $client->tplname : ''}}" required>
    {!! $errors->first('tplname', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group  mb-2  col-md-4">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Client Type' }}</label>
    <select class="form-select" id="client_type_id" name="client_type_id" >
        <option value="">--Select All--</option>
        @foreach($client_types as $key=>$item)
            <option value="{{$item->id}}" {{(isset($client->client_type_id) && ($client->client_type_id == $item->id) )? 'selected': ''}} >{{$item->title}}</option>
        @endforeach
    </select>
    {!! $errors->first('status', '<p>:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('language_id') ? 'has-error' : ''}}   mb-2  col-md-4 ">
    <label for="language_id" class="control-label">{{ 'Reference' }}</label>
    <input class="form-control" name="language_id" type="text" id="language_id" value="{{ isset($client->language_id) ? $client->language_id : '1'}}" >
    {!! $errors->first('language_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}    mb-2  col-md-4">
    <label for="subject" class="control-label">{{ 'Company Email' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($client->subject) ? $client->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}   mb-2  col-md-4">
    <label for="subject" class="control-label">{{ 'Company Phone' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($client->subject) ? $client->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}  mb-2  col-md-4">
    <label for="subject" class="control-label">{{ 'Industry Type' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($client->subject) ? $client->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}   mb-2  col-md-4">
    <label for="subject" class="control-label">{{ 'Company Id/Reg. No.' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($client->subject) ? $client->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}   mb-2  col-md-4">
    <label for="subject" class="control-label">{{ 'VAT Reg ID' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($client->subject) ? $client->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}   mb-2  col-md-4">
    <label for="subject" class="control-label">{{ 'Website' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($client->subject) ? $client->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}   mb-2  col-md-4">
    <label for="subject" class="control-label">{{ 'Company Code Length' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($client->subject) ? $client->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}   mb-2  col-md-4">
    <label for="subject" class="control-label">{{ 'Default currency' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($client->subject) ? $client->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}    mb-2  col-md-4">
    <label for="subject" class="control-label">{{ 'Default Language' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($client->subject) ? $client->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}   mb-2  col-md-4">
    <label for="subject" class="control-label">{{ 'Compliance (Default Group)' }}</label>
    <input class="form-control" name="subject" type="text" id="subject" value="{{ isset($client->subject) ? $client->subject : ''}}" required>
    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
</div>


</div>
<div class="form-group {{ $errors->has('company_profile') ? 'has-error' : ''}}   mb-2  ">
    <label for="message" class="control-label">{{ 'Company Profile' }}</label>
    <textarea class="form-control editor"  name="company_profile"   id="company_profile" >{!! $client->company_profile ?? '' !!}</textarea>
    {!! $errors->first('company_profile', '<p class="help-block">:message</p>') !!}
</div>




<div class="form-group text-right float-end">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
    </div>
    <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
        <p>Details tab content goes here.</p>
    </div>
    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
        <p>Review tab content goes here.</p>
    </div>
</div>


<script src="{{asset('/plugins/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }

    $(document).ready(function() {


        var editor = CKEDITOR.replace( 'company_profile',  {
            filebrowserBrowseUrl: '{{ url("ckeditor/browsefile") }}?dir={{'userprofile/'. Auth::id()}}/&title=Browse File',
            filebrowserUploadUrl: '{{ url("ckeditor/upload")}}?dir={{'userprofile/'. Auth::id()}}/&title=Browse File'
        }, {height:['200px'],  toolbar: [
                [ 'Bold', 'Italic','Underline','Strike','Subscript','Superscript', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','' ],[ 'Styles', 'Format', 'Font', 'FontSize','TextColor', 'BGColor','Image' ,'Source'  ],['colors','tools'],  [   'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe','Link', 'Unlink', 'Anchor' ] ,[ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ],
                [ 'list', 'indent', 'blocks', 'align', 'bidi' ],  [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ]
            ]} );



        const primaryProfileForm = $('#primaryProfileForm');
        const logoTab =  $('#logo-tab');
        const addressTab = $('#address-tab');
        const contactTab = $('#contacts-tab');
        const complianceTab = $('#compliance-tab');
        const additionalTab = $('#additional-tab');

   @if(isset($client))
        logoTab.removeAttr('disabled');
        contactTab.removeAttr('disabled');
        addressTab.removeAttr('disabled');
        complianceTab.removeAttr('disabled');
        additionalTab.removeAttr('disabled');
   @endif


    });
</script>


