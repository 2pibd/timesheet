<h3>Site Settings</h3>

<form method="POST" action="{{ route('save_setting') }}" class="mt-6 space-y-6" id="form-settings-general"
      accept-charset="UTF-8" enctype="multipart/form-data">
    @csrf()

    <div class=" {{ $errors->has('site_title') ? 'has-error' : ''}} mb-3">
        <label for="site_title" class="control-label">{{ 'Website Title' }}</label>
        <input type="text" class="form-control" name="settings[site_title]" value="{{ $settings->site_title ?? ''}}"
               required>
        {!! $errors->first('site_title', '<p class="help-block">:message</p>') !!}
    </div>

<div class="row">

    <div class=" {{ $errors->has('logo') ? 'has-error' : ''}} mb-3 col-md-6">
        <label for="logo" class="control-label">{{ 'Site Logo' }}</label>
        <div class="card-body">
                <input type="file" class="filepond" id="filepond-logo" name="logo"
                       accept="image/png, image/jpeg, image/gif">
        </div>

        {!! $errors->first('logo', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('favicon') ? 'has-error' : ''}} mb-3  col-md-6">
        <label for="favicon" class="control-label">{{ 'Favicon' }}</label>
        <div class="avatar-xl mx-auto">
        <input type="file" class="filepond filepond-input-circle" id="filepond-favicon" name="favicon"
               accept="image/png, image/jpeg, image/gif"/>
        </div>
        {!! $errors->first('favicon', '<p class="help-block">:message</p>') !!}
    </div>
</div>


    <div class=" {{ $errors->has('default_language') ? 'has-error' : ''}} mb-3">
        <label for="default_language" class="control-label">{{ 'Default Language' }}</label>
        <select class="form-select" name="settings[default_language]">
            <option value="">--Select--</option>
            @foreach($languages as $val)
                <option @if(isset($settings->default_language) && $settings->default_language==$val->code) selected
                        @endif value="{{$val->code}}">{{$val->lang}}</option>
            @endforeach
        </select>

        {!! $errors->first('default_language', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('timezone') ? 'has-error' : ''}} mb-3">
        <label for="timezone" class="control-label">{{ 'Timezone' }}</label>
        <select class="form-select  timezone" name="settings[timezone]">
            <option value="">--Select--</option>
            @foreach($timezones as $val)
                <option @if(isset($settings->timezone) && $settings->timezone==$val->tz_name) selected
                        @endif value="{{$val->tz_name}}">{{$val->tz_name}} {{$val->utc_offset}}</option>
            @endforeach
        </select>


        {!! $errors->first('timezone', '<p class="help-block">:message</p>') !!}
    </div>
    <!--select2 cdn-->


    <div class=" {{ $errors->has('date_format') ? 'has-error' : ''}} mb-3">
        <label for="date_format" class="control-label">{{ 'Date format' }}</label>
        <select name="settings[date_format]" class="form-control select2 " >
            <option value="Y-m-d" {{ ($settings->date_format =="Y-m-d")?"selected":"" }}>Y-m-d</option>
            <option value="d-m-Y" {{ ($settings->date_format =="d-m-Y")?"selected":"" }}>d-m-Y</option>
            <option value="m-d-Y" {{ ($settings->date_format =="m-d-Y")?"selected":"" }}>m-d-Y</option>
            <option value="d/m/Y" {{ ($settings->date_format =="d/m/Y")?"selected":"" }}>d/m/Y</option>
            <option value="m/d/Y" {{ ($settings->date_format =="m/d/Y")?"selected":"" }}>m/d/Y</option>
            <option value="d.m.Y" {{ ($settings->date_format =="d.m.Y")?"selected":"" }}>d.m.Y</option>
            <option value="m.d.Y" {{ ($settings->date_format =="m.d.Y")?"selected":"" }}>m.d.Y</option>

        </select>
        {!! $errors->first('date_format', '<p class="help-block">:message</p>') !!}
    </div>


    <div class=" {{ $errors->has('first_day_of_week') ? 'has-error' : ''}} mb-3">
        <label for="first_day_of_week" class="control-label">{{ 'First Day of week' }}</label>
        <select name="settings[first_day_of_week]" class="form-select select2  "  >
            @foreach( __('backend.daysName') as $key=>$dayName)
                <option value="{{ $key }}" {{ ( $settings->first_day_of_week==$key)?"selected":"" }}>{{ $dayName }}</option>
            @endforeach

        </select>

{{--        <input type="text" class="form-control" name="settings[first_day_of_week]"
               value="{{ $settings->first_day_of_week ?? ''}}">--}}
        {!! $errors->first('first_day_of_week', '<p class="help-block">:message</p>') !!}
    </div>


    <div class="mb-3 text-end">
        <input class="btn btn-primary" type="submit" value="Save">
    </div>


</form>

<!-- dropzone css -->
<link rel="stylesheet" href="{{asset('assets/libs/dropzone/dropzone.css')}}" type="text/css"/>
<!-- Filepond css -->
<link rel="stylesheet" href="{{asset('assets/libs/filepond/filepond.min.css')}}" type="text/css"/>
<link rel="stylesheet"  href="{{asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">

<!-- filepond js -->
<script src="{{asset('assets/libs/filepond/filepond.min.js')}}"></script>
<script src="{{asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js')}}"></script>




<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<link href="{{asset('plugins/select2/select2.min.css')}}?t=234" rel="stylesheet"/>
<script src="{{asset('assets/js/pages/select2.init.js')}}"></script>
<script>

    $(function () {
        $('.timezone').select2()
        // Register FilePond plugins
        FilePond.registerPlugin(FilePondPluginImagePreview);

        FilePond.setOptions({
            debug: true,
        });
        // Logo
        const logoInput = document.querySelector('#filepond-logo');
        const logoPond = FilePond.create(logoInput, {
            server: {
                process: '/admin/upload-logo',
                revert: '/admin/revert-logo',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            },
            allowImageResize: true,
            imageResizeTargetWidth: 300,
            imageResizeTargetHeight: 300,
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
            maxFileSize: '2MB',
        });

        const logoImageUrl = '{{ !empty($settings->logo) ? $settings->logo: '' }}';

        if (logoImageUrl) {
            fetch(logoImageUrl)
                .then(response => response.blob())
                .then(blob => {
                    const file = new File([blob], "logo.jpg", { type: blob.type });
                    logoPond.files = [{
                        source: file,
                        options: {
                            type: 'local',
                        },
                    }];
                })
                .catch(error => {
                    console.error("Error loading image for preview:", error);
                });
        }

        // Favicon
        const faviconInput = document.querySelector('#filepond-favicon');
        const faviconPond = FilePond.create(faviconInput, {
            server: {
                process: '/admin/upload-favicon',
                revert: '/admin/revert-favicon',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            },
            allowImageResize: true,
            imageResizeTargetWidth: 64,
            imageResizeTargetHeight: 64,
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
            maxFileSize: '1MB',
        });

        const faviconImageUrl = '{{ !empty($settings->favicon) ? $settings->favicon: '' }}';
        if (faviconImageUrl) {
            fetch(faviconImageUrl)
                .then(response => response.blob())
                .then(blob => {
                    const file = new File([blob], "{{$settings->favicon ?? 'logo.jpg'}}", { type: blob.type });

                    faviconPond.files = [{
                        source: file,
                        options: {
                            type: 'local',
                        },
                    }];
                })
                .catch(error => {
                    console.error("Error loading image for preview:", error);
                });
        }



 /////////////////////////////////////////////////////////////

        var form2 = $('#form-settings-general');
        form2.submit(function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            var form_status = $('<div class="form_status"></div>');
          //  $('#subnitBtn').prop('disabled', true);

            const logoFile = logoPond.getFile(); // Get the logo file from FilePond
            const faviconFile = faviconPond.getFile(); // Get the favicon file from FilePond

            //alert(faviconFile.file.name)
            //  CKupdate();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false, // Important: don't set content type
                processData: false, // Important: don't process data as a string
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                }
            }).done(function (data) {

                Swal.fire({
                    position: "top-center",
                    icon: "success",
                    title:  data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#subnitBtn').prop('disabled', false);

                //window.location.href = window.location
            }).fail(function () {
                alert("Error: Invalid Data");
            });
        });
    });
</script>
