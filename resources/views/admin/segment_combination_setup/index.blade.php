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
            Segment combination setup
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Segment combination setup </h4>

                    <div class="flex-shrink-0">
                        <a href="{{ url('admin/segment_combination_setup/create') }}" class="btn btn-primary btn-sm"
                           title="Add New segment_combination_setup">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                    </div>
                </div><!-- end card header -->


                <div class="card-body">

                    <form method="GET" action="{{ url('admin/segment_combination_setup') }}" accept-charset="UTF-8"
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
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Segment Combination Code</th>
                                <th>Segment Structure Code</th>
                                <th>Client</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($segment_combination_setup as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->seg_comb_code }}</td>
                                    <td>{{ $item->structure_code }}</td>
                                    <td>{{ $item->client->company_name ?? '' }}</td>

                                    <td>
                                        <a href="{{ url('admin/segment_combination_setup/' . $item->id . '/edit') }}"
                                           title="Edit segment_combination_setup">
                                            <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                                      aria-hidden="true"></i> Edit
                                            </button>
                                        </a>

                                        <form method="POST"
                                              action="{{ url('admin/segment_combination_setup' . '/' . $item->id) }}"
                                              accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    title="Delete segment_combination_setup"
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
                            class="pagination-wrapper"> {!! $segment_combination_setup->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
