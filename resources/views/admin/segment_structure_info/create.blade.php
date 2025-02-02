@extends('admin.layouts.master')
@section('title')
    @lang('translation.menu')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Segment Settings
        @endslot
        @slot('title')
            Segment structure info
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Create New segment structure info </h4>

                    <div class="flex-shrink-0">
                        <a href="{{ url('/segment_structure_info') }}" title="Back">
                            <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Back
                            </button>
                        </a>

                    </div>
                </div><!-- end card header -->


                <div class="card-body">


                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <form method="POST" action="{{ url('/segment_structure_info') }}" accept-charset="UTF-8"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @include ('/admin/.segment_structure_info.form', ['formMode' => 'create'])

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
