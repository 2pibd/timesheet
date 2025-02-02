@extends('admin.layouts.master')
@section('title')
    Escalation frequency
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Set Data
        @endslot
        @slot('title')
            Escalation frequency #{{ $escalation_frequency->id }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Edit Escalation frequency #{{ $escalation_frequency->id }}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{route('escalation_frequency.index')}}" class="btn btn-info btn-sm" title="Back"><i
                                class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">

                        <table class="shadow-lg bg-white">
                            <tr>
                                <td class="border px-8 py-4 font-bold">ID</td>
                                <td class="border px-8 py-4">{{ $escalation_frequency->id }}</td>
                            </tr>
                            <tr><td class="border px-8 py-4 font-bold"> Description </td><td class="border px-8 py-4"> {{ $escalation_frequency->description }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Monday </td><td class="border px-8 py-4"> {{ $escalation_frequency->monday }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Tuesday </td><td class="border px-8 py-4"> {{ $escalation_frequency->tuesday }} </td></tr>
                        </table>


                </div>
            </div>
        </div>
    </div>
@endsection
