@extends('admin.layouts.master')
@section('title')
    Invoice
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
           Invoice
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Invoice</h4>

                    <div class="flex-shrink-0">
                        @can('create-invoice')
                            <a href="{{ route('invoice.create') }}" class="px-2 py-1 rounded-md bg-sky-500 text-white hover:bg-sky-600" title="Add New invoice">Add New</a>

                        @endcan



                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('invoice.data-table-invoice')

                </div>
            </div>
        </div>
    </div>
@endsection



