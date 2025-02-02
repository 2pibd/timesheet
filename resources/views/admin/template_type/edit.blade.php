@extends('admin.layouts.master')
@section('title')
    @lang('translation.edit_template_type')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Set Data
        @endslot
        @slot('title')
            @lang('translation.edit_template_type')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('translation.edit_template_type')  #{{ $template_type->id }}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{route('template_type.create')}}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        <a href="{{route('template_type.index')}}" class="btn btn-info btn-sm" title="Back"><i
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

                    <form method="POST" action="{{ route('template_type.update', $template_type->id) }}"
                          accept-charset="UTF-8" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf()

                        @include ('/admin/.template_type.form', ['formMode' => 'edit'])
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
