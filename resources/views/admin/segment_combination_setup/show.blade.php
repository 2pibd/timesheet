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
            Segment head
        @endslot
    @endcomponent
       <div class="wrapper-md">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <div class="row">
                       <div class="col-md-6">
                           <p class="m-n font-thin h3">segment_combination_setup {{ $segment_combination_setup->id }}</p>
                       </div>
                       <div class="col-md-6">
                           <a href="{{ url('/segment_combination_setup') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                                                 <a href="{{ url('/segment_combination_setup/' . $segment_combination_setup->id . '/edit') }}" title="Edit segment_combination_setup"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                                 <form method="POST" action="{{ url('segment_combination_setup' . '/' . $segment_combination_setup->id) }}" accept-charset="UTF-8" style="display:inline">
                                                     {{ method_field('DELETE') }}
                                                     {{ csrf_field() }}
                                                     <button type="submit" class="btn btn-danger btn-sm" title="Delete segment_combination_setup" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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
                                        <th>ID</th><td>{{ $segment_combination_setup->id }}</td>
                                    </tr>
                                    <tr><th> Seg Comb Code </th><td> {{ $segment_combination_setup->seg_comb_code }} </td></tr><tr><th> Seg Head Code </th><td> {{ $segment_combination_setup->seg_head_code }} </td></tr><tr><th> Seg 1 </th><td> {{ $segment_combination_setup->seg_1 }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
