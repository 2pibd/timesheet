@extends('admin.layouts.master')
@section('title')
    @lang('translation.user')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            User
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">User  Details</h4>
                    <div class="flex-shrink-0">
                        @can('view-user')
                            <a href="{{ route('user.index') }}" title="Back">
                                <button class="btn btn-info btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                                </button>
                            </a>
                        @endcan
                        @can('update-user')
                            <a href="{{ route('user.edit', $user->id) }}" title="Edit Role">
                                <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    Edit
                                </button>
                            </a>
                        @endcan
                        @can('delete-user')
                            <form method="POST" action="{{ route('user.destroy', $user->id) }}" accept-charset="UTF-8"
                                  style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete $user"
                                        onclick="return confirm('Are You Sure To Delete This User?';)"><i class="fa fa-trash-o"
                                                                                                          aria-hidden="true"></i>
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div><!-- end card header -->

                <div class="card-body">

                <div class="col-md-6 col-md-offset-3 col-xs-12">
                    <div class="table-responsive">
                        <table id="pattern-type-data" class="table">
                            <tbody>

                            <tr>
                                <th> Name</th>
                                <td> {{ $user->name }} </td>
                            </tr>
                            <tr>
                                <th> Email</th>
                                <td> {{ $user->email }} </td>
                            </tr>
                            <tr>
                                <th> Phone</th>
                                <td> {{ $user->phone_no ?? '' }} </td>
                            </tr>
                            <tr>
                                <th> Address</th>
                                <td> {{ $user->address ?? '' }} </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
