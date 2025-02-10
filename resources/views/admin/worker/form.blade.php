<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="mb-3   d-flex ">
            <label for="employer_id" class="block font-medium text-sm text-gray-700 w-25  ">{{ 'Employer*' }}</label>
            <select class="form-select w-75" id="employer_id" name="employer_id" required>
                <option value="">--Select One--</option>
                @foreach($employers as $key=>$item)
                    <option
                        value="{{$item->id}}" {{(isset($worker->employer_id) && ($worker->employer_id == $item->id) )? 'selected': ''}} >{{$item->external_ref}} :: {{$item->company_name}}</option>
                @endforeach
            </select>
            {!! $errors->first('employer_id', '<p>:message</p>') !!}
        </div>
        <div class="mb-3   d-flex ">
            <label for="consultant_id" class="block font-medium text-sm text-gray-700 w-25  ">{{ 'Consultant' }}</label>
            <div class="w-75 "> <select class="form-select " id="consultant_id" name="consultant_id">
                <option value="">--Select One--</option>
                @foreach($consultants as $key=>$item)
                    <option
                        value="{{$item->id}}" {{(isset($worker->consultant_id) && ($worker->consultant_id == $item->id) )? 'selected': ''}} >{{$item->ref_code}} :: {{$item->name}}</option>
                @endforeach
            </select>
            {!! $errors->first('consultant_id', '<p>:message</p>') !!}
            </div>
        </div>

        <div class="mb-3   d-flex ">
            <label for="supplier_id" class="block font-medium text-sm text-gray-700 w-25  ">{{ 'Supplier Name*' }}</label>
            <div class="w-75 ">
                <select class="form-select " id="supplier_id" name="supplier_id" required>
                <option value="">--Select One--</option>
                @foreach($suppliers  as $key=>$item)
                    <option
                        value="{{$item->id}}" {{(isset($worker->supplier_id) && ($worker->supplier_id == $item->id) )? 'selected': ''}} >{{$item->supplier_ref}} :: {{$item->business_name}}</option>
                @endforeach
            </select>
            {!! $errors->first('supplier_id', '<p>:message</p>') !!}
            </div>
        </div>


        <div class="mb-3 d-flex">
            <label for="emp_ref" class="block font-medium text-sm text-gray-700 w-25 ">{{ 'Emp Ref' }}</label>
           <div class="w-75 "> <input class="form-control" id="emp_ref" name="emp_ref" type="text"
                   value="{{ isset($worker->emp_ref) ? $worker->emp_ref : ''}}">
            {!! $errors->first('emp_ref', '<p>:message</p>') !!}
           </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="personal_ref" class="block font-medium text-sm text-gray-700 w-25">{{ 'Personal Ref' }}</label>
            <div class="w-75 "> <input class="form-control" id="personal_ref" name="personal_ref" type="text"
                   value="{{ isset($worker->personal_ref) ? $worker->personal_ref : ''}}">
            {!! $errors->first('personal_ref', '<p>:message</p>') !!}
            </div>
        </div>

        <div class="mb-3 d-flex">
            <label for="name_title" class="block font-medium text-sm text-gray-700 w-25">{{ 'Title*' }}</label>
            <div class="w-75 ">
            <select class="form-select " name="name_title"  id="name_title" required="required">
                <option value="">--</option>
                @foreach($name_titles as  $item)
                    <option value="{{ $item->title }}"
                            @if(isset($worker->profile) && $worker->profile->name_title ==  $item->title) selected @endif>{{ $item->title }}</option>
                @endforeach
            </select>
                {!! $errors->first('name_title', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="first_forename" class="block font-medium text-sm text-gray-700 w-25">{{ 'First Forename' }}</label>
            <div class="w-75 "><input class="form-control" id="first_name" name="first_name" type="text"
                   value="{{ isset($worker->profile) ? $worker->profile->first_name : ''}}">
            {!! $errors->first('first_forename', '<p>:message</p>') !!}
            </div>
        </div>

        <div class="mb-3 d-flex">
            <label for="middle_name" class="block font-medium text-sm text-gray-700 w-25">{{ 'Second Forename' }}</label>
            <div class="w-75 "><input class="form-control" id="middle_name" name="middle_name" type="text"
                   value="{{  $worker->profile->middle_name ??  ''}}">
            {!! $errors->first('middle_name', '<p>:message</p>') !!}
            </div>
        </div>


        <div class="mb-3 d-flex">
            <label for="last_name" class="block font-medium text-sm text-gray-700 w-25">{{ 'Third Forename' }}</label>
            <div class="w-75 "><input class="form-control" id="last_name" name="last_name" type="text"
                   value="{{ $worker->profile->last_name ?? ''}}">
            </div>
            {!! $errors->first('last_name', '<p>:message</p>') !!}
        </div>


        <div class="mb-3 d-flex">
            <label for="surname" class="block font-medium text-sm text-gray-700 w-25">{{ 'Surname' }}</label>
            <div class="w-75 "><input class="form-control" id="surname" name="surname" type="text"
                   value="{{ isset($worker->surname) ? $worker->surname : ''}}">
            {!! $errors->first('surname', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="paye_code" class="block font-medium text-sm text-gray-700 w-25">{{ 'Paye Code' }}</label>
            <div class="w-75 "> <input class="form-control" id="paye_code" name="paye_code" type="text"
                   value="{{ isset($worker->paye_code) ? $worker->paye_code : ''}}">
            {!! $errors->first('paye_code', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="ni_number" class="block font-medium text-sm text-gray-700 w-25">{{ 'Ni Number' }}</label>
            <div class="w-75 "><input class="form-control" id="ni_number" name="ni_number" type="text"
                   value="{{ isset($worker->ni_number) ? $worker->ni_number : ''}}">
            {!! $errors->first('ni_number', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="gender" class="block font-medium text-sm text-gray-700 w-25">{{ 'Gender*' }}</label>
            <div class="w-75 ">
                <div class="btn-group btn-group-sm" role="group"  >
                    <input type="radio" class="btn-check" name="gender" id="male" value="1" autocomplete="off"
                           @if(isset($worker) && $worker->gender == 'Male') checked @endif>
                    <label class="btn btn-outline-secondary" for="male">Male</label>

                    <input type="radio" class="btn-check" name="gender" id="Female" value="0" autocomplete="off"
                           @if(isset($worker) && $worker->gender == 'Female') checked @endif>
                    <label class="btn btn-outline-secondary" for="Female">Female</label>

                </div>


            {!! $errors->first('gender', '<p>:message</p>') !!}
            </div>
        </div>


        <div class="mb-3 d-flex">
            <label for="address" class="block font-medium text-sm text-gray-700 w-25">{{ 'Address' }}</label>
            <div class="row-gap-2 row-gap-3 w-75">
                <input class="form-control mb-2" id="address_line1" name="address_line1" type="text" placeholder="Address Line 1"
                             value="{{ isset($worker->address_line1) ? $worker->address_line1 : ''}}">
                <input class="form-control mb-2" id="address_line2" name="address_line2" type="text" placeholder="Address Line 2"
                                  value="{{ isset($worker->address_line2) ? $worker->address_line2 : ''}}">
                <input class="form-control mb-2" id="address_line3" name="address_line3" type="text" placeholder="Address Line 3"
                              value="{{ isset($worker->address_line3) ? $worker->address_line3 : ''}}">
            <input class="form-control mb-2" id="address_line4" name="address_line4" type="text" placeholder="Address Line 4"
                   value="{{ isset($worker->address_line4) ? $worker->address_line4 : ''}}">
            <input class="form-control mb-2" id="address_line5" name="address_line5" type="text" placeholder="Address Line 5"
                   value="{{ isset($worker->address_line5) ? $worker->address_line5 : ''}}">
            </div>
            {!! $errors->first('address', '<p>:message</p>') !!}
        </div>
    </div>


    <div class="col-md-6 col-sm-12">
        <div class="mb-3   d-flex  ">
            <label for="department_ref" class="block font-medium text-sm text-gray-700 w-25">{{ 'Department' }}</label>
            <div class="w-75 ">
            <select class="form-select" id="department_id" name="department_id" required>
                <option value="">--Select One--</option>
                @foreach($departments as $key=>$item)
                    <option
                        value="{{$item->id}}" {{(isset($worker->department_id) && ($worker->department_id == $item->id) )? 'selected': ''}} >{{$item->ref_code}}:: {{$item->name}}</option>
                @endforeach
            </select>
            {!! $errors->first('department_ref', '<p>:message</p>') !!}
            </div>
        </div>


        <div class="mb-3   d-flex  ">
            <label for="department_ref" class="block font-medium text-sm text-gray-700 w-25">{{ 'Division' }}</label>
            <div class="w-75 ">
            <select class="form-select" id="division_id" name="division_id" required>
                <option value="">--Select One--</option>
                @foreach($divisions as $key=>$item)
                    <option
                        value="{{$item->id}}" {{(isset($worker->division_id) && ($worker->division_id == $item->id) )? 'selected': ''}} >{{$item->ref_code}}:: {{$item->name}}</option>
                @endforeach
            </select>
            {!! $errors->first('department_ref', '<p>:message</p>') !!}
            </div>
        </div>




        <div class="mb-3 d-flex">
            <label for="post_code" class="block font-medium text-sm text-gray-700 w-25">{{ 'Post Code' }}</label>
            <div class="w-75"> <input class="form-control" id="post_code" name="post_code" type="text"
                   value="{{ isset($worker->post_code) ? $worker->post_code : ''}}">
            {!! $errors->first('post_code', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="country_id" class="block font-medium text-sm text-gray-700 w-25">{{ 'Country' }}</label>
            <div class="w-75">
                <select class="form-select" id="country_id" name="country_id">
                    <option value="">--Select One--</option>
                    @foreach($countries as $key=>$item)
                        <option
                            value="{{$item->id}}" {{(isset($worker->country_id) && ($worker->country_id == $item->id) )? 'selected': ''}} >{{$item->country}}({{$item->code}})</option>
                    @endforeach
                </select>
                {!! $errors->first('country_id', '<p>:message</p>') !!}</div>
        </div>
        <div class="mb-3 d-flex">
            <label for="tel_number" class="block font-medium text-sm text-gray-700 w-25">{{ 'Tel Number' }}</label>
            <div class="w-75"> <input class="form-control" id="tel_number" name="tel_number" type="text"
                   value="{{ isset($worker->tel_number) ? $worker->tel_number : ''}}">
            {!! $errors->first('tel_number', '<p>:message</p>') !!}  </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="mobile_number" class="block font-medium text-sm text-gray-700 w-25">{{ 'Mobile Number' }}</label>
            <div class="w-75"> <input class="form-control" id="mobile_number" name="mobile_number" type="text"
                   value="{{ isset($worker->mobile_number) ? $worker->mobile_number : ''}}">
            {!! $errors->first('mobile_number', '<p>:message</p>') !!}  </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="email" class="block font-medium text-sm text-gray-700 w-25">{{ 'Email*' }}</label>
            <div class="w-75">  <input class="form-control" id="email" name="email" type="email" required
                   value="{{ isset($worker->email) ? $worker->email : ''}}">
            {!! $errors->first('email', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="dob" class="block font-medium text-sm text-gray-700 w-25">{{ 'DOB' }}</label>
            <div class="w-75"> <input class="form-control" id="dob" name="dob" type="text"
                   value="{{ isset($worker->dob) ? $worker->dob : ''}}">
            {!! $errors->first('dob', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="work_type" class="block font-medium text-sm text-gray-700 w-25">{{ 'Work Type*' }}</label>
            <select class="form-select w-75" id="work_type" name="work_type" required>
                <option value="">--Select One--</option>
                @foreach($worker_types as $key=>$item)
                    <option
                        value="{{$item->id}}" {{(isset($worker->work_type) && ($worker->work_type == $item->id) )? 'selected': ''}} > {{$item->type}}</option>
                @endforeach
            </select>

            {!! $errors->first('work_type', '<p>:message</p>') !!}
        </div>
        <div class="mb-3 d-flex">
            <label for="awr_type" class="block font-medium text-sm text-gray-700 w-25">{{ 'Awr Type' }}</label>
            <div class="w-75">
                <select class="form-select w-75" id="awr_type" name="awr_type"  >
                    <option value="">--Select One--</option>
                    @foreach($awr_types as $key=>$item)
                        <option  value="{{$item->id}}" {{(isset($worker->awr_type) && ($worker->awr_type == $item->id) )? 'selected': ''}} > {{$item->type}}</option>
                    @endforeach
                </select>

            {!! $errors->first('awr_type', '<p>:message</p>') !!}
            </div>
        </div>

        <div class="mb-3   d-flex  ">
            <label for="employer_type_id" class="block font-medium text-sm text-gray-700 w-25">{{ 'Engagement Type' }}</label>
            <select class="form-select w-75" id="employer_type_id" name="employer_type_id">
                <option value="">--Select One--</option>
                @foreach($engagement_types as $key=>$item)
                    <option
                        value="{{$item->id}}" {{(isset($worker->employer_type_id) && ($worker->employer_type_id == $item->id) )? 'selected': ''}} >{{$item->type}}</option>
                @endforeach
            </select>
            {!! $errors->first('employer_type_id', '<p>:message</p>') !!}
        </div>
        <div class="mb-3 d-flex">
            <label for="non_cis_utr" class="block font-medium text-sm text-gray-700 w-25">{{ 'Non Cis Utr' }}</label>
            <div class="w-75">  <input class="form-control" id="non_cis_utr" name="non_cis_utr" type="text"
                   value="{{ isset($worker->non_cis_utr) ? $worker->non_cis_utr : ''}}">
            {!! $errors->first('non_cis_utr', '<p>:message</p>') !!}
            </div>
        </div>
        <div class="mb-3 d-flex">
            <label for="known_as" class="block font-medium text-sm text-gray-700 w-25">{{ 'Known As' }}</label>
            <div class="w-75"> <input class="form-control" id="known_as" name="known_as" type="text"
                   value="{{ isset($worker->known_as) ? $worker->known_as : ''}}">
            {!! $errors->first('known_as', '<p>:message</p>') !!}</div>
        </div>


        <div class="mb-3 d-flex ">
            <label for="status" class="block font-medium text-sm text-gray-700 w-25">{{ 'Login Access' }}</label>
            <!-- Radio Buttons -->
            <div class="btn-group btn-group-sm" role="group" aria-label="web status">
                <input type="radio" class="btn-check" name="status" id="status1" value="1" autocomplete="off"
                       @if(isset( $worker->profile) && $worker->profile->status == 'Active') checked @endif>
                <label class="btn btn-outline-secondary" for="status1">Active</label>

                <input type="radio" class="btn-check" name="status" id="status2" value="0" autocomplete="off"
                       @if(isset( $worker->profile) && $worker->profile->status == 'Inactive') checked @endif>
                <label class="btn btn-outline-secondary" for="status2">Inactive</label>

            </div>
        </div>

        <div class="mb-3 d-flex ">
                <label for="password" class="block font-medium text-sm text-gray-700 w-25">{{ 'Password' }}</label>
                <div class="input-group w-75">
                    <input class="form-control" id="password" name="password" type="password" autocomplete="new-password"  >
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                {!! $errors->first('password', '<p>:message</p>') !!}
            </div>


        </div>
    </div>
    <div class="flex text-end gap-4">
        <button type="submit" class="btn btn-primary">
            {{ $formMode === 'edit' ? 'Update' : 'Create' }}
        </button>
    </div>


    <script>
        $("#workerForm").on("submit", function(event) {

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
