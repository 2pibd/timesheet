<div class="row">
    <div class="col-sm-6">
        <div class="row form-group">

            <div class="col-sm-2">

                <label for="name">{{ 'Title' }}</label>

                <select name="name_title" class="form-control form-select" name="name_title">

                    <option value="Mr."
                            @if(!empty($user->name_title) && $user->name_title   == 'Dr.' || old('name_title') =='Dr.') selected="selected" @endif >
                        Dr.

                    </option>

                    <option value="Mr."
                            @if(!empty($user->name_title) && $user->name_title   == 'Mr.' || old('name_title') =='Mr.') selected="selected" @endif >
                        Mr.

                    </option>

                    <option value="Mrs."

                            @if(!empty($user->name_title) && $user->name_title   == 'Mrs.' || old('name_title') =='Mrs.' ) selected="selected" @endif >

                        Mrs.

                    </option>

                    <option value="Miss."

                            @if(!empty($user->name_title) && $user->name_title   == 'Miss.' || old('name_title') =='Miss.') selected="selected" @endif >

                        Miss.

                    </option>

                </select>

            </div>

            <div class="col-sm-3">

                <label for="name">{{ 'First Name' }}</label>

                <input class="form-control" name="first_name" placeholder="First Name" type="text" id="first_name"

                       value="{{ old('first_name') ?? $user->first_name ?? $user->name ?? ''}}" required>

            </div>


            <div class="col-sm-3">

                <label for="name">{{ 'Middle Name' }}</label>

                <input class="form-control" name="middle_name" placeholder="Middle Name" type="text"

                       id="middle_name"

                       value="{{ old('middle_name') ?? $user->middle_name ?? ''}}">

            </div>


            <div class="col-sm-3">

                <label for="name">{{ 'Last Name' }}</label>

                <input class="form-control" name="last_name" placeholder="Last Name" type="text"

                       id="last_name"

                       value="{{old('last_name') ??  $user->last_name ?? ''}}">

                {!! $errors->first('last_name', '<small class="text-danger">:message</small>') !!}

            </div>


        </div>



        <div class="form-group">
            <label for="photo" class="col-sm-2 col-form-label">{{ 'Photo' }}</label>
            <div class="col-sm-10">

                <input id="file-1" type="file" name="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="1">

                {!! $errors->first('file', '<small class="text-danger">:message</small>') !!}
            </div>
        </div>



        <div class="form-group">
            <label for="email" class="col-sm-2 col-form-label">{{ 'Email' }}</label>
            <div class="col-sm-10">
                <input class="form-control" name="email" placeholder="Provide email" type="text" id="email"
                       value="{{old('email')  ??  $user->email ?? ''}}" required>

                {!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 col-form-label">{{ 'Password' }}</label>
            <div class="col-sm-10">
                <input class="form-control" name="password" placeholder="Provide password" type="password" id="password"
                       value=""  >
                {!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
            </div>
        </div>


        <div class="form-group">
            <label for="role_id" class="col-sm-2 col-form-label">{{ 'Role' }}</label>
            <div class="col-sm-10">
          <select class="form-control form-select" name="role_id">
                    <option value=""></option>
                    @foreach($roles as $role)
                        <option @if(isset($user)) {{ (in_array($role->name, $user->getRoleNames()->toArray())) ? 'selected' : '' }} @endif value="{{$role->id}}">{{ ucfirst($role->name) }}</option>
                    @endforeach
           </select>


                {!! $errors->first('role_id', '<small class="text-danger">:message</small>') !!}
            </div>
        </div>


    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="phone" class="  col-form-label text-center">Phone</label>

                <input class="form-control" name="phone" placeholder="Phone" type="text" id="phone"
                       value="{{ old('phone')  ?? $user->phone ?? ''}}">

        </div>
        <div class="form-group">
            <label for="remarks" class=" col-form-label text-center">Permanent Address</label>

                <textarea class="form-control" rows="4" name="address" type="textarea"
                          id="address">{{ old('address') ?? $user->permanent_address->address  ??  ''}}</textarea>
                {!! $errors->first('address', '<small class="text-danger">:message</small>') !!}

        </div>

        <div class="form-group">
            <label class="col-sm-2 col-form-label text-center"></label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="city" class="form-control" value="{{ old('city') ?? $user->permanent_address->city ?? ''}}"  placeholder="City">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="state" class="form-control"  value="{{ old('state') ??  $user->permanent_address->state  ?? ''}}" placeholder="State">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code')  ??  $user->permanent_address->zip_code ?? ''}}"  placeholder="Zip code">
                    </div>
                </div>
            </div>
        </div>






    </div>
</div>


<div class="col-md-12">
    <hr>
    <div class="form-group">
        <div class="text-center">
            <input class="btn btn-primary" type="submit" value="{{ $submitButtonText ?? 'Create' }}">
        </div>
    </div>
</div>

<?php
  $photopath = asset('profileImage');
?>


{!! csrf_field() !!}

@push('scripts')


<script>
    $(function () {
        $('.selectpicker').selectpicker();
    });

</script>
<script>

    $("#file-1").fileinput({
        uploadUrl: "mediastore", // you must set a valid URL here else you will get an error
        allowedFileExtensions : ['jpg', 'png','gif'],
        uploadExtraData: function() {
            return {
            _token: $("input[name='_token']").val(),
            };
        },
        dropZoneTitle: "Upload Photo",
        maxFileSize: 2000,
        maxFilesNum: 1,
        uploadAsync: false,
        overwriteInitial: false,'showPreview' : true,'showUpload' : false,'showRemove' : false,'showCaption' : false,

        <?php if(!empty( $user->photo )){ ?>
        initialPreview: ["<img src=\'<?=(!empty($user->photo)? $photopath .'/'. $user->photo : '' );?>\'>"],
        <?php } ?>
        initialPreviewConfig: [{caption: "<?=(!empty($user->name)? $user->name:'');?>", width: "80px", url: "<?=(!empty($user->photo)? "users?pages=ajax&act=deletephoto&id=$user->id":"");?>", key: 1}, ],
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
        // overwriteInitial: false,'showPreview' : true,'showUpload' : true,'showRemove' : true,'showCaption' : false,

        //allowedFileTypes: ['image', 'video', 'flash'],
        /* slugCallback: function(filename) {
             return filename.replace('(', '_').replace(']', '_');
         }*/


    });

    $("#file-1").on("filepredelete", function(jqXHR) {
        var abort = true;
        if (confirm("Are you sure you want to delete this image?")) {
            abort = false;
        }
        return abort;
    });

    $(document).ready(function() {
        /* $("#test-upload").fileinput({
            'showPreview' : false,
            'allowedFileExtensions' : ['jpg', 'png','gif'],
            'elErrorContainer': '#errorBlock'
        });

        $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
            alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
        });
        */
    });

</script>

    @endpush
