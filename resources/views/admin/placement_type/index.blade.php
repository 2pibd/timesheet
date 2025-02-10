@extends('admin.layouts.master')
@section('title')
    Placement Type
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Placement Type
        @endslot
    @endcomponent




    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"> Placement Type</h4>

                    <div class="flex-shrink-0">
                        @can('create-placement_type')
                            <a href="{{route('placement_type.create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan



                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @if (session()->has('flash_message'))
                        <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-emerald-500">
                            <span class="inline-block align-middle mr-8">
                                {{ session('flash_message') }}
                            </span>
                            <button class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none" onclick="this.parentNode.parentNode.removeChild(this.parentNode);">
                                <span>×</span>
                            </button>
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Title</th><th scope="col" class="px-6 py-3">Section</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($placement_type as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $item->title }}</td><td class="px-6 py-4">{{ $item->section }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('placement_type.show', $item->id) }}" title="View placement_type"><button type="button" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-1 px-2 rounded">View</button></a>
                                    <a href="{{ route('placement_type.edit', $item->id) }}" title="Edit placement_type"><button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Edit</button></a>

                                    <form method="POST" action="{{ route('placement_type.destroy', $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                        {{ method_field('DELETE') }}
                                        @csrf()
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" title="Delete placement_type" onclick="return confirm(&quot;Confirm delete?&quot;)">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {!! $placement_type->appends(['search' => Request::get('search')])->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
