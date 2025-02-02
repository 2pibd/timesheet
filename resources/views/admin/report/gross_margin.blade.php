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
            Gross Margin
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Gross Margin</h4>

                    <div class="flex-shrink-0">



                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('report.report-gross-margin')

                </div>
            </div>
        </div>
    </div>


@endsection


