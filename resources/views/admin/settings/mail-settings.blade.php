
<h3>Mail Settings</h3>

<form method="POST" action="{{ route('mailSMTPCheck') }}" class="mt-6 space-y-6" id="form-settings-mail"
      accept-charset="UTF-8" enctype="multipart/form-data">
    @csrf()
<div class="row">
    <div class=" {{ $errors->has('mail_driver') ? 'has-error' : ''}} mb-3 col-md-5">
        <label for="mail_driver" class="control-label">{{ 'Mail Driver' }}</label>
        <select name="settings[mail_driver]" id="mail_driver" class="form-select c-select">
            <option
                value="" {{ (isset($settings->mail_driver ) && $settings->mail_driver == "") ? "selected='selected'":""  }}>
                None
            </option>
            <option
                value="sendmail" {{ (isset($settings->mail_driver ) && $settings->mail_driver== "sendmail" ) ? "selected='selected'":""  }}>
                sendmail - PHP mail()
            </option>
            <option
                value="smtp" {{ ( isset($settings->mail_driver ) && $settings->mail_driver == "smtp" || !isset($settings->mail_driver )) ? "selected='selected'":""  }}>
                SMTP ( Recommended )
            </option>
            <option
                value="mailgun" {{ ( isset($settings->mail_driver ) && $settings->mail_driver == "mailgun") ? "selected='selected'":""  }}>
                Mailgun
            </option>
            <option
                value="ses" {{ (isset($settings->mail_driver ) && $settings->mail_driver== "ses") ? "selected='selected'":""  }}>
                Amazon SES
            </option>
            <option
                value="postmark" {{ (isset($settings->mail_driver ) && $settings->mail_driver== "postmark") ? "selected='selected'":""  }}>
                Postmark
            </option>
        </select>

        <small>(ie, imap.gmail.com, domainname.com)</small>
        {!! $errors->first('mail_driver', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('mail_host') ? 'has-error' : ''}} mb-3 col-md-5">
        <label for="mail_host" class="control-label">{{ 'Mail Host' }}</label>
        <input type="text" class="form-control" name="settings[mail_host]" value="{{ $settings->mail_host ?? 'smtp.mailtrap.io'}}" >
        {!! $errors->first('mail_host', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('mail_port') ? 'has-error' : ''}} mb-3 col-md-2">
        <label for="mail_port" class="control-label">{{ 'Mail Port' }}<small>(ie, 993 - 995)</small></label>
        <input type="text" class="form-control" name="settings[mail_port]" value="{{$settings->mail_port ?? '993'}}" >
        {!! $errors->first('mail_port', '<p class="help-block">:message</p>') !!}
    </div>



    <div class=" {{ $errors->has('mail_username') ? 'has-error' : ''}} mb-3 col-md-4">
        <label for="mail_username" class="control-label">{{ 'Mail Username' }}</label>
        <input type="text" class="form-control" name="settings[mail_username]" value="{{ $settings->mail_username ?? ''}}" >
        {!! $errors->first('mail_username', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('mail_password') ? 'has-error' : ''}} mb-3 col-md-4">
        <label for="mail_password" class="control-label">{{ 'Mail Password' }}</label>
        <input type="text" class="form-control" name="settings[mail_password]" value="{{ $settings->mail_password ?? ''}}" >
        {!! $errors->first('mail_password', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('mail_encryption') ? 'has-error' : ''}} mb-3  col-md-4">
        <label for="mail_encryption" class="control-label">{{ 'Mail Encryption' }}</label>
        <select name="settings[mail_encryption]" id="mail_encryption" class="form-select c-select">
            <option
                value="" {{ (isset($settings->mail_encryption ) && $settings->mail_encryption == "") ? "selected='selected'":""  }}>
                none
            </option>
            <option
                value="ssl" {{ (isset($settings->mail_encryption ) && $settings->mail_encryption == "ssl") ? "selected='selected'":""  }}>
                SSL
            </option>
            <option
                value="tls" {{ (isset($settings->mail_encryption ) && $settings->mail_encryption == "tls") ? "selected='selected'":""  }}>
                TLS
            </option>
            <option value="notls" @if(isset($settings->mail_encryption) && $settings->mail_encryption == 'notls') selected @endif>NOTLS</option>
            <option value="starttls" @if(isset($settings->mail_encryption)  && $settings->mail_encryption == 'starttls') selected @endif>starttls</option>

        </select>

        {!! $errors->first('mail_encryption', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('from_email') ? 'has-error' : ''}} mb-3  col-md-6">
        <label for="from_email" class="control-label">{{ 'Protocol' }}</label>
        <select class="form-select" name="settings[protocol]"  id="protocol" >
            <option value="">--Select Protocol--</option>
            <option value="imap" @if(isset($settings->protocol) && $settings->protocol == 'imap')selected @endif>IMAP</option>
            <option value="pop3" @if(isset($settings->protocol) && $settings->protocol == 'pop3')selected @endif>POP3</option>
        </select>

        {!! $errors->first('from_email', '<p class="help-block">:message</p>') !!}
    </div>


    <div class=" {{ $errors->has('from_email') ? 'has-error' : ''}} mb-3 col-md-6">
        <label for="from_email" class="control-label">{{ 'From Email' }}</label>
        <input type="text" class="form-control" name="settings[from_email]" value="{{ $settings->from_email ?? ''}}" required>
        {!! $errors->first('from_email', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="mb-3 text-end">
        <input class="btn btn-secondary btn-sm"  type="submit" value="Check SMTP Connection">
    </div>

    <div class="mb-3 text-end">
        <input class="btn btn-primary" name="save_mailconfig" value="Save" type="submit" >
    </div>
</div>
</form>


<hr>


<form method="POST" action="{{ route('test-mail') }}" class="mt-6 space-y-6" id="form-testmail"
      accept-charset="UTF-8" enctype="multipart/form-data">
    @csrf()
<h3>Email Template</h3>
    <div class=" {{ $errors->has('message_title') ? 'has-error' : ''}} mb-3">
        <label for="message_title" class="control-label">{{ 'Message Title' }} </label>

        <input type="text" class="form-control" name="settings[message_title]" value="{{ $settings->message_title ?? '{title}'}}" required>
           {!! $errors->first('message_title', '<p class="help-block">:message</p>') !!}
    </div>

    <div class=" {{ $errors->has('message_details') ? 'has-error' : ''}} mb-3">
        <label for="message_details" class="control-label">{{ 'Message Details' }} </label>
        <textarea class="form-control ckeditor-classic" name="settings[message_details]" id="message_details" rows=10  cols=50 required>{{$settings->message_details ?? '{details}'}}</textarea>
        {!! $errors->first('message_details', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="mb-3 text-end">

        <button class="btn btn-secondary btn-sm" type="button">Send a Test Mail</button>
    </div>
</form>



<script src="{{asset('/plugins/ckeditor/ckeditor.js')}}"></script>




<script type="text/javascript">
    $(document).ready(function() {

        var editor = CKEDITOR.replace( 'message_details', {height:['200px'],
            filebrowserUploadUrl: '{{ asset('uploadImage/') }}',
            filebrowserBrowseUrl: '{{ asset('filebrowser/') }}'

        } );

        CKFinder.setupCKEditor( editor, 'ckfinder/' );


    });
</script>





<script>

    $(function () {

        var form_mail = $('#form-settings-mail');
        form_mail.submit(function (event) {
            event.preventDefault();

            var form_status = $('<div class="form_status"></div>');
            //  $('#subnitBtn').prop('disabled', true);

            // Get the value of the clicked button
            var clickedButtonValue = $('input[name="save_mailconfig"]:focus').val();

            // Append a hidden input with the clicked button's value to the form
            $('<input>')
                .attr({
                    type: 'hidden',
                    name: 'save_mailconfig',
                    value: clickedButtonValue
                })
                .appendTo(form_mail);

            //  CKupdate();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: form_mail.serialize(),
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



