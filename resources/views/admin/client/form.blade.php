<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="true">
            Client Profile
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="logo-tab" data-bs-toggle="tab" data-bs-target="#logo" type="button" role="tab"
                aria-controls="details" aria-selected="false" disabled>
            Logo
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button"
                role="tab" aria-controls="review" aria-selected="false" disabled>
            Address
        </button>
    </li>


    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button"
                role="tab" aria-controls="review" aria-selected="false" disabled>
            Contact Person
        </button>
    </li>



    <li class="nav-item" role="presentation">
        <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
                role="tab" aria-controls="review" aria-selected="false" disabled>
            Login Access
        </button>
    </li>


</ul>

<div class="tab-content mt-3" id="myTabContent">
    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">

        <form method="POST"
              @if(isset($client)) action="{{ route('client.update', $client->id) }}" @endif
              @if(!isset($client)) action="{{ route('client.store') }}" @endif
             class="mt-6 space-y-6" accept-charset="UTF-8" enctype="multipart/form-data">
            @if(isset($client))  {{ method_field('PATCH') }}  @endif

            @csrf()


            <div class="row">
            <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}} mb-2 col-md-8">
                <label for="company_name" class="control-label">{{ 'Client/Company*' }}</label>
                <input class="form-control" name="company_name" type="text" id="company_name"
                       value="{{ isset($client->company_name) ? $client->company_name : ''}}" required>
                {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('client_group_id') ? 'has-error' : ''}} mb-2 col-md-4">
                <label for="client_group_id" class="control-label">{{ 'Client Group ID' }}</label>
                <input class="form-control" name="client_group_id" type="text" id="client_group_id"
                       value="{{ isset($client->client_group_id) ? $client->client_group_id : ''}}"  >
                {!! $errors->first('client_group_id', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group  mb-2  col-md-4">
                <label for="client_type_id" class="block font-medium text-sm text-gray-700">{{ 'Client Type*' }}</label>
                <select class="form-select" id="client_type_id" name="client_type_id">
                    <option value="">--Select One--</option>
                    @foreach($client_types as $key=>$item)
                        <option
                            value="{{$item->id}}" {{(isset($client->client_type_id) && ($client->client_type_id == $item->id) )? 'selected': ''}} >{{$item->title}}</option>
                    @endforeach
                </select>
                {!! $errors->first('client_type_id', '<p>:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('external_ref') ? 'has-error' : ''}}   mb-2  col-md-4 ">
                <label for="external_ref" class="control-label">{{ 'Reference' }}</label>
                <input class="form-control" name="external_ref" type="text" id="external_ref"
                       value="{{ isset($client->external_ref) ? $client->external_ref : '1'}}">
                {!! $errors->first('external_ref', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('company_email') ? 'has-error' : ''}}    mb-2  col-md-4">
                <label for="company_email" class="control-label">{{ 'Company Email' }}</label>
                <input class="form-control" name="company_email" type="text" id="company_email"
                       value="{{ isset($client->company_email) ? $client->company_email : ''}}">
                {!! $errors->first('company_email', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('company_phone') ? 'has-error' : ''}}   mb-2  col-md-4">
                <label for="company_phone" class="control-label">{{ 'Company Phone' }}</label>
                <input class="form-control" name="company_phone" type="text" id="company_phone"
                       value="{{ isset($client->company_phone) ? $client->company_phone : ''}}" required>
                {!! $errors->first('company_phone', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('industry_type') ? 'has-error' : ''}}  mb-2  col-md-4">
                <label for="industry_type" class="control-label">{{ 'Industry Type' }}</label>
                <select class="form-select" id="industry_type" name="industry_type">
                    <option value="">--Select One--</option>
                    @foreach($industries as $key=>$item)
                        <option
                            value="{{$item->id}}" {{(isset($client->industry_type) && ($client->industry_type == $item->id) )? 'selected': ''}} >{{$item->industry}}</option>
                    @endforeach
                </select>
                {!! $errors->first('industry_type', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('company_id') ? 'has-error' : ''}}   mb-2  col-md-4">
                <label for="company_id" class="control-label">{{ 'Company ID/Reg. No.' }}</label>
                <input class="form-control" name="company_id" type="text" id="company_id"
                       value="{{ isset($client->company_id) ? $client->company_id : ''}}">
                {!! $errors->first('company_id', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('vat_reg') ? 'has-error' : ''}}   mb-2  col-md-4">
                <label for="vat_reg" class="control-label">{{ 'VAT Reg ID' }}</label>
                <input class="form-control" name="vat_reg" type="text" id="vat_reg"
                       value="{{ isset($client->vat_reg) ? $client->vat_reg : ''}}">
                {!! $errors->first('vat_reg', '<p class="help-block">:message</p>') !!}
            </div>


            <div class="form-group {{ $errors->has('website') ? 'has-error' : ''}}   mb-2  col-md-4">
                <label for="website" class="control-label">{{ 'Website' }}</label>
                <input class="form-control" name="website" type="text" id="website"
                       value="{{ isset($client->website) ? $client->website : ''}}">
                {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('code_length') ? 'has-error' : ''}}   mb-2  col-md-4">
                <label for="code_length" class="control-label">{{ 'Company Code Length' }}</label>
                <input class="form-control" name="code_length" type="number" id="code_length"
                       value="{{ isset($client->code_length) ? $client->code_length : ''}}">
                {!! $errors->first('code_length', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('default_currency') ? 'has-error' : ''}}   mb-2  col-md-4">
                <label for="default_currency" class="control-label">{{ 'Default currency' }}</label>
                <select class="form-select" id="default_currency" name="default_currency">
                    <option value="">--Select One--</option>
                    @foreach($currencies as $key=>$item)
                        <option
                            value="{{$item->id}}" {{(isset($client->default_currency) && ($client->default_currency == $item->id) )? 'selected': ''}} >{{$item->title}}</option>
                    @endforeach
                </select>

                {!! $errors->first('default_currency', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('default_lang') ? 'has-error' : ''}}    mb-2  col-md-4">
                <label for="default_lang" class="control-label">{{ 'Default Language' }}</label>
                <select class="form-select" id="default_lang" name="default_lang">
                    <option value="">--Select One--</option>
                    @foreach($languages as $key=>$item)
                        <option
                            value="{{$item->id}}" {{(isset($client->default_lang) && ($client->default_lang == $item->id) )? 'selected': ''}} >{{$item->lang}}</option>
                    @endforeach
                </select>
                {!! $errors->first('default_lang', '<p class="help-block">:message</p>') !!}
            </div>


        </div>
        <div class="form-group {{ $errors->has('company_profile') ? 'has-error' : ''}}   mb-2  ">
            <label for="message" class="control-label">{{ 'Company Profile' }}</label>
            <textarea class="form-control editor" name="company_profile"
                      id="company_profile">{!! $client->company_profile ?? '' !!}</textarea>
            {!! $errors->first('company_profile', '<p class="help-block">:message</p>') !!}
        </div>



        <div class="form-group text-right float-end">
            <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
        </div>
        </form>
    </div>


@if(isset($client))
    <div class="tab-pane fade" id="logo" role="tabpanel" aria-labelledby="logo-tab">
        @include('admin/client.logo')
    </div>

    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
        @include('admin/client.company_address')
    </div>
    <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
        @include('admin/client.company_contact_info')
    </div>
    <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
        @include('admin/client.login_access')
    </div>
    @endif

</div>


<script src="{{asset('/plugins/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
    function CKupdate() {
        for (instance in CKEDITOR.instances)
            CKEDITOR.instances[instance].updateElement();
    }

    $(document).ready(function () {


        var editor = CKEDITOR.replace('company_profile', {
            filebrowserBrowseUrl: '{{ url("ckeditor/browsefile") }}?dir={{'userprofile/'. Auth::id()}}/&title=Browse File',
            filebrowserUploadUrl: '{{ url("ckeditor/upload")}}?dir={{'userprofile/'. Auth::id()}}/&title=Browse File'
        }, {
            height: ['200px'], toolbar: [
                ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', ''], ['Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor', 'Image', 'Source'], ['colors', 'tools'], ['Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Link', 'Unlink', 'Anchor'], ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
                ['list', 'indent', 'blocks', 'align', 'bidi'], ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']
            ]
        });


        const primaryProfileForm = $('#primaryProfileForm');
        const logoTab = $('#logo-tab');
        const addressTab = $('#address-tab');
        const contactTab = $('#contacts-tab');
        const loginTab = $('#login-tab');
        const additionalTab = $('#additional-tab');

        @if(isset($client))
        logoTab.removeAttr('disabled');
        contactTab.removeAttr('disabled');
        addressTab.removeAttr('disabled');
        loginTab.removeAttr('disabled');
        additionalTab.removeAttr('disabled');
        @endif


    });
</script>


