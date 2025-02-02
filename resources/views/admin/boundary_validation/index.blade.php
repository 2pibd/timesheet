@extends('admin.layouts.master')
@section('title')
    Boundary validation
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Boundary validation
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Boundary validation</h4>

                    <div class="flex-shrink-0">
                        @can('create-boundary_validation')
                            <a href="{{url('admin/boundary_validation/create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan

                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('boundary_validation.data-table-boundary_validation')

                </div>
            </div>
        </div>
    </div>
@endsection







