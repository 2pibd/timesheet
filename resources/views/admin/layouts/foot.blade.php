

<script type="application/javascript">
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


    });
</script>

@stack('before-scripts')
@livewireScripts


<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
{{--<script src="{{ asset('assets/js/plugins.js') }}?t=435345"></script>--}}
<script type='text/javascript' src='{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}'></script>
<script type='text/javascript' src='{{ asset('assets/libs/flatpickr/flatpickr.min.js')}}'></script>

<script src="{{ asset('plugins/bootbox/bootbox.min.js') }}"></script>
<script src="{{asset('plugins/bootbox/bootbox.locales.min.js')}}"></script>


<script src="{{asset('/plugins/bootstrap-select/js/bootstrap-select.min.js?t=2454')}}"></script>
<!-- apexcharts -->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Vector map-->
<script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

<!--Swiper slider js-->
<script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

<!-- Dashboard init -->
<script src="{{ asset('assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

<script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>
<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>


<!-- Sweet Alert css-->
<link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Sweet alert init js-->
<script src="{{ asset('assets/js/pages/sweetalerts.init.js') }}"></script>
@stack('after-scripts')
