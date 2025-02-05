@extends('admin.layouts.master')
@section('title')
    timesheet
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Edit timesheet #{{ $timesheet->id }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Edit timesheet #{{ $timesheet->id }}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{route('timesheet.create')}}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        <a href="{{route('timesheet.index')}}" class="btn btn-info btn-sm" title="Back"><i
                                class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">

                        @if ($errors->any())
                            <ul class="text-sm text-red-600 space-y-1 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                            <ul class="nav nav-pills nav-customs nav-danger mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#border-navs-home" role="tab">Timesheet</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#border-navs-profile" role="tab">Timesheet Details</a>
                                </li>

                            </ul><!-- Tab panes -->
                            <div class="tab-content text-muted">
                                <div class="tab-pane active" id="border-navs-home" role="tabpanel">
                                        <form method="POST" action="{{ route('timesheet.update', $timesheet->id) }}" class="mt-6 space-y-6" accept-charset="UTF-8" enctype="multipart/form-data">
                                            {{ method_field('PATCH') }}
                                            @csrf()

                                            @include ('/admin/.timesheet.form', ['formMode' => 'edit'])
                                        </form>

                                </div>
                                <div class="tab-pane" id="border-navs-profile" role="tabpanel">
                                    <form method="POST" action="{{ route('timesheet.update', $timesheet->id) }}" class="mt-6 space-y-6" accept-charset="UTF-8" enctype="multipart/form-data">
                                        {{ method_field('PATCH') }}
                                        @csrf()

                                        @include ('/admin/.timesheet.details_form', ['formMode' => 'edit'])
                                    </form>
                                </div>
                            </div>




                </div>
            </div>
        </div>
    </div>
@endsection
