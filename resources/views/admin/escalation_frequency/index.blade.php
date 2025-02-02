@extends('admin.layouts.master')
@section('title')
    Escalation Frequency
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Site Data
        @endslot
        @slot('title')
            Escalation Frequency
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Escalation Frequency</h4>

                    <div class="flex-shrink-0">
                        @can('create-escalation_frequency')
                            <a href="{{url('admin/escalation_frequency/create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan



                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('escalation_frequency.data-table-escalation_frequency')



                </div>
            </div>
        </div>
    </div>

@endsection



