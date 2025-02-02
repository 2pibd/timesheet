@extends('admin.layouts.master')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{'Create New '.ucwords(str_replace('-', ' ', Request::segment(1)))}} </h4>
                    <div class="flex-shrink-0">
                        @can('view-menu')
                            <a href="{{url( 'admin/menu')}}" class="btn btn-info btn-sm pull-right">
                                <i class="fa fa-list-ul"></i>&nbsp;&nbsp;All {{ucwords(Request::segment(1))}}</a>
                        @endcan
                    </div>
                </div><!-- end card header -->
                <div class="card-body">


               {{-- @include('pages.show_flash_message')
                @include('pages.show_error_message')--}}

        <div class="col-md-9">
        <form class="bs-example form-horizontal" action="{{ route('menu.store') }}" method="post"
                              enctype="multipart/form-data">


                            {{ csrf_field() }}

                            @include ('admin.menu.form', ['submitButtonText' => 'Create Menu'])



                        </form>
        </div>
                </div>
            </div>
        </div>
    </div>

@endsection

