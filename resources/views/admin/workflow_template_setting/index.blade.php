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
                        <p class="m-n font-thin h3">Workflow template setting</p>
                    </div>
                    <div class="col-md-2">
                          <a href="{{ url('/workflow_template_setting/create') }}" class="btn btn-success btn-sm" title="Add New workflow_template_setting">
                                                   <i class="fa fa-plus" aria-hidden="true"></i> Add New
                                               </a>
                    </div>
                </div>
            </div>


                <div class="panel-body">
                <div class="col-md-12">
                    <div class="card-body">

                        <form method="GET" action="{{ url('/workflow_template_setting') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>User Id</th><th>Title</th><th>Ext Ref</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($workflow_template_setting as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user_id }}</td><td>{{ $item->title }}</td><td>{{ $item->ext_ref }}</td>
                                        <td>
                                           {{-- <a href="{{ url('/workflow_template_setting/' . $item->id) }}" title="View workflow_template_setting"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>--}}
                                            <a href="{{ url('/workflow_template_setting/' . $item->id . '/edit') }}" title="Edit workflow_template_setting"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/workflow_template_setting' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete workflow_template_setting" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $workflow_template_setting->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
