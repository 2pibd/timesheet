@extends('admin.layouts.master')
@section('title')
    Timesheet Status
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Data Set
        @endslot
        @slot('title')
            flag color
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Create Flag color</h4>
                    <div class="flex-shrink-0">
                        <a href="{{url('admin/flag_color')}}" class="btn btn-info btn-sm" title="Back"><i
                                class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">

                        <form method="POST" action="{{ route('flag_color.store') }}" class="mt-6 space-y-6" accept-charset="UTF-8" enctype="multipart/form-data">
                            @csrf()
                            @include ('/admin/.flag_color.form', ['formMode' => 'create'])
                        </form>

                </div>
            </div>
        </div>
    </div>
@endsection
