@extends('admin.layouts.master')
@section('title')
    @lang('translation.create_email_template')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Set Data
        @endslot
        @slot('title')
            @lang('translation.create_email_template')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('translation.create_email_template')</h4>
                    <div class="flex-shrink-0">
                        <a href="{{route('email_template.create')}}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        <a href="{{route('email_template.index')}}" class="btn btn-info btn-sm" title="Back"><i
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

                        <form method="POST" action="{{ route('email_template.store') }}" class="mt-6 space-y-6" accept-charset="UTF-8" enctype="multipart/form-data">
                            @csrf()
                            @include ('/admin/.email_template.form', ['formMode' => 'create'])
                        </form>


                </div>
            </div>
        </div>
    </div>
@endsection
