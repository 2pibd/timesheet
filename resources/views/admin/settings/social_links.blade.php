<h3>Social Links</h3>
<form method="POST" action="{{ route('save_setting') }}" class="mt-6 space-y-6" id="form-settings-social" accept-charset="UTF-8" enctype="multipart/form-data">
    @csrf()

    <div class=" {{ $errors->has('facebook') ? 'has-error' : ''}} mb-3">
        <label for="facebook" class="control-label">{{ 'Facebook' }}</label>
        <input type="text" class="form-control" name="settings[facebook]" value="{{ $settings->facebook ?? ''}}"  >
        {!! $errors->first('facebook', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="{{ $errors->has('twitter') ? 'has-error' : ''}} mb-3">
        <label for="twitter" class="control-label">{{ 'Twitter' }}</label>
        <input type="text" class="form-control" name="settings[twitter]" value="{{ $settings->twitter ?? ''}}"  >
        {!! $errors->first('twitter', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('linkedin') ? 'has-error' : ''}} mb-3">
        <label for="linkedin" class="control-label">{{ 'Linkedin' }}</label>
        <input type="text" class="form-control" name="settings[linkedin]" value="{{$settings->linkedin ?? ''}}"  >
        {!! $errors->first('linkedin', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('youtube') ? 'has-error' : ''}} mb-3">
        <label for="youtube" class="control-label">{{ 'Youtube' }}</label>
        <input type="text" class="form-control" name="settings[youtube]" value="{{ $settings->youtube ?? ''}}"  >
        {!! $errors->first('youtube', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('instagram') ? 'has-error' : ''}} mb-3">
        <label for="instagram" class="control-label">{{ 'Instagram' }}</label>
        <input type="text" class="form-control" name="settings[instagram]" value="{{ $settings->instagram ?? ''}}"  >
        {!! $errors->first('instagram', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('pinterest') ? 'has-error' : ''}} mb-3">
        <label for="pinterest" class="control-label">{{ 'Pinterest' }}</label>
        <input type="text" class="form-control" name="settings[pinterest]" value="{{ $settings->pinterest ?? ''}}"  >
        {!! $errors->first('pinterest', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('threads') ? 'has-error' : ''}} mb-3">
        <label for="threads" class="control-label">{{ 'Threads' }}</label>
        <input type="text" class="form-control" name="settings[threads]" value="{{ $settings->threads ?? ''}}"  >
        {!! $errors->first('threads', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('snapchat') ? 'has-error' : ''}} mb-3">
        <label for="snapchat" class="control-label">{{ 'Snapchat' }}</label>
        <input type="text" class="form-control" name="settings[snapchat]" value="{{ $settings->snapchat ?? ''}}"  >
        {!! $errors->first('snapchat', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('whatsapp') ? 'has-error' : ''}} mb-3">
        <label for="whatsapp" class="control-label">{{ 'Whatsapp' }}</label>
        <input type="text" class="form-control" name="settings[whatsapp]" value="{{ $settings->whatsapp ?? ''}}"  >
        {!! $errors->first('whatsapp', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="mb-3 text-end">
        <input class="btn btn-primary" type="submit" value="Save">
    </div>


</form>







<script>

    $(function () {

        var form_social = $('#form-settings-social');
        form_social.submit(function (event) {
            event.preventDefault();

            var form_status = $('<div class="form_status"></div>');
            //  $('#subnitBtn').prop('disabled', true);



            //  CKupdate();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: form_social.serialize(),
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

