@extends('admin.master')

@section('content')



    <div class="wrapper-md">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-10">
                        <p class="m-n font-thin h3"> Address Book</p>
                    </div>
                    <div class="col-md-2 text-right">

                    </div>
                </div>
            </div>


            <div class="panel-body">
                <div class="col-md-12">
                    <div class="card-body">


                        <div class="table-responsive">





                            <table class="table table-bordered" id="Datatable">
                                <thead>
                                <tr  class="info">
                                    <th>SRL No.</th>
                                    <th>Client  Name</th>
                                    <th>Address Line1</th>
                                    <th nowrap>Address Line2</th>
                                    <th>Address Line3</th>
                                    <th>Address Line4</th>
                                    <th nowrap>Address Line5</th>
                                    <th nowrap>City</th>
                                    <th nowrap>State</th>
                                    <th nowrap>Postcode</th>
                                    <th nowrap>Country</th>
                                    <th nowrap>Address Type</th>
                                    <th nowrap>Default</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contact_details as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td nowrap>{{ $item->company->company_name ?? '' }} </td>

                                        <th> {{$item->address1 ?? '' }}</th>

                                        <th> {{$item->address2 ?? '' }}</th>
                                        <th> {{$item->address3 ?? '' }}</th>
                                        <th> {{$item->address4 ?? '' }}</th>
                                        <th> {{$item->address5 ?? '' }}</th>
                                        <th> {{$item->city ?? '' }}</th>
                                        <td>{{ $item->state ?? '' }}</td>
                                        <td>{{ $item->postcode ?? '' }}</td>
                                        <td>{{ $item->country ?? '' }}</td>

                                        <td>{{ $item->address_type ?? '' }}</td>
                                        <td align="text-center">{!!  ($item->is_default == 1)? '<i class="fa fa-check-circle-o"></i>' : ''  !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--<div
                                class="pagination-wrapper"> {!! $user_target->appends(['search' => Request::get('search')])->render() !!} </div>--}}
                        </div>

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

        .tableTxtfield{
            background: #D9EDF7;
        }
        .tableTxtfield:focus{
            background: #FFF;
        }
        .buttons-columnVisibility
        {
            background:#70D589 ;
            color: #FFF;
            font-weight: 500;
            border-radius: 2px;
            padding: 5px 10px;
            font-size: 12px;
            margin-top: 25px;
            outline: 0!important;
            margin-bottom: 0;
            border: 0;
        }
        .buttons-columnVisibility:active, button.active{
            background:#23AD44 ;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src=" https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $.fn.searchcolumn = function () {
                $('#Datatable thead tr').clone(true).appendTo('#Datatable thead');

                /* $('#clientDataTable tfoot th').each(function () {
                     var title = $(this).text();
                     if(title != 'Action')
                         $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                 });*/
            }
            $.fn.searchcolumn();
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
                dom: 'Blfrtip',
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

                "processing": true,
                "responsive": true,

                initComplete: function () {

                    $('#Datatable thead tr:eq(1) th').each(function (i) {
                        var title = $(this).text();

                        if(title != 'Actions')
                            $(this).html('<input type="text" class="form-control tableTxtfield" placeholder="Search ' + title + '" />');
                       // $( 'input', this ).on( 'keyup change', function () {
                            $('input', this).on('keypress', function (e) {
                                if (e.keyCode == 13) {
                                    if (table.column(i).search() !== this.value) {
                                        table
                                            .column(i)
                                            .search(this.value)
                                            .draw();
                                    }
                                }
                        });
                    });

                }

            });


            $('.dt-buttons').addClass('pull-right inline')


        });
    </script>

@endsection
