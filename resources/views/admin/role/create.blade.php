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
                    <h4 class="card-title mb-0 flex-grow-1">Create Role</h4>
                    <div class="flex-shrink-0">

                        <a href="{{route('role.index')}}" class="btn btn-info btn-sm"><i
                                class="fa fa-list-ul"></i>&nbsp;&nbsp;All Roll</a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">



                <div class="panel-body">
                    <style type="text/css">
                        ul, #myUL {
                            list-style-type: none;
                        }

                        #myUL {
                            margin: 0;
                            padding: 0;
                        }


                        .box {
                            cursor: pointer;
                            -webkit-user-select: none; /* Safari 3.1+ */
                            -moz-user-select: none; /* Firefox 2+ */
                            -ms-user-select: none; /* IE 10+ */
                            user-select: none;
                        }

                        /*.box:nth-of-type(1)::before
                        {
                            content: " ";
                            color: blue;
                            display: inline-block;
                            margin-right: 6px;
                        }*/

                        .box::before {
                            content: "+";
                            color: black;
                            display: inline-block;
                            margin-left: -10px;
                        }

                        .check-box::before {
                            content: "-";
                            margin-left: -7px;
                        }

                        .nested {
                            display: none;
                        }

                        .active {
                            display: block;
                        }
                    </style>

                    <div class="col-md-12 table-responsive">
                        <form action="{{ route('role.store') }}" method="POST">

                            {{ csrf_field() }}

                                <table class="table table-bordered">
                                    <tr>
                                        <td width="25%">
                                            <label for="name" class=" col-form-label">Name</label>
                                        </td>
                                        <td>

                                            <input class="form-control" name="name" placeholder="Provide Role Name"
                                                   type="text"
                                                   id="name" value="{{ $role->name ?? ''}}" required>
                                            {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <label for="name" class="col-form-label">Select Group</label>
                                        </td>
                                        <td>
                                            <select class="form-select" name="user_role_group_id" id="user_role_group_id" required>
                                                @foreach($user_role_group as $key=>$value)
                                                    <option value="{{$value->id}}" @if(isset($role) && $role->user_role_group_id == $value->id) selected="selected" @endif >{{$value->group_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="sort_access_no" class=" col-form-label">Sort Order</label>
                                        </td>
                                        <td>
                                            <input class="form-control" name="sort_access_no" placeholder="Role Sort Order"
                                                   type="number"
                                                   id="sort_access_no" value="{{ $role->sort_access_no ?? ''}}" required>
                                            {!! $errors->first('sort_access_no', '<small class="text-danger">:message</small>') !!}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <label>Permissions</label>
                                        </td>
                                        <td>
                                            <ul id="myUL">
                                                {!! Helper::createTreeView($menus, 0, $rolePermissions, $AllPermission);  !!}

                                            </ul>
                                            <script type="text/javascript">
                                                var toggler = document.getElementsByClassName("box");
                                                for (var i = 0; i < toggler.length; i++) {
                                                    toggler[i].addEventListener("click", function () {
                                                        if (this.parentElement.querySelector(".nested") != null) {
                                                            this.parentElement.querySelector(".nested").classList.toggle("active");
                                                            this.classList.toggle("check-box");
                                                        }
                                                    });
                                                }
                                            </script>
                                        </td>
                                    </tr>

                                </table>

                                <div class="form-group">
                                    <div class="text-end">
                                        <input class="btn btn-primary" type="submit" value="Submit">
                                    </div>
                                </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

