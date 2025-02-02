@extends('admin.layouts.master')
@section('title')
    @lang('translation.user')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            User
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Manage Users</h4>
                    <div class="flex-shrink-0">
                        @can('create-user')
                            <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Add New User</a>
                        @endcan
                    </div>
                </div><!-- end card header -->

                <div class="card-body">

                <div class="col-md-4 mb-2 form-group">
                    <select name="role" id="roleName" class="form-control form-select">
                        <option value="">--Select User Type--</option>
                        @foreach($roles as $item)
                            <option value="{{$item  ?? ''}}">{{$item  ?? ''}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="table-responsive">
                <table  class="table table-bordered w-100" id="Datatable">
                    <thead>
                    <tr class="">
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Phone</th>
                        <th>Created at</th>
                        <th>Account Status</th>
                        <th>Actions</th>
                    </tr>

                    </thead>
                    <tbody>

                    </tbody>

                </table>

            </div>
        </div>
    </div>


</div>
    </div>

    <!-- DATA TABES SCRIPT -->

    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

    <style>
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            visibility: hidden;
        }
    </style>

            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(function () {

            $('#roleName').change(function () {
                $('#Datatable tbody').remove();
                $('#Datatable').DataTable().destroy();

                $.fn.viewcolumn();
            })


            $.fn.viewcolumn = function (pages = 0) {

                var userType =  $('#roleName option:selected').val();

            var table = $('#Datatable').DataTable({
                /*  dom: 'Bfrtip',
                  buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                  ],
                  processing: true,
                  serverSide: true,*/

                dom: 'Blfrtip',
                "processing": true,
                "serverSide": false,
                "responsive": true,
                "bProcessing": true,
                bScrollInfinite: true,
                bScrollCollapse: true,
                orderCellsTop: true,
                select: true,
                fixedHeader: true,
                colReorder: true,


                buttons: [
                    {
                        extend: 'colvis',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'csv','pdf', 'excel', 'print'
                ],

                "lengthMenu": [[  10, 25, 50, -1], [  10, 25, 50, "All"]],


                ajax: {
                    url: "{{ 'getUserList' }}",
                    dataType: 'JSON',
                    data: {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        'usertype': userType
                    },

                    async : true,

                },

                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'roll', name: 'roll'},
                    {data: 'phone', name: 'phone'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                initComplete: function () {

                    $('#Datatable thead tr:eq(1) th').each(function (i) {
                        var title = $(this).text();

                        if(title != 'Actions')
                            $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
                        $( 'input', this ).on( 'keyup change', function () {
                           // $('input', this).on('keypress', function (e) {
                              //  if (e.keyCode == 13) {
                            if (table.column(i).search() !== this.value) {
                                table
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                           // }
                                }
                       });
                    });

                }

            });
            }

            $('.dt-buttons').addClass('pull-right inline')


        });
    </script>

@endsection
