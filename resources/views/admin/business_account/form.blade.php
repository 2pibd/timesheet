<div class="mb-3">
    <label for="business_name" class="block font-medium text-sm text-gray-700">{{ 'Business Name' }}</label>
    <input class="form-control" id="business_name" name="business_name" type="text" value="{{ isset($business_account->business_name) ? $business_account->business_name : ''}}" required>
    {!! $errors->first('business_name', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="phone" class="block font-medium text-sm text-gray-700">{{ 'Phone' }}</label>
    <input class="form-control" id="phone" name="phone" type="text" value="{{ isset($business_account->phone) ? $business_account->phone : ''}}" >
    {!! $errors->first('phone', '<p>:message</p>') !!}
</div>
<div class="mb-3">
    <label for="email" class="block font-medium text-sm text-gray-700">{{ 'Email' }}</label>
    <input class="form-control" id="email" name="email" type="text" value="{{ isset($business_account->email) ? $business_account->email : ''}}" >
    {!! $errors->first('email', '<p>:message</p>') !!}
</div>


<div class="mb-5">
    <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Login Access' }}</label>
    <br>
    <!-- Radio Buttons -->
    <div class="btn-group btn-group-sm" role="group" aria-label="web status">
        <input type="radio" class="btn-check" name="status" id="status1" value="1" autocomplete="off"
               @if(isset($business_account) && $business_account->profile->status == 'Active') checked @endif>
        <label class="btn btn-outline-secondary" for="status1">Active</label>

        <input type="radio" class="btn-check" name="status" id="status2" value="0" autocomplete="off"
               @if(isset($business_account) && $business_account->profile->status == 'Inactive') checked @endif>
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
