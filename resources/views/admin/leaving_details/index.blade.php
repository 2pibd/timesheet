@extends('admin.layouts.master')
@section('title')
    Leaving details
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Leaving Details
        @endslot
    @endcomponent




    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Leaving Details</h4>

                    <div class="flex-shrink-0">
                        @can('create-leaving_details')
                            <a href="{{route('leaving_details.create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan

                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('leaving_details.data-table-leaving_details')

                </div>
            </div>
        </div>
    </div>


@endsection





