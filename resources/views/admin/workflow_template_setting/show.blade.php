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
                       <div class="col-md-6">
                           <p class="m-n font-thin h3">workflow_template_setting {{ $workflow_template_setting->id }}</p>
                       </div>
                       <div class="col-md-6">
                           <a href="{{ url('/workflow_template_setting') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                                                 <a href="{{ url('/workflow_template_setting/' . $workflow_template_setting->id . '/edit') }}" title="Edit workflow_template_setting"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                                 <form method="POST" action="{{ url('workflow_template_setting' . '/' . $workflow_template_setting->id) }}" accept-charset="UTF-8" style="display:inline">
                                                     {{ method_field('DELETE') }}
                                                     {{ csrf_field() }}
                                                     <button type="submit" class="btn btn-danger btn-sm" title="Delete workflow_template_setting" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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
                                        <th>ID</th><td>{{ $workflow_template_setting->id }}</td>
                                    </tr>
                                    <tr><th> User Id </th><td> {{ $workflow_template_setting->user_id }} </td></tr><tr><th> Title </th><td> {{ $workflow_template_setting->title }} </td></tr><tr><th> Ext Ref </th><td> {{ $workflow_template_setting->ext_ref }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
