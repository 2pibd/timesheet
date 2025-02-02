@extends('admin.layouts.master')
@section('title')
    @lang('translation.profile')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            My Profile
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Manage Profile</h4>
                    <div class="flex-shrink-0">

                    </div>
                </div><!-- end card header -->
                <div class="card-body">

    @php
        use Illuminate\Support\Facades\Auth;
        $role = Auth::user()->roles()->first();
    @endphp



                        <div class="row">

                            <div class="col-md-4 img">

                                <form method="POST" action="{{ url('upload_profile_picture') }}"
                                      enctype="multipart/form-data" autocomplete="off" id="upload_profile_picture_form">
                                    @csrf
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="file" id="imageUpload" accept=".png, .jpg, .jpeg"/>
                                            <label for="imageUpload"><i class="fa fa-camera"></i></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview"
                                                 style="background-image: url( @if(!empty($user->photo)) {{ asset( $user->photo)}} @else {{asset('images/no-user.png') }} @endif );">
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>


                            <div class="col-md-6 details">
                                <blockquote>
                                    <h5>{{ $user->name ?? ''}}</h5>
                                    <small><cite title="Source Title"> {{ $role->name ?? '' }} <i
                                                    class="icon-map-marker"></i></cite></small>
                                </blockquote>


                                <div class="bottom">
                                    @if($user->twitter)
                                        <a class="btn btn-primary btn-twitter btn-sm" href="{{ $user->twitter }}"
                                           target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    @endif
                                    @if($user->google_plus)
                                        <a class="btn btn-danger btn-sm" rel="publisher" target="_blank"
                                           href="{{ $user->google_plus }}">
                                            <i class="fab fa-google-plus"></i>
                                        </a>
                                    @endif
                                    @if($user->facebook)
                                        <a class="btn btn-primary btn-sm" rel="publisher" target="_blank"
                                           href="{{ $user->facebook }}">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    @endif
                                    @if($user->skype)
                                        <a class="btn btn-info btn-sm" rel="publisher" href="{{$user->skype}}"
                                           target="_blank">
                                            <i class="fab fa-skype"></i>
                                        </a>
                                    @endif
                                    @if($user->linkedin)
                                        <a class="btn btn-primary btn-sm" rel="publisher" href="{{$user->linkedin}}"
                                           target="_blank">
                                            <i class="fab  fa-linkedin-in"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-flat w-100 bm-5 btn-primary" id="editProfileBtn">
                                    Edit Profile
                                </button>


                                <button type="button" class="btn btn-flat  w-100 btn-success" id="changePassBtn">
                                    Change password
                                </button>
                            </div>
                            <div class="col-md-12 mt-5">

                                <h4>Check In/Out</h4>
                                <div>
                                    <ul class="list-unstyled">
                                        <li>Logged In: {{ $login->login_time  ?? ''}}</li>

                                        <li>Logged Out: {{ $logged->logout_time  ?? ''}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>


            </div>
        </div>
<style>

    .avatar-upload {
        position: relative;
        width: 200px;

    }
    .avatar-upload .avatar-edit {
        position: absolute;
        right: 12px;
        z-index: 1;
        top: 20px;
    }
    .avatar-upload .avatar-edit input {
        display: none;
    }
    .avatar-upload .avatar-edit input + label {
        display: inline-block;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #FFFFFF;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        padding:5px 5px;
        margin: auto;
        text-align: center;
        transition: all 0.2s ease-in-out;
    }
    .avatar-upload .avatar-edit input + label:hover {
        background: #f1f1f1;
        border-color: #d6d6d6;
    }
    .avatar-upload .avatar-edit input + label:after {
        color: #757575;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    }
    .avatar-upload .avatar-preview {
        width: 200px;
        height: 200px;
        position: relative;     border-radius: 100%;
        border: 6px solid #F8F8F8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);

    }
    .avatar-upload .avatar-preview > div {
        width: 100%;
        height: 100%;   border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

</style>

    <script>
        $(function () {
            $('#profile-image1').on('click', function () {
                $('#profile-image-upload').click();
            });

            function readProfileURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                        $('#imagePreview').hide();
                        $('#imagePreview').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                    // alert(input.files[0].file)
                    img = document.createElement('img');
                    img.src = URL.createObjectURL(input.files[0]);
                    $.formsubmit(input.files[0])
                }
            }

            $("#imageUpload").change(function () {
                readProfileURL(this);
            });

            $.formsubmit = function (file) {
                // Contact form
                var form = $('#upload_profile_picture_form');

                event.preventDefault();
                formData = new FormData(),
                    //   $.each(files, function(i, file) {
                    formData.append('file', file);
                //  });
                params = form.serializeArray(),
                    $.each(params, function (i, val) {
                        formData.append(val.name, val.value);
                    });

                $.ajax({
                    url: form.attr('action'),
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    dataType: "text",
                    data: formData, //form.serialize(),
                    success: function (response) {
                        msg = response;
                        eval(response);
                    }
                }).done(function (data) {
                    if (data.type == 'success') {

                    }

                });
            }

///////////////////////////////edit Profile////////////////////////////////
            var loader7 = '<div align="center"><img src="{{ asset('images/Preloader_7.gif') }}"></div>';
            $(document).on('click', '#editProfileBtn ', function () {
                id = 0;
                $('#ajaxModal .modal-dialog').removeClass('modelWidth80');
                $('#ajaxModalContent').html(loader7)
                $('#ajaxModalLabel').html('Edit Profile')
                $('#ajaxModal').data('id', id).modal('show');
                $.ajax({
                    url: "{{URL::to('/loadEditProfileForm')}}",
                    dataType: "html",
                    type: 'POST',
                    data: {'_token': $('meta[name=csrf-token]').attr('content'), 'step': ''},
                    success: function (responce) {
                        $('#ajaxModalContent').html(responce);
                    }
                })

            });

            @if(empty(Auth::user()->name) )
            $('#editProfileBtn').trigger('click');
            @endif

            $(document).on('click', '#editSignatureBtn ', function () {
                id = 0;
                $('#ajaxModal .modal-dialog').removeClass('modelWidth80');
                $('#ajaxModalContent').html(loader7)
                $('#ajaxModalLabel').html('Signature')
                $('#ajaxModal').data('id', id).modal('show');
                $.ajax({
                    url: "{{URL::to('/loadSignatureForm')}}",
                    dataType: "html",
                    type: 'POST',
                    data: {'_token': $('meta[name=csrf-token]').attr('content'), 'step': ''},
                    success: function (responce) {
                        $('#ajaxModalContent').html(responce);
                    }
                })

            });
            ///////////////////////////////edit Profile////////////////////////////////
            $(document).on('click', '#changePassBtn', function () {

                id = 0;
                $('#ajaxModal .modal-dialog').removeClass('modelWidth80');
                $('#ajaxModalContent').html(loader7)
                $('#ajaxModalLabel').html('Change Password')
                $('#ajaxModal').data('id', id).modal('show');
                $.ajax({
                    url: "{{URL::to('/changePasswardForm')}}",
                    dataType: "html",
                    type: 'POST',
                    data: {'_token': $('meta[name=csrf-token]').attr('content')},
                    success: function (responce) {
                        $('#ajaxModalContent').html(responce);
                    }
                })

            });


        });
    </script>

@endsection
