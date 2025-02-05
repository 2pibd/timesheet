<div class="row">

    <div class="d-flex gap-2 col-md-6">
        <div class="form-group mb-3 w-25">
            <label for="contact_name" class="control-label">Name Title*</label>

            <select class="form-select " name="name_title" type="text" id="name_title" required="required">
                <option value="">--</option>
                @foreach($name_titles as  $item)
                    <option value="{{ $item->title }}"
                            @if(isset($consultant->profile) && $consultant->profile->name_title ==  $item->title) selected @endif>{{ $item->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 w-75">
            <label for="first_name" class="block font-medium text-sm text-gray-700">{{ 'First Name*' }}</label>
            <input class="form-control" id="first_name" name="first_name" type="text" value="{{ isset($consultant->profile->first_name) ? $consultant->profile->first_name : ''}}" required>
            {!! $errors->first('first_name', '<p>:message</p>') !!}
        </div>
    </div>


    <div class="d-flex gap-2 col-md-6">
        <div class="mb-3 w-50">
            <label for="middle_name" class="block font-medium text-sm text-gray-700">{{ 'Middle Name' }}</label>
            <input class="form-control" id="middle_name" name="middle_name" type="text" value="{{ isset($consultant->profile->middle_name) ? $consultant->profile->middle_name : ''}}"  >
            {!! $errors->first('middle_name', '<p>:message</p>') !!}
        </div>
        <div class="mb-3 w-50">
            <label for="last_name" class="block font-medium text-sm text-gray-700">{{ 'Last Name' }}</label>
            <input class="form-control" id="last_name" name="last_name" type="text" value="{{ isset($consultant->profile->last_name) ? $consultant->profile->last_name : ''}}"  >
            {!! $errors->first('last_name', '<p>:message</p>') !!}
        </div>

    </div>


    <div class="col-md-6">
<div class="mb-3">
    <label for="user_ref" class="block font-medium text-sm text-gray-700">{{ 'User Ref' }}</label>
    <input class="form-control" id="user_ref" name="user_ref" type="text" value="{{ isset($consultant->user_ref) ? $consultant->user_ref : ''}}" >
    {!! $errors->first('user_ref', '<p>:message</p>') !!}
</div>

        <div class="mb-3">
            <label for="address_line1" class="block font-medium text-sm text-gray-700">{{ 'Address Line1' }}</label>
            <input class="form-control" id="address_line1" name="address_line1" type="text" value="{{ isset($consultant->address_line1) ? $consultant->address_line1 : ''}}" >
            {!! $errors->first('address_line1', '<p>:message</p>') !!}
        </div>
        <div class="mb-3">
            <label for="address_line2" class="block font-medium text-sm text-gray-700">{{ 'Address Line2' }}</label>
            <input class="form-control" id="address_line2" name="address_line2" type="text" value="{{ isset($consultant->address_line2) ? $consultant->address_line2 : ''}}" >
            {!! $errors->first('address_line2', '<p>:message</p>') !!}
        </div>
        <div class="mb-3">
            <label for="address_line3" class="block font-medium text-sm text-gray-700">{{ 'Address Line3' }}</label>
            <input class="form-control" id="address_line3" name="address_line3" type="text" value="{{ isset($consultant->address_line3) ? $consultant->address_line3 : ''}}" >
            {!! $errors->first('address_line3', '<p>:message</p>') !!}
        </div>
        <div class="mb-3">
            <label for="address_line4" class="block font-medium text-sm text-gray-700">{{ 'Address Line4' }}</label>
            <input class="form-control" id="address_line4" name="address_line4" type="text" value="{{ isset($consultant->address_line4) ? $consultant->address_line4 : ''}}" >
            {!! $errors->first('address_line4', '<p>:message</p>') !!}
        </div>
        <div class="mb-3">
            <label for="post_code" class="block font-medium text-sm text-gray-700">{{ 'Post Code' }}</label>
            <input class="form-control" id="post_code" name="post_code" type="text" value="{{ isset($consultant->post_code) ? $consultant->post_code : ''}}" >
            {!! $errors->first('post_code', '<p>:message</p>') !!}
        </div>

        <div class="mb-3">
            <label for="language_id" class="block font-medium text-sm text-gray-700">{{ 'Language ID' }}</label>
            <select class="form-select" id="language_id" name="language_id">
                <option value="">--Select One--</option>
                @foreach($languages as $key=>$item)
                    <option
                        value="{{$item->id}}" {{(isset($consultant->language_id) && ($consultant->language_id == $item->id) )? 'selected': ''}} >{{$item->lang}}</option>
                @endforeach
            </select>
              {!! $errors->first('language_id', '<p>:message</p>') !!}
        </div>
</div>

<div class="col-md-6">

    <div class="mb-3">
        <label for="access_code" class="block font-medium text-sm text-gray-700">{{ 'Access Code' }}</label>
        <input class="form-control" id="access_code" name="access_code" type="text" value="{{ isset($consultant->access_code) ? $consultant->access_code : ''}}" >
        {!! $errors->first('access_code', '<p>:message</p>') !!}
    </div>
    <div class="mb-3">
        <label for="official_id" class="block font-medium text-sm text-gray-700">{{ 'official Id' }}</label>
        <input class="form-control" id="officeial_id" name="official_id" type="text" value="{{ isset($consultant->official_id) ? $consultant->official_id : ''}}" >
        {!! $errors->first('official_id', '<p>:message</p>') !!}
    </div>
    <div class="mb-3">
        <label for="email" class="block font-medium text-sm text-gray-700">{{ 'Email*' }}</label>
        <input class="form-control" id="email" name="email" type="text" required value="{{ isset($consultant->profile) ? $consultant->profile->email : ''}}" onblur="checkEmail()">
        <span id="emailError" class="text-danger"></span>
        {!! $errors->first('email', '<p>:message</p>') !!}
    </div>
    <div class="mb-3">
        <label for="work_telephone" class="block font-medium text-sm text-gray-700">{{ 'Work Telephone' }}</label>
        <input class="form-control" id="work_telephone" name="work_telephone" type="text" value="{{ isset($consultant->work_telephone) ? $consultant->work_telephone : ''}}" >
        {!! $errors->first('work_telephone', '<p>:message</p>') !!}
    </div>
    <div class="mb-3">
        <label for="mobile_number" class="block font-medium text-sm text-gray-700">{{ 'Mobile Number' }}</label>
        <input class="form-control" id="mobile_number" name="mobile_number" type="text" value="{{ isset($consultant->mobile_number) ? $consultant->mobile_number : ''}}" >
        {!! $errors->first('mobile_number', '<p>:message</p>') !!}
    </div>

{{--<div class="mb-3">
    <label for="office_manager" class="block font-medium text-sm text-gray-700">{{ 'Office Manager' }}</label>
    <input class="form-control" id="office_manager" name="office_manager" type="text" value="{{ isset($consultant->office_manager) ? $consultant->office_manager : ''}}" >
    {!! $errors->first('office_manager', '<p>:message</p>') !!}
</div>--}}
<div class="mb-5">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Login Access' }}</label>
    <br>
    <!-- Radio Buttons -->
    <div class="btn-group btn-group-sm" role="group" aria-label="web status">
        <input type="radio" class="btn-check" name="status" id="status1" value="1" autocomplete="off"
               @if(isset($consultant) && $consultant->profile->status == 'Active') checked @endif>
        <label class="btn btn-outline-secondary" for="status1">Active</label>

        <input type="radio" class="btn-check" name="status" id="status2" value="0" autocomplete="off"
               @if(isset($consultant) && $consultant->profile->status == 'Inactive') checked @endif>
        <label class="btn btn-outline-secondary" for="status2">Inactive</label>

    </div>

    <div class="mb-3">
        <label for="password" class="block font-medium text-sm text-gray-700">{{ 'Password' }}</label>
        <div class="input-group">
        <input class="form-control" id="password" name="password" type="password" autocomplete="new-password"  >
        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
            <i class="fas fa-eye"></i>
        </button>
        </div>
        {!! $errors->first('password', '<p>:message</p>') !!}
    </div>

   {!! $errors->first('security_admin', '<p>:message</p>') !!}
</div>

</div>
</div>
<div class="flex items-center gap-4 text-end">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>


<script>
    $("#consultentForm").on("submit", function(event) {

        if (!emailValid ) {
            event.preventDefault(); // Stop form submission
            //alert("Please enter a unique email before submitting.");
        }
    });


    document.getElementById('togglePassword').addEventListener('click', function () {
        let passwordField = document.getElementById('password');
        let icon = this.querySelector('i');
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    var emailValid = true; // Track email validation

    function checkEmail() {
        var email = $("#email").val();
        var token = "{{ csrf_token() }}";
        var userId = '{{$consultant->user_id ?? ''}}'
        if(email !== '') {
            $.ajax({
                url: "{{ route('check_email') }}",
                type: "POST",
                data: {email: email, userid: userId  , _token: token},
                success: function(response) {
                    if(response.exists) {
                        $("#emailError").text("This email is already taken.");
                        emailValid = false; // Prevent form submission
                    } else {
                        $("#emailError").text("");
                        emailValid = true; // Allow form submission
                    }
                }
            });
        }
    }

</script>
