@extends('admin.layouts.master')
@section('title')
    @lang('translation.menu')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
           Menu
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">All Menu</h4>
                    <div class="flex-shrink-0">
                        @can('create-menu')
                            <a href="{{ route('menu.create') }}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;Add New Menu</a>
                        @endcan
                    </div>
                </div><!-- end card header -->
                <div class="card-body">


                    <div class="col-md-2 pull-right mb-3">
                        @can('create-menu')
                            <form method="get" action="{{$_SERVER['REQUEST_URI']}}" onChange="javascript:submit()">
                            <select name="userType" class="form-select">
                                @foreach($roles as $key=>$value)
                                  <option value="{{$value->id}}">{{$value->name}}</option>
                                 @endforeach

                              </select>
                            </form>
                        @endcan
                    </div>


                    <div class="col-md-3  mb-3">
                    @can('create-menu')
                    <!-- search form -->
                    <form method="get" action="{{$_SERVER['REQUEST_URI']}}" class="navbar-form navbar-form-sm navbar-left shift" ui-shift="prependTo" data-target=".navbar-collapse" role="search" ng-controller="TypeaheadDemoCtrl">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="searchkey"   typeahead="state for state in states | filter:$viewValue | limitTo:8" class="form-control" placeholder="Search Menu...">
                                <span class="input-group-btn">
                <button type="submit" class="btn btn-outline-success"><i class="fa fa-search"></i></button>
              </span>
                            </div>
                        </div>
                    </form>
                    @endcan
                    <!-- / search form -->
                    </div>

           <div class="table-responsive ">
                <table id="pattern-type-data" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>

                        <th>URL</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($menus)
                    @foreach($menus as $key=>$item)
                        <tr>
                            <td>{{ $key+$menus->firstItem() }}</td>
                            <td><i class="{{ $item->icon }}"></i> {{ (!empty($item->parent_id) || $item->parent_id!=0)?$parentCatArr[$item->parent_id] . ' > ':''}} {{ $item->title }}</td>

                            <td>{{ (!empty($item->route) AND $item->route!='#')?url( $item->route ):$item->route }}</td>
                            <td>{{ $status["$item->status"] }}</td>
                            <td>
                                <a href="{{ route('menu.show', $item->id) }}" title="View Menu"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>

                                @can('update-menu')
                                    <a href="{{ route('menu.edit', $item->id) }}" title="Edit Menu"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                @endcan

                                @can('delete-menu')
                                    <form method="POST" action="{{ route('menu.destroy', $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Menu" onclick="return confirm('Are You Sure To Delete This Menu?')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
                   {!!  $menus->appends(request()->input())->links() !!}


                </div>
            </div>
        </div>
    </div>

    <!--end row-->
@endsection
