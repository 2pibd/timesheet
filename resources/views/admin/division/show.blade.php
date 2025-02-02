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
                    <h4 class="card-title mb-0 flex-grow-1"> Division #{{ $division->id }}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{route('division.create')}}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        <a href="{{route('division.index')}}" class="btn btn-info btn-sm" title="Back"><i
                                class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">


                    <table class="table  bg-white">
                        <tr>
                            <td class="border px-8 py-4 font-bold w-25"> Name</td>
                            <td class="border px-8 py-4"> {{ $division->name }} </td>
                        </tr>
                    </table>


                </div>
            </div>
        </div>
    </div>
@endsection
