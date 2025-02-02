@extends('admin.layouts.master')
@section('title')
    Division
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Set Data
        @endslot
        @slot('title')
            Division
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Division List</h4>

                    <div class="flex-shrink-0">
                        @can('create-client')
                            <a href="{{route('division.create') }}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan



                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('division.data-table-division')

                </div>
            </div>
        </div>
    </div>

    Division

@endsection






