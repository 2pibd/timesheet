
@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">
                        {{'Edit '.ucwords(str_replace('-', ' ', Request::segment(1)))}} </h4>
                    <div class="flex-shrink-0">
                        @can('create-menu')
                            <a href="{{route('menu.create')}}" class="btn btn-primary btn-sm">
                                <i  class="fa fa-plus"></i>&nbsp;&nbsp;Add New menu</a>
                        @endcan
                        @can('view-menu')
                            <a href="{{url('admin/menu')}}" class="btn btn-info btn-sm">
                                <i  class="fa fa-list-ul"></i>&nbsp;&nbsp;All menu</a>
                        @endcan
                    </div>
                </div><!-- end card header -->
                <div class="card-body">



             {{--   @include('pages.show_flash_message')
                @include('pages.show_error_message')--}}




                <div class="panel-body">
                    <div class="col-md-8 col-md-offset-2">
                        <form class="bs-example form-horizontal"  accept-charset="UTF-8" action="{{ route('menu.update' ,$menu->id) }}" method="post" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        @include ('admin.menu.form', ['submitButtonText' => 'Update menu'])

                        </form>

                    </div>
                </div>
            </div>
     </div>
   </div>
@endsection
