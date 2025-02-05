<!DOCTYPE html>
<html lang="{{ @Helper::currentLanguage()->code }}" dir="{{ @Helper::currentLanguage()->direction }}">
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="white" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    @include('admin.layouts.head')

    @livewireStyles
</head>
<body>
<div id="layout-wrapper">

    @include('admin.layouts.header')
    @include('admin.layouts.menu')


    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @include('admin.layouts.errors')

                @yield('content')
            </div>
        </div>
        @include('admin.layouts.footer')
    </div>
</div>
@include('admin.layouts.foot')
@stack('scripts')

<!-- removeNotificationModal -->
<div id="removeModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                               colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title inline" id="ajaxModalLabel">Modal title</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="ajaxModalContent">

                </div>
            </div>
            <div class="modal-footer hide">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script type="application/javascript">
    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }
    $(document).ready(function () {

        $.fn.popuppage = (page = '') => {
            $('#ajaxModal .modal-dialog').removeClass('modelWidth80');

            $('#ajaxModal .modal-dialog').addClass('modelWidth80');

            let url = `{{ url('loadpage')  }}/${page}`;

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    '_token': $('meta[name=csrf-token]').attr('content'),
                },
                dataType: 'JSON',
                success: function (responce) {
                    if (responce.title) {
                        $('#ajaxModalLabel').html(responce.title);
                        $('#ajaxModalContent').css({"height": "70vh", "overflow": "auto", "padding": "20px"})
                        $('#ajaxModalContent').html(responce.details)
                        $('#ajaxModal .modal-footer').append(`<button type="button"  onclick="{ndarequest('Agreed')}"  class="btn btn-primary">I Accept</button>`);
                        $('#ajaxModal .modal-footer').removeClass('hide');

                        $('#ajaxModal').modal('show');
                    }
                }
            })
        }


        /*      var locale = {
                  OK: 'I Suppose',
                  CONFIRM: 'Confirm to Create',
                  CANCEL: 'Cancel'
              };
      */
        /*   bootbox.addLocale('custom', locale);
           bootbox.alert('This is the default alert!');*/
    });
</script>

</body>
</html>
