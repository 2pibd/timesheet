@extends('admin.layouts.master')

@section('content')

    <div class="wrapper-md">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-10">
                        <p class="m-n font-thin h3">Single Roll</p>
                    </div>
                    @can('create-role')
                        <div class="col-md-2">
                            <a href="{{route('role.create')}}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-plus"></i>&nbsp;&nbsp;Create New Roll</a>
                        </div>
                    @endcan
                </div>
            </div>

            <div class="panel-body">

                @can('view-role')
                    <a href="{{ route('role.index') }}" title="Back">
                        <button class="btn btn-info btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                        </button>
                    </a>
                @endcan
                @can('update-role')
                    <a href="{{ route('role.edit', $role->id) }}" title="Edit Role">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                        </button>
                    </a>
                @endcan
                @can('delete-role')
                    <form method="POST" action="{{ route('role.destroy', $role->id) }}" accept-charset="UTF-8"
                          style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Role"
                                onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash"
                                                                                         aria-hidden="true"></i> Delete
                        </button>
                    </form>
                @endcan
            </div>
            <div class="panel-body">
                <div class="col-md-6 col-md-offset-3 col-xs-12">
                    <div class="table-responsive">
                        <table id="pattern-type-data" class="table">
                            <tbody>
                            <tr>
                                <th> Name</th>
                                <td> {{ $role->name }} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
