@extends('admin.layouts.master')
@section('title')
    Flag Color
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Flag Color
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Flag Color</h4>

                    <div class="flex-shrink-0">
                        @can('create-client')
                            <a href="{{url('admin/flag_color/create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan

                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('flag_color.data-table-flag-color')

                </div>
            </div>
        </div>
    </div>
@endsection



