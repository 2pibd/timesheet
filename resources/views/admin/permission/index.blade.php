@extends('admin.layouts.master')
@section('title')
    All Permission
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            All Permission
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">All Permission</h4>

                    <div class="flex-shrink-0">
                        @can('create-permission')
                            <a href="{{route('permission.create')}}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i>&nbsp;&nbsp;Create New Permission</a>
                        @endcan

                            @livewire('permission.permission-form')

                    </div>
                </div><!-- end card header -->
                <div class="card-body" >



                    @livewire('permission.data-table-permission')


            </div>
        </div>
    </div>



@endsection
