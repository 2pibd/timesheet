@extends('admin.layouts.master')
@section('title')
    @lang('translation.template_type')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Set Data
        @endslot
        @slot('title')
            @lang('translation.template_type')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('translation.template_type')</h4>
                    <div class="flex-shrink-0">
                        @can('create-role')
                            <a href="{{route('template_type.create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan
                    </div>
                </div><!-- end card header -->
                <div class="card-body">


                    <table id="pattern-type-data" ui-jq="dataTable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width:10%">#</th>
                            <th style="width:35%">Template Type</th>
                            <th style="width:25%">Status</th>
                            <th style="width:25%">Created At</th>
                            <th style="width:25%">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($template_type as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                <td nowrap>
                                    @can('update-role')
                                        <a href="{{ route('template_type.edit' , $item->id  ) }}" title="Edit Role">
                                            <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp;Edit</button>
                                        </a>
                                    @endcan
                                    @can('delete-role')
                                        <form method="POST" action="{{ route('template_type.destroy' ,$item->id) }}"
                                              accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    title="Delete Role"
                                                    onclick="return confirm('&quot;Confirm delete?&quot;')"><i
                                                    class="fa fa-trash" aria-hidden="true"></i>  &nbsp;Delete
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6">

                        <div class="pagination-wrapper"> {!! $template_type->appends(request()->query())->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
