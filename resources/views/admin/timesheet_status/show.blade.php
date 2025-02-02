@extends('admin.layouts.master')
@section('title')
    Time Sheet Status
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            Time Sheet  Status #{{ $timesheet_status->id }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">  Time Sheet Status #{{ $timesheet_status->id }}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{route('timesheet_status.create')}}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        <a href="{{route('timesheet_status.index')}}" class="btn btn-info btn-sm" title="Back"><i
                                class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">

                        <table class="shadow-lg bg-white">
                            <tr>
                                <td class="border px-8 py-4 font-bold">ID</td>
                                <td class="border px-8 py-4">{{ $timesheet_status->id }}</td>
                            </tr>
                            <tr><td class="border px-8 py-4 font-bold"> Code </td><td class="border px-8 py-4"> {{ $timesheet_status->code }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Status </td><td class="border px-8 py-4"> {{ $timesheet_status->status }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Details </td><td class="border px-8 py-4"> {{ $timesheet_status->details }} </td></tr>
                        </table>


                </div>
            </div>
        </div>
    </div>
@endsection
