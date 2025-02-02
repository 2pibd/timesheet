<script type="application/javascript">
    jQuery(function ($) {

        var form2 = $('#form-updateProfile');
        form2.submit(function (event) {
            event.preventDefault();

            var form_status = $('<div class="form_status"></div>');
            $('#subnitBtn').prop('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: form2.serialize(),
                success: function (response) {

                }
            }).done(function (data) {      // alert(data)
                $('#user_id').append('<option value="'+data.id+'" SELECTED data-profile="'+data+'">'+ data.name +'</option>');
                $('#appointment_for').val(data.name)
                $('#phone').val(data.mobile)
                   //$('.selectpicker').selectpicker()
                $('.selectpicker').selectpicker('refresh');
              //  $.snackbar({content: "Saved Successfully", timeout: 3000});
                $('#subnitBtn').prop('disabled', false);
                $('#ajaxModal').modal('hide');
                //window.location.href = window.location
            }).fail(function() {
                alert("Error: User Exist");
            });
        });
    });
</script>


<div class="wrapper-md">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-12">
                    <form class="bs-example form-horizontal" accept-charset="UTF-8" id="form-updateProfile"
                          action="{{ url('userProfileUpdate') }}" method="post"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="uid" value="{{ $user->id ?? ''}}">
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="row">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 col-form-label">{{ 'Name' }}</label>

                                        <div class="col-sm-10">
                                            <input class="form-control" name="name" placeholder="Name" type="text"
                                                   id="name"
                                                   value="{{ $user->name ?? ''}}" required>
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label for="email" class="col-sm-2 col-form-label">{{ 'Email' }}</label>

                                        <div class="col-sm-10">

                                            <input class="form-control" name="email" placeholder="Provide email"
                                                   type="text"

                                                   id="email"

                                                   value="{{ $user->email ?? ''}}"  >


                                            {!! $errors->first('email', '<small class="text-danger">:message</small>') !!}

                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="mobile" placeholder="Phone"
                                                   type="text" id="mobile"
                                                   value="{{ $user->mobile ?? ''}}">


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="remarks" class="col-sm-2 col-form-label">Address</label>
                                        <div class="col-sm-10">
                <textarea class="form-control" rows="4" name="street_address" type="textarea"
                          id="address">{{ $user->street_address ?? ''}}</textarea>
                                            {!! $errors->first('address', '<small class="text-danger">:message</small>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" name="city" class="form-control"
                                                           value="{{ $user->city ?? ''}}" placeholder="City">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="area" class="form-control"
                                                           value="{{ $user->area ?? ''}}" placeholder="State">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="postcode" class="form-control"
                                                           value="{{ $user->postcode ?? ''}}" placeholder="Zip code">
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                             @can('create-user')
                                    <div class="form-group">
                                         <label for="role_id" class="col-sm-2 col-form-label">{{ 'Role' }}</label>
                                         <div class="col-sm-10">
                                             <select class="form-control form-select" name="role_id" required>
                                                 <option value=""></option>
                                                 @foreach($roles as $role)
                                                     <option @if(isset($user)) {{ (in_array($role->name, $user->getRoleNames()->toArray())) ? 'selected' : '' }} @endif value="{{$role->id}}">{{ ucfirst($role->name) }}</option>
                                                 @endforeach
                                             </select>

                                             {!! $errors->first('role_id', '<small class="text-danger">:message</small>') !!}
                                         </div>
                                     </div>
                            @else
                                    <input type="hidden" name="role_type" value="{{ $role_type ?? 'Patient'}}">
                                    @endcan


                                </div>


                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <div class="form-group">
                                <div class="text-center"><input class="btn btn-primary" type="submit"
                                                                value="{{   'Save Profile' }}"></div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


