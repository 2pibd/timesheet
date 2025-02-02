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
                       <div class="col-md-6">
                           <p class="m-n font-thin h3">Segment User Allocation {{ $segment_user_allocation->id }}</p>
                       </div>
                       <div class="col-md-6">
                           <a href="{{ url('/segment_user_allocation') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                                                 <a href="{{ url('/segment_user_allocation/' . $segment_user_allocation->id . '/edit') }}" title="Edit segment_user_allocation"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                                 <form method="POST" action="{{ url('segment_user_allocation' . '/' . $segment_user_allocation->id) }}" accept-charset="UTF-8" style="display:inline">
                                                     {{ method_field('DELETE') }}
                                                     {{ csrf_field() }}
                                                     <button type="submit" class="btn btn-danger btn-sm" title="Delete segment_user_allocation" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                                 </form>

                       </div>
                   </div>
               </div>


               <div class="panel-body">
                   <div class="col-md-12">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $segment_user_allocation->id }}</td>
                                    </tr>
                                    <tr><th> Seg Combination Setup Id </th><td> {{ $segment_user_allocation->seg_combination_setup_id }} </td></tr><tr><th> User Id </th><td> {{ $segment_user_allocation->user_id }} </td></tr><tr><th> Start Date </th><td> {{ $segment_user_allocation->start_date }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
