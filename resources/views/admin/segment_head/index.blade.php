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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">


            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-10">
                        <p class="m-n font-thin h3">Segment head</p>
                    </div>
                    <div class="col-md-2">
                          <a href="{{ url('admin/segment_head/create') }}" class="btn btn-success btn-sm" title="Add New segment_head">
                                                   <i class="fa fa-plus" aria-hidden="true"></i> Add New
                                               </a>
                    </div>
                </div>
            </div>


                <div class="panel-body">
                <div class="col-md-12">
                    <div class="card-body">

                        <form method="GET" action="{{ url('admin/segment_head') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>#</th><th>Seg Name</th><th>Min Length</th><th>Max Length</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($segment_head as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->seg_name }}</td>
                                        <td>{{ $item->min_length }}</td>
                                        <td>{{ $item->max_length }}</td>
                                        <td>{{ $item->details }}</td>
                                        <td>
                                            <a href="{{ url('admin/segment_head/' . $item->id . '/edit') }}" title="Edit segment_head"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('admin/segment_head' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete segment_head" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $segment_head->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
