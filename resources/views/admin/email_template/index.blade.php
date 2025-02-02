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
            @lang('translation.email_template')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('translation.email_template')</h4>

                    <div class="flex-shrink-0">
                        @can('create-email_template')
                            <a href="{{route('email_template.create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Create New</a>
                        @endcan



                    </div>
                </div><!-- end card header -->
                <div class="card-body" >
                    @livewire('email-template.data-table-email-template')



                </div>
            </div>
        </div>
    </div>



@endsection
