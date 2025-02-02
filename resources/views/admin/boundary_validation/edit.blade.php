@extends('admin.layouts.master')
@section('title')
    Boundary validation
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Boundary validation
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Edit Boundary Validation  #{{ $boundary_validation->id }}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{route('boundary_validation.create')}}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        <a href="{{route('boundary_validation.index')}}" class="btn btn-info btn-sm" title="Back"><i
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

                        <form method="POST" action="{{ route('boundary_validation.update', $boundary_validation->id) }}" class="mt-6 space-y-6" accept-charset="UTF-8" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf()

                            @include ('/admin/.boundary_validation.form', ['formMode' => 'edit'])
                        </form>

                </div>
            </div>
        </div>
    </div>
@endsection
