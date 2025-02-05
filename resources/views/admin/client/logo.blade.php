<div class="mb-3 w-25">
    <label for="company_logo" class="block font-medium text-sm text-gray-700">{{ 'Company Logo' }}</label>

    <input class="filepond"  id="filepond-company_logo" name="company_logo" type="file"   value="">
    {!! $errors->first('company_logo', '<p>:message</p>') !!}
</div>


<div class="form-group text-right float-end">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>


<!-- dropzone css -->
<link rel="stylesheet" href="{{asset('assets/libs/dropzone/dropzone.css')}}" type="text/css"/>
<!-- Filepond css -->
<link rel="stylesheet" href="{{asset('assets/libs/filepond/filepond.min.css')}}" type="text/css"/>
<link rel="stylesheet"  href="{{asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">

<!-- filepond js -->
<script src="{{asset('assets/libs/filepond/filepond.min.js')}}"></script>
<script src="{{asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js')}}"></script>


<script>
    $(function () {
        FilePond.registerPlugin(FilePondPluginImagePreview);

        FilePond.setOptions({
            debug: true,
        });
// Favicon
        const fileInput = document.querySelector('#filepond-company_logo');
        const filePond = FilePond.create(fileInput, {
            server: {
                process: '/admin/upload-clientlogo',
                revert: '/admin/revert-clientlogo',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            },
            allowImageResize: true,
            imageResizeTargetWidth: 64,
            imageResizeTargetHeight: 64,
            acceptedFileTypes: ['image/png', 'image/jpeg','image/jpg', 'image/gif'],
            maxFileSize: '1MB',
        });

        const fileUrl = '{{ !empty($client->company_logo) ? $client->company_logo: '' }}';
        if (fileUrl) {
            fetch(fileUrl)
                .then(response => response.blob())
                .then(blob => {

                    const file = new File([blob], "Company Logo", { type: blob.type });

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
