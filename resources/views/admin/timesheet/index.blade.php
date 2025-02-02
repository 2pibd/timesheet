@extends('admin.layouts.master')
@section('title')
    Consultant
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Timesheet
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Timesheet</h4>

                    <div class="flex-shrink-0">
                        @can('create-client')
                            <a href="{{url('admin/timesheet/create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan



                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('timesheet.data-table-timesheet')

                </div>
            </div>
        </div>
    </div>
@endsection
