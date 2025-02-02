<script type="application/javascript">
    jQuery(function ($) {

        var form = $('#form-updateProfile');
        form.submit(function (event) {
            event.preventDefault();
            $('#ajaxModal').removeClass('shake')
            var form_status = $('<div class="form_status"></div>');
            $('#subnitBtn').prop('disabled', true);
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: form.serialize(),
                success: function (response) {

                }
            }).done(function (data) {      // alert(data)
                if (data.status == 'success') {
                    let snackbar  = new SnackBar;
                    snackbar.make("message",
                        [
                            data.message,
                            null,
                            "top",
                            "center"
                        ], 4000);
                    //$.snackbar({content: "Save Successfully", timeout: 1000});

                }
                $('#subnitBtn').prop('disabled', false);
                if(data.status =='failed')  $('#ajaxModal').addClass('shake');
               else $('#ajaxModal').modal('hide');
            });
        });
    });
</script>
<style>
    .shake {
        /* Start the shake animation and make the animation last for 0.5 seconds */
        animation: shake 0.5s;
        transform: translate3d(0, 0, 0);
        backface-visibility: hidden;
        perspective: 1000px
        /* When the animation is finished, start again */
        'animation-iteration-count: infinite;
    }

    @keyframes shake {
        0% { transform: translate(1px, 1px) rotate(0deg); }
        10% { transform: translate(-1px, -2px) rotate(-1deg); }
        20% { transform: translate(-3px, 0px) rotate(1deg); }
        30% { transform: translate(3px, 2px) rotate(0deg); }
        40% { transform: translate(1px, -1px) rotate(1deg); }
        50% { transform: translate(-1px, 2px) rotate(-1deg); }
        60% { transform: translate(-3px, 1px) rotate(0deg); }
        70% { transform: translate(3px, 1px) rotate(-1deg); }
        80% { transform: translate(-1px, -1px) rotate(1deg); }
        90% { transform: translate(1px, 2px) rotate(0deg); }
        100% { transform: translate(1px, -2px) rotate(-1deg); }
    }
</style>

<div class="wrapper-md">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-12">
                    <form class="bs-example form-horizontal" accept-charset="UTF-8" id="form-updateProfile"
                          action="{{ url('updatePassword') }}" method="post"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-sm-12">

                                <div class="row">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-3 col-form-label">{{ 'Old Password' }}</label>

                                        <div class="col-sm-9">
                                            <input class="form-control" name="oldpassword"  type="password"
                                                   value="" required>

                                        </div>
                                    </div>





                                    <div class="form-group">
                                        <label for="phone" class="col-sm-3 col-form-label">New Password</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="new_password" type="password" id="password"   value="" required>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="phone" class="col-sm-3 col-form-label">Confirm Password</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" name="confirmpass" type="password" value="" required>
                                        </div>
                                    </div>



                                </div>


                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <div class="form-group">
                                <div class="text-center"><input class="btn btn-primary" type="submit"
                                                                value="{{   'Change Password' }}"></div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


