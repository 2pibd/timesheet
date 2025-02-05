<div class="mb-3">
    <label for="name" class="block font-medium text-sm text-gray-700">{{ 'Name' }}</label>
    <input class="form-control" id="name" name="name" type="text"
           value="{{ isset($user_manual->name) ? $user_manual->name : ''}}" required>
    {!! $errors->first('name', '<p>:message</p>') !!}
</div>

<div class="mb-3  ">
    <label for="description" class="block font-medium text-sm text-gray-700">{{ 'Description' }}</label>
    <textarea class="form-control" id="description" name="description"
              rows="5">{!! $user_manual->description ?? '' !!}</textarea>
    {!! $errors->first('description', '<p>:message</p>') !!}
</div>
<div class="mb-3 ">
    <label for="file" class="block font-medium text-sm text-gray-700">{{ 'File' }}</label>

    <input class="filepond"  id="filepond-file" name="file" type="file"
           value="">
    {!! $errors->first('file', '<p>:message</p>') !!}
</div>


<div class="d-flex">
    <div class=" {{ $errors->has('Viewable') ? 'has-error' : ''}} mb-3 col-md-4 col-sm-12">
        <label for="Viewable" class="control-label">{{ 'Viewable To' }} </label>
        <!-- Base Example -->
        <div class="d-flex gap-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="client" name="client" value="1"
                       @if(isset($user_manual->client) && $user_manual->client==1) checked @endif>
                <label class="form-check-label" for="client">
                    Client
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="worker" name="worker" value="1"
                       @if(isset($user_manual->worker) && $user_manual->worker==1) checked @endif>
                <label class="form-check-label" for="worker">
                    Worker
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="supplier" name="supplier" value="1"
                       @if(isset($user_manual->supplier) && $user_manual->supplier==1) checked @endif>
                <label class="form-check-label" for="supplier">
                    Supplier
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="consultant" name="consultant" value="1"
                       @if(isset($user_manual->consultant) && $user_manual->consultant==1) checked @endif>
                <label class="form-check-label" for="consultant">
                    Consultant
                </label>
            </div>
        </div>
    </div>


    <div class="mb-3">
        <label for="status" class="block font-medium text-sm text-gray-700">{{ 'Status' }}</label>
        <select class="form-select" id="status" name="status">
            @foreach($status as $item)
                <option
                    value="{{$item}}" {{(isset($user_manual->status) && ($user_manual->status == $item) )? 'selected': ''}} >{{$item}}</option>
            @endforeach
        </select>

        {!! $errors->first('status', '<p>:message</p>') !!}
    </div>
</div>
<div class="flex text-end gap-4">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>


<!-- dropzone css -->
<link rel="stylesheet" href="{{asset('assets/libs/dropzone/dropzone.css')}}" type="text/css"/>
<!-- Filepond css -->
<link rel="stylesheet" href="{{asset('assets/libs/filepond/filepond.min.css')}}" type="text/css"/>
<link rel="stylesheet"
      href="{{asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">

<!-- filepond js -->
<script src="{{asset('assets/libs/filepond/filepond.min.js')}}"></script>
<script src="{{asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js')}}"></script>


<script>
    $(function () {
// Favicon
        const fileInput = document.querySelector('#filepond-file');
        const filePond = FilePond.create(fileInput, {
            server: {
                process: '/admin/upload-usermanual',
                revert: '/admin/revert-usermanual',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            },
            allowImageResize: true,
            imageResizeTargetWidth: 64,
            imageResizeTargetHeight: 64,
            acceptedFileTypes: ['image/png', 'image/jpeg', 'image/gif'],
            maxFileSize: '1MB',
        });

        const fileUrl = '{{ !empty($user_manual->file) ? $user_manual->file: '' }}';
        if (fileUrl) {
            fetch(fileUrl)
                .then(response => response.blob())
                .then(blob => {
                    const file = new File([blob], "{{$user_manual->file ?? 'logo.jpg'}}", {type: blob.type});

                    filePond.files = [{
                        source: file,
                        options: {
                            type: 'local',
                        },
                    }];
                })
                .catch(error => {
                    console.error("Error loading image for preview:", error);
                });
        }

    });
</script>
