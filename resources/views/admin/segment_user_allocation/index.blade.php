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
                        <p class="m-n font-thin h3">Segment user allocation</p>
                    </div>
                    <div class="col-md-2">
                          <a href="{{ url('/segment_user_allocation/create') }}" class="btn btn-success btn-sm" title="Add New segment_user_allocation">
                                                   <i class="fa fa-plus" aria-hidden="true"></i> Add New
                                               </a>
                    </div>
                </div>
            </div>


                <div class="panel-body">
                <div class="col-md-12">
                    <div class="card-body">

                        <form method="GET" action="{{ url('/segment_user_allocation') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>#</th><th>Seg Combination Setup Id</th><th>User Id</th><th>Start Date</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($segment_user_allocation as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->seg_combination_setup_id }}</td><td>{{ $item->user_id }}</td><td>{{ $item->start_date }}</td>
                                        <td>
                                            <a href="{{ url('/segment_user_allocation/' . $item->id) }}" title="View segment_user_allocation"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/segment_user_allocation/' . $item->id . '/edit') }}" title="Edit segment_user_allocation"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/segment_user_allocation' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete segment_user_allocation" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $segment_user_allocation->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
