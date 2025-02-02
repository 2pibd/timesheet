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
            Segment head
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Edit segment head #{{ $segment_head->id }}</h4>
                    <div class="flex-shrink-0">

                        <a href="{{ url('admin/segment_head') }}" title="Back">
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

                    <form method="POST" action="{{ url('/segment_head/' . $segment_head->id) }}" accept-charset="UTF-8"
                          enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        @include ('/admin/.segment_head.form', ['formMode' => 'edit'])

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
