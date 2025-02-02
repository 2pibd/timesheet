@extends('admin.layouts.master')
@section('title')
    Time sheet status
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            Timesheet Status Flag
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">  Timesheet Status Flag </h4>

                    <div class="flex-shrink-0">
                        @can('create-worker')
                            <a href="{{url('admin/timesheet_status/create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan

                    </div>
                </div><!-- end card header -->
                <div class="card-body" >


                        <div class="mt-6">

                            @livewire('timesheet-status.data-table-timesheet-status')

                        </div>
                </div>
            </div>
        </div>
@endsection

