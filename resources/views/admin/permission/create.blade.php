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
            Permission
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">New Permission</h4>
                    <div class="flex-shrink-0">
                        <a href="{{url('admin/permission')}}" class="btn btn-info btn-sm" title="Back"><i
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

                    <form method="POST" action="{{ route('faq.store') }}" class="mt-6 space-y-6" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf()

                        @include ('admin.permission.form', ['submitButtonText' => 'Create Permission'])

                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection






