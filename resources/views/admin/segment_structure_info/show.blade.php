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
            Segment structure info
        @endslot
    @endcomponent
       <div class="wrapper-md">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <div class="row">
                       <div class="col-md-6">
                           <p class="m-n font-thin h3">segment_structure_info {{ $segment_structure_info->id }}</p>
                       </div>
                       <div class="col-md-6">
                           <a href="{{ url('/segment_structure_info') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                                                 <a href="{{ url('/segment_structure_info/' . $segment_structure_info->id . '/edit') }}" title="Edit segment_structure_info"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                                 <form method="POST" action="{{ url('segment_structure_info' . '/' . $segment_structure_info->id) }}" accept-charset="UTF-8" style="display:inline">
                                                     {{ method_field('DELETE') }}
                                                     {{ csrf_field() }}
                                                     <button type="submit" class="btn btn-danger btn-sm" title="Delete segment_structure_info" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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
                                        <th>ID</th><td>{{ $segment_structure_info->id }}</td>
                                    </tr>
                                    <tr><th> Parent Id </th><td> {{ $segment_structure_info->parent_id }} </td></tr><tr><th> Strcture Code </th><td> {{ $segment_structure_info->strcture_code }} </td></tr><tr><th> Seg Head Id </th><td> {{ $segment_structure_info->seg_head_id }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
