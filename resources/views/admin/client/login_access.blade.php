<form method="POST" id="loginAccess-form" action="{{ url('/admin/login-access') }}" accept-charset="UTF-8">
    {{ csrf_field() }}
    <div class="row">
        <input class="form-control" id="client_id" name="client_id" type="hidden"
               value="{{ isset($client->id) ? $client->id : ''}}" required>

        <div class="d-flex gap-2 col-md-6">
            <div class="form-group mb-3 w-25">
                <label for="contact_name" class="control-label">Name Title*</label>

                <select class="form-select " name="name_title" type="text" id="name_title" required="required">
                    <option value="">--</option>
                    @foreach($name_titles as  $item)
                        <option value="{{ $item->title }}"
                                @if(isset($client->profile) && $client->profile->name_title ==  $item->title) selected @endif>{{ $item->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 w-75">
                <label for="first_name" class="block font-medium text-sm text-gray-700">{{ 'First Name*' }}</label>
                <input class="form-control" id="first_name" name="first_name" type="text"
                       value="{{ isset($client->first_name) ? $client->first_name : ''}}" required>
                {!! $errors->first('first_name', '<p>:message</p>') !!}
            </div>
        </div>


        <div class="d-flex gap-2 col-md-6">
            <div class="mb-3 w-50">
                <label for="middle_name" class="block font-medium text-sm text-gray-700">{{ 'Middle Name' }}</label>
                <input class="form-control" id="middle_name" name="middle_name" type="text"
                       value="{{ isset($client->middle_name) ? $client->middle_name : ''}}" required>
                {!! $errors->first('middle_name', '<p>:message</p>') !!}
            </div>
            <div class="mb-3 w-50">
                <label for="last_name" class="block font-medium text-sm text-gray-700">{{ 'Last Name' }}</label>
                <input class="form-control" id="last_name" name="last_name" type="text"
                       value="{{ isset($client->last_name) ? $client->last_name : ''}}" required>
                {!! $errors->first('last_name', '<p>:message</p>') !!}
            </div>

        </div>


        <div class="d-flex gap-3">
            <div class="mb-3 w-50">
                <label for="email" class="block font-medium text-sm text-gray-700">{{ 'Email*' }}</label>
                <input class="form-control" id="email" name="email" type="text"
                       value="{{ isset($client->email) ? $client->email : ''}}" onblur="checkEmail()">
                <span id="emailError" class="text-danger"></span>
                {!! $errors->first('email', '<p>:message</p>') !!}
            </div>

            <div class="mb-3 ">
                <label for="password" class="block font-medium text-sm text-gray-700">{{ 'Password' }}</label>
                <div class="input-group">
                    <input class="form-control" id="password" name="password" type="password"
                           autocomplete="new-password">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                {!! $errors->first('password', '<p>:message</p>') !!}
            </div>

            <div class="mb-5">
                <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Login Access' }}</label>
                <br>
                <!-- Radio Buttons -->
                <div class="btn-group btn-group-sm" role="group" aria-label="web status">
                    <input type="radio" class="btn-check" name="status" id="status1" value="1" autocomplete="off"
                           @if(isset($client) && $client->status == '1') checked @endif>
                    <label class="btn btn-outline-secondary" for="status1">Active</label>

                    <input type="radio" class="btn-check" name="status" id="status2" value="0" autocomplete="off"
                           @if(isset($client) && $client->status == '0') checked @endif>
                    <label class="btn btn-outline-secondary" for="status2">Inactive</label>
                </div>
            </div>

        </div>


        <div class="form-group col-md-12 mb-3 ">

            <button class="btn btn-primary pull-right" type="submit" id="addressSavebtn"><i class="fa fa-save"></i>
                Save
            </button>

        </div>
    </div>

</form>


<script type="text/javascript">

    $(document).ready(function () {
        var loginAccessForm = $('#loginAccess-form');


        loginAccessForm.submit(function (event) {

            event.preventDefault();

            $.ajax({
                url: loginAccessForm.attr('action'),
                dataType: "JSON",
                method: 'POST',
                data: loginAccessForm.serialize(),
                success: function (data) {
// $('#addressbtn').prop('disabled', false);
                    if (data.status == 'success') {
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            position: "top-center",
                            icon: "error",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                }
            })
        });

    });

</script>
