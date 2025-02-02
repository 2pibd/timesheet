@extends('admin.layouts.master')
@section('title')
    Segment Settings
@endsection
@section('content')
    @component('admin.components.breadcrumb')
        @slot('li_1')
            Segment Settings
        @endslot
        @slot('title')
            Segment Combination Setup
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Edit segment combination setup #{{ $info->id }}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ url('admin/segment_combination_setup') }}" title="Back">
                            <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Back
                            </button>
                        </a>


                    </div>
                </div><!-- end card header -->


                <div class="card-body">

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <form method="POST" action="{{ url('/admin/segment_combination_setup/' . $info->id) }}"
                          accept-charset="UTF-8" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        @include ('/admin/.segment_combination_setup.form', ['formMode' => 'edit'])

                    </form>


                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                            <tr>
                                @if(isset($segment_combination_headers))
                                    @foreach($segment_combination_headers as $item)
                                        <th>{{$item->header->seg_name ?? ''}}</th>
                                    @endforeach
                                @endif
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(isset($segment_combination_users))
                                @foreach($segment_combination_users as $item)
                                    <tr>

                                        @if(isset($item->header_value))
                                            @foreach($item->header_value as $value)

                                                <th>{{$value->headerdetails->seg_code ?? ''}}
                                                    : {{$value->headerdetails->details ?? ''}}</th>
                                            @endforeach
                                        @endif


                                        <th>
                                            <form method="POST"
                                                  action="{{ url('admin/delete_segment_combination_user' . '/' . $item->id) }}"
                                                  accept-charset="UTF-8" style="display:inline">

                                                {{ csrf_field() }}
                                                <input type="hidden" name="segment_combination_setup_id"
                                                       value="{{$info->id}}">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                </button>
                                            </form>
                                        </th>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
