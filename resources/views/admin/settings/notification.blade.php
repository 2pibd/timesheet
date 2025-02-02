<h3>Notification Settings</h3>

<form method="POST" action="{{ route('save_setting') }}" class="mt-6 space-y-6" id="form-settings-notification" accept-charset="UTF-8" enctype="multipart/form-data">
    @csrf()

<div class=" {{ $errors->has('email_notification_to') ? 'has-error' : ''}} mb-3">
    <label for="site_title" class="control-label"> {{ 'Website Notification Email' }}</label>
    <input type="text" class="form-control" name="settings[email_notification_to]" value="{{ $settings->email_notification_to ?? 'info@sitename.com'}}" required>
    {!! $errors->first('email_notification_to', '<p class="help-block">:message</p>') !!}
</div>

<div class=" {{ $errors->has('email_notification_to') ? 'has-error' : ''}} mb-3">
    <label for="site_title" class="control-label">Send me an email on new contact Messages :</label><br>
<!-- Radio Buttons -->
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="settings[send_new_message]" id="send_new_message1" value="1" autocomplete="off" checked="">
    <label class="btn btn-outline-secondary" for="send_new_message1">Yes</label>

    <input type="radio" class="btn-check" name="settings[send_new_message]" id="send_new_message2" value="0" autocomplete="off">
    <label class="btn btn-outline-secondary" for="send_new_message2">No</label>

</div>
</div>

<div class=" {{ $errors->has('email_notification_to') ? 'has-error' : ''}} mb-3">
    <label for="site_title" class="control-label">Send me an email on new Comments :</label><br>

<!-- Radio Buttons -->
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="settings[send_new_timesheet]" id="send_new_timesheet1" value="1" autocomplete="off" checked="">
    <label class="btn btn-outline-secondary" for="send_new_timesheet1">Yes</label>

    <input type="radio" class="btn-check" name="settings[send_new_timesheet]" id="send_new_timesheet2" value="0" autocomplete="off">
    <label class="btn btn-outline-secondary" for="send_new_timesheet2">No</label>

</div>
</div>


<div class=" {{ $errors->has('email_notification_to') ? 'has-error' : ''}} mb-3">
    <label for="site_title" class="control-label">Send me an email on new Orders :</label><br>

<!-- Radio Buttons -->
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="settings[send_new_client]" id="send_new_client1" value="1" autocomplete="off" checked="">
    <label class="btn btn-outline-secondary" for="send_new_client1">Yes</label>

    <input type="radio" class="btn-check" name="settings[send_new_client]" id="send_new_client2" value="0" autocomplete="off">
    <label class="btn btn-outline-secondary" for="send_new_client2">No</label>

</div>
</div>

<div class=" {{ $errors->has('email_notification_to') ? 'has-error' : ''}} mb-3">
    <label for="site_title" class="control-label">Send me an email on update of data table :</label><br>
<!-- Radio Buttons -->
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="settings[send_new_worker]" id="send_new_worker1" value="1" autocomplete="off" checked="">
    <label class="btn btn-outline-secondary" for="send_new_worker1">Yes</label>

    <input type="radio" class="btn-check" name="settings[send_new_worker]" id="send_new_worker2" value="0" autocomplete="off">
    <label class="btn btn-outline-secondary" for="send_new_worker2">No</label>

</div>
</div>

<div class=" {{ $errors->has('email_notification_to') ? 'has-error' : ''}} mb-3">
    <label for="site_title" class="control-label">Send me an email on update of private data :</label><br>
<!-- Radio Buttons -->
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="settings[send_new_supplier]" id="send_new_supplier1" value="1" autocomplete="off" checked="">
    <label class="btn btn-outline-secondary" for="send_new_supplier1">Yes</label>

    <input type="radio" class="btn-check" name="settings[send_new_supplier]" id="send_new_supplier2" value="0" autocomplete="off">
    <label class="btn btn-outline-secondary" for="send_new_supplier2">No</label>

</div>
</div>



<div class="mb-3 text-end">
    <input class="btn btn-primary" type="submit" value="Save">
</div>


</form>





<script>

    $(function () {

        var form_notification = $('#form-settings-notification');
        form_notification.submit(function (event) {
            event.preventDefault();

            var form_status = $('<div class="form_status"></div>');

            //  CKupdate();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: form_notification.serialize(),
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

