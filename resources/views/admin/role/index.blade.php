@extends('admin.layouts.master')
@section('title')
    @lang('translation.role')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            @lang('translation.role')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">All Role</h4>
                    <div class="flex-shrink-0 d-flex">



                        @can('create-role')
                        <a href="{{route('role.create')}}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;Create New Roll</a>
                            @endcan
                    </div>
                </div><!-- end card header -->
                <div class="card-body">

                    <div class="d-flex mb-3">
                        <div class="  ">
                            @can('create-role')
                                <form method="get" action="{{$_SERVER['REQUEST_URI']}}" class="navbar-form navbar-form-sm navbar-left shift" ui-shift="prependTo" data-target=".navbar-collapse" role="search" ng-controller="TypeaheadDemoCtrl">
                                    <select class="form-select bg-light no-border rounded" name="user_role_group_id" id="user_role_group_id" onchange="javascript:submit()" >
                                        <option value="">Select All</option>
                                        @foreach($user_role_group as $key=>$value)
                                            <option value="{{$value->id}}" @if(request()->user_role_group_id == $value->id) selected @endif>{{$value->group_name}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('user_role_group_id', '<small class="text-danger">:message</small>') !!}
                                </form>
                            @endcan
                        </div>



                        <div class=" ">
                        @can('create-role')
                            <!-- search form -->
                                <form method="get" action="{{$_SERVER['REQUEST_URI']}}" class="navbar-form navbar-form-sm navbar-left shift" ui-shift="prependTo" data-target=".navbar-collapse" role="search" ng-controller="TypeaheadDemoCtrl">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="searchkey" ng-model="selected" typeahead="state for state in states | filter:$viewValue | limitTo:8" class="form-control input-sm bg-light no-border rounded padder" placeholder="Search projects...">
                                            <span class="input-group-btn">
                <button type="submit" class="btn   bg-light rounded"><i class="fa fa-search"></i></button>
              </span>
                                        </div>
                                    </div>
                                </form>
                        @endcan
                        <!-- / search form -->
                        </div>

                    </div>

                <table id="pattern-type-data" ui-jq="dataTable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width:10%">#</th>
                        <th style="width:25%">Name</th>
                        <th style="width:15%">Group</th>
                        <th style="width:15%">Sort Access SI.</th>
                        <th style="width:10%">Created At</th>
                        <th style="width:25%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->user_role_group->group_name ?? '' }}</td>
                            <td><input type="number" value="{{ $role->sort_access_no }}" data-id="{{ $role->id }}"
                                       class="form-control sortaccess"></td>
                            <td>{{ date('d-m-Y', strtotime($role->created_at)) }}</td>
                            <td>
                                @can('update-role')
                                    <a href="{{ route('role.edit' , $role->id  ) }}" title="Edit Role">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp;Edit</button>
                                    </a>
                                @endcan
                                @can('delete-role')
                                    <form method="POST" action="{{ route('role.destroy' ,$role->id) }}"
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
        </div>
    </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.sortaccess').change(function () {
                id = $(this).data('id')
                sortid = $(this).val()

                $.ajax({
                    url: "{{URL::to('admin/update-sortaccess')}}",
                    dataType: "text",
                    type: 'POST',
                    data: {'_token': $('meta[name=csrf-token]').attr('content'), 'id': id, 'sortid': sortid },
                    success: function (data) {
                        $.snackbar({content: data, timeout: 10000});
                    }
                })

            })
        })
    </script>
@endsection
