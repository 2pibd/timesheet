<h3>Website Status</h3>


<form method="POST" action="{{ route('save_setting') }}" class="mt-6 space-y-6" id="form-settings-webstatus" accept-charset="UTF-8" enctype="multipart/form-data">
    @csrf()


    <!-- Radio Buttons -->
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="settings[webstatus]" id="webstatus1" value="1" autocomplete="off"
               @if($settings->webstatus == '1') checked @endif>
        <label class="btn btn-outline-secondary" for="webstatus1">Active</label>

        <input type="radio" class="btn-check" name="settings[webstatus]" id="webstatus2" value="0" autocomplete="off"
               @if($settings->webstatus == '0') checked @endif>
        <label class="btn btn-outline-secondary" for="webstatus2">Inactive</label>

    </div>


    <div class="mb-3 text-end">
        <input class="btn btn-primary" type="submit" value="Save">
    </div>


</form>





<script>

    $(function () {

        var form_webstatus = $('#form-settings-webstatus');
        form_webstatus.submit(function (event) {
            event.preventDefault();

            var form_status = $('<div class="form_status"></div>');
            //  $('#subnitBtn').prop('disabled', true);



            //  CKupdate();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: form_webstatus.serialize(),
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


