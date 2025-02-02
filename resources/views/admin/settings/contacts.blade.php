
<h3>Contacts</h3>

<form method="POST" action="{{ route('save_setting') }}" id="form_settings_contact" class="mt-6 space-y-6"
      accept-charset="UTF-8" enctype="multipart/form-data">
    @csrf()
<div class="row">
    <div class=" {{ $errors->has('address') ? 'has-error' : ''}} mb-3 col-md-6">
        <label for="site_title" class="control-label">{{ 'Address' }}</label>
        <input type="text" class="form-control" name="settings[address]" value="{{ $settings->address ?? ''}}"  >
        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('phone') ? 'has-error' : ''}} mb-3 col-md-6">
        <label for="logo" class="control-label">{{ 'Phone' }}</label>
        <input type="text" class="form-control" name="settings[phone]" value="{{ $settings->phone ?? ''}}"  >
        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('fax') ? 'has-error' : ''}} mb-3 col-md-6">
        <label for="fax" class="control-label">{{ 'Fax' }}</label>
        <input type="text" class="form-control" name="settings[fax]" value="{{$settings->fax ?? ''}}"  >
        {!! $errors->first('fax', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('mobile') ? 'has-error' : ''}} mb-3 col-md-6">
        <label for="mobile" class="control-label">{{ 'Mobile' }}</label>
        <input type="text" class="form-control" name="settings[mobile]" value="{{ $settings->mobile ?? ''}}"  >
        {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('timezone') ? 'has-error' : ''}} mb-3 col-md-6">
        <label for="timezone" class="control-label">{{ 'Timezone' }}</label>
        <input type="text" class="form-control" name="settings[timezone]" value="{{ $settings->timezone ?? ''}}"  >
        {!! $errors->first('timezone', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('email') ? 'has-error' : ''}} mb-3 col-md-6">
        <label for="email" class="control-label">{{ 'Email' }}</label>
        <input type="text" class="form-control" name="settings[email]" value="{{ $settings->email ?? ''}}"  >
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>


    <div class="mb-3 text-end">
        <button class="btn btn-primary" type="submit">Save</button>
    </div>
</div>

</form>




<script>

    $(function () {
        var form_contact = $('#form_settings_contact');

        form_contact.submit(function (event) {
            event.preventDefault();

            var form_status = $('<div class="form_status"></div>');
            //  $('#subnitBtn').prop('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: form_contact.serialize(),
                success: function (response) {

                }
            }).done(function (data) {
                if (data.status == 'success'){
                    Swal.fire({
                        position: "top-center",
                        icon: "success",
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }else{
                    Swal.fire({
                        position: "top-center",
                        icon: "error",
                        title:  data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }


                //window.location.href = window.location
            }).fail(function () {
                alert("Error: Invalid Data");
            });
        });

        //////////////////////////////////////////////////////////


    });
</script>

