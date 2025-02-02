@extends('admin.layouts.master')
@section('title')
    @lang('translation.user')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            User
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Create New User</h4>
                    <div class="flex-shrink-0">

                    </div>
                </div><!-- end card header -->

                <div class="card-body">


                    <div class="col-md-12">
                        <form class="bs-example form-horizontal" action="{{ route('user.store') }}" method="post"
                              enctype="multipart/form-data">

                            {{ csrf_field() }}

                            @include ('admin.user.form', ['submitButtonText' => 'Create User'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

