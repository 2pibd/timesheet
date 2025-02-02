@extends('admin.layouts.master')
@section('title')
    Permission
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            Edit Permission #{{ $permission->id }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Edit Permission #{{ $permission->id }}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{route('timesheet.create')}}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        <a href="{{route('permission.index')}}" class="btn btn-info btn-sm" title="Back"><i
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

                        <form class="bs-example form-horizontal" action="{{ route('permission.update', $permission->id) }}" method="post"
                              enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                        @include ('admin.permission.form', ['submitButtonText' => 'Update Permission'])
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection




