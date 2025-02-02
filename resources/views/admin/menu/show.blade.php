@extends('admin.layouts.master')

@section('content')

    <div class="wrapper-md">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-10">
                        <p class="m-n font-thin h3">Details of  menu </p>
                    </div>
                    <div class="col-md-2">
                        @can('create-menu')
                            <a href="{{route('menu.create')}}" class="btn btn-primary btn-sm">
                            <i  class="fa fa-plus"></i>&nbsp;Create New menu</a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="panel-body">
                @can('view-menu')
                    <a href="{{ route('menu.index') }}" title="Back">
                        <button class="btn btn-info btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                        </button>
                    </a>
                @endcan
                @can('update-menu')
                    <a href="{{ route('menu.edit', $menu->id) }}" title="Edit Role">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                        </button>
                    </a>
                @endcan
                @can('delete-menu')
                    <form method="POST" action="{{ route('menu.destroy', $menu->id) }}" accept-charset="UTF-8"
                          style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete $menu"
                                onclick="return confirm('Are You Sure To Delete This menu?';)"><i class="fa fa-trash-o"
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

                                <tr><th> Title </th><td> {{ $menu->title }} </td></tr><tr><th> Parent Id </th><td> {{ $menu->parent_id }} </td></tr><tr><th> Expense Date </th><td> {{ $menu->expense_date }} </td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
