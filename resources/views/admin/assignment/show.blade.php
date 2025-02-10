@extends('admin.layouts.master')
@section('title')
    Assignment
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Assignment
        @endslot
        @slot('title')
            Show Assignment
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Show Assignment #{{ $assignment->id }}</h4>
                    <div class="flex-shrink-0">

                        <a href="{{route('assignment.index')}}" class="btn btn-info btn-sm" title="Back"><i
                                class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">


                        <table class="shadow-lg bg-white">
                            <tr>
                                <td class="border px-8 py-4 font-bold">ID</td>
                                <td class="border px-8 py-4">{{ $assignment->id }}</td>
                            </tr>
                            <tr><td class="border px-8 py-4 font-bold"> Consultent Id </td><td class="border px-8 py-4"> {{ $assignment->consultent_id }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Worker Surname </td><td class="border px-8 py-4"> {{ $assignment->worker_surname }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Worker Forename </td><td class="border px-8 py-4"> {{ $assignment->worker_forename }} </td></tr>
                        </table>


                </div>
            </div>
        </div>
    </div>

@endsection
