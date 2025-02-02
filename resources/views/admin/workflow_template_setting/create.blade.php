@extends('admin.layouts.master')
@section('title')
    @lang('translation.create_template_type')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Set Data
        @endslot
        @slot('title')
            Segment user allocation
        @endslot
    @endcomponent

    <div class="wrapper-md">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-md-10">
                          <p class="m-n font-thin h3">Create New workflow template setting</p>
                      </div>
                      <div class="col-md-2">
                             <a href="{{ url('/workflow_template_setting') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
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

                        <form method="POST" action="{{ url('/workflow_template_setting') }}" accept-charset="UTF-8"   enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('/admin/.workflow_template_setting.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
