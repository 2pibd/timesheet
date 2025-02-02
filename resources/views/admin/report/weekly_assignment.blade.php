@extends('admin.layouts.master')
@section('title')
    Report
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Report
        @endslot
        @slot('title')
            Weekly Assignment
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Weekly Assignment</h4>

                    <div class="flex-shrink-0">



                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('report.report-weekly-assignment')

                </div>
            </div>
        </div>
    </div>


@endsection


