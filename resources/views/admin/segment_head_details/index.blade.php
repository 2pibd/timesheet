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
            Segment head details
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Segment head details</h4>

                    <div class="flex-shrink-0">
                        @can('create-email_template')
                            <a href="{{url('admin/segment_head_details/create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan



                    </div>
                </div><!-- end card header -->



                <div class="card-body">

                    <form method="GET" action="{{ url('admin/segment_head_details') }}" accept-charset="UTF-8"
                          class="form-inline my-2 my-lg-0 float-right" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search..."
                                   value="{{ request('search') }}">
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
                                <th>#</th>
                                <th>Segment Head</th>
                                <th>Segment Code</th>
                                <th>Details</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($segment_head_details as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->segment_head->seg_name }}</td>
                                    <td>{{ $item->seg_code }}</td>
                                    <td>{{ $item->details }}</td>
                                    <td>
                                        <a href="{{ url('admin/segment_head_details/' . $item->id) }}"
                                           title="View segment_head_detail">
                                            <button class="btn btn-info btn-sm"><i class="fa fa-eye"
                                                                                   aria-hidden="true"></i> View
                                            </button>
                                        </a>
                                        <a href="{{ url('admin/segment_head_details/' . $item->id . '/edit') }}"
                                           title="Edit segment_head_detail">
                                            <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                                      aria-hidden="true"></i> Edit
                                            </button>
                                        </a>

                                        <form method="POST"
                                              action="{{ url('admin/segment_head_details' . '/' . $item->id) }}"
                                              accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    title="Delete segment_head_detail"
                                                    onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                    class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div
                            class="pagination-wrapper"> {!! $segment_head_details->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
