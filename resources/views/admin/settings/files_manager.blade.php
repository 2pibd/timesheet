@extends('admin.layouts.master')
@section('title')
    @lang('translation.filenmanager')
@endsection

@component('admin.components.breadcrumb')
    @slot('li_1')
        Settings
    @endslot
    @slot('title')
        File Manager
    @endslot
@endcomponent

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">File Manager</h4>
                    <div class="flex-shrink-0">

                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <link href="{{ asset('assets/file-manager/css/file-manager.css') }}" rel="stylesheet">
                    <style>
                        .fm-navbar div div div:last-child {
                            display: none;
                        }

                        iframe {
                            width: 100%;
                            height: 700px;
                        }
                    </style>

                    <div class="padding" style="padding-bottom: 0">
                        <div class="box" style="padding-bottom: 0">

                            <div class="white dk">
                                <iframe src="{{ route("FilesManager") }}"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


