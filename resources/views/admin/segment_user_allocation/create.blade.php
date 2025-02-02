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
            Segment User Allocation
        @endslot
    @endcomponent
    <div class="wrapper-md">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-md-10">
                          <p class="m-n font-thin h3">Create New segment user allocation</p>
                      </div>
                      <div class="col-md-2">
                             <a href="{{ url('/segment_user_allocation') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                      </div>
                  </div>
              </div>


 <div class="panel-body">
                <div class="col-md-12">

                    <div class="card-body">


                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/segment_user_allocation') }}" accept-charset="UTF-8"  enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('/admin/.segment_user_allocation.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
