@extends('admin.layouts.master')
@section('title')
    My Office
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            My Office
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">My Office</h4>

                    <div class="flex-shrink-0">
                        @can('create-my_office')
                            <a href="{{url('admin/my_office/create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan

                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('my_office.data-table-my_office')

                </div>
            </div>
        </div>
    </div>
@endsection



