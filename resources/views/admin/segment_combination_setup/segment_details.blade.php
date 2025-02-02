@extends('admin.master')

@section('content')
      <div class="wrapper-md">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-10">
                            <p class="m-n font-thin h3">Segment combination Details</p>
                        </div>
                        <div class="col-md-2">
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


                            <div class="table-responsive">
                                @if(isset($segment_combination_users))
                                <table class="table table-bordered">
                                    <thead>
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
                                        @foreach($segment_combination_users as $item)
                                            <tr>

                                                @if(isset($item->header_value))
                                                    @foreach($item->header_value as $value)

                                                        <th>{{$value->headerdetails->seg_code ?? ''}} : {{$value->headerdetails->details ?? ''}}</th>
                                                    @endforeach
                                                @endif



                                                <th><form method="POST" action="{{ url('/delete_segment_combination_user' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">

                                                        {{ csrf_field() }}

                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                                    </form></th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
