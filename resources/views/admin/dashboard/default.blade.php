@extends('admin.layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('content')

    @component('admin.components.breadcrumb')
        @slot('li_1')
            @lang('translation.dashboards')
        @endslot
        @slot('title')
            @lang('translation.timesheet')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card rounded-2">

                <div class="card-body">
                    <!-- start -->
                    <div class="row">

                        <div class="col-xl-2"  >
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('admin/menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-2">

                                                <i class="fas fa-3x fa-cube"></i>

                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">New Menu</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->



                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('admin/role')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-2">

                                                <i class="fas fa-3x fa-dice-d6"></i>

                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">View All Roles</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->



                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-2">
                                                <i class="fas fa-3x fa-th-list"></i>
                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">My Office</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->
                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-2">
                                                <i class="far fa-3x fa-calendar-check"></i>
                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">Escalation
                                                    Definitions</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->


                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-2">
                                                <i class="fas fa-3x  fa-file-signature"></i>

                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">Portal Terms & Conditions</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->


                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-2">
                                                <i class="fas fa-3x  fa-flag-checkered"></i>

                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">Status Flag Mappings</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->
                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-4">
                                                <i class="fas fa-3x fa-dice-d20"></i>

                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">Worker Portal Timesheet<br>Boundary Validation</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->
                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-4">
                                                <i class="fas fa-3x  fa-mail-bulk"></i>
                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">Email Template</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->

                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-4">
                                                <i class="fa-solid fa-3x fa-helicopter-symbol"></i>
                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">Frequently Asked Questions</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->


                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-4">

                                                <i class="fa-regular fa-3x fa-message"></i>

                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">Timesheet Portal Online Messages</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->

                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-4">
                                                <i class="fa-solid fa-3x fa-fan"></i>


                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">Setup Workflows</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->


                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-4">
                                                <i class="fa-brands fa-3x fa-readme"></i>


                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">Setup User Manuals</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->


                        <div class="col-xl-2">
                            <div class="card card-animate text-primary" style="background-color: #F0F5FF">
                                <div class="card-body">
                                    <a href="{{url('menu')}}"  >
                                        <div class="text-center py-3 align-items-center">
                                            <div class="avatar-sm text-center m-auto mb-4">
                                                <i class="fa-solid fa-3x  fa-bullseye"></i>
                                            </div>
                                            <div class="overflow-hidden  ">
                                                <p class="fw-medium text-primary  text-truncate mb-3">Lookup Online Users</p>

                                            </div>
                                        </div>
                                    </a>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->

                    </div>
                    <!--end-->

                </div>
            </div>
        </div>
    </div>

    <!--end row-->
@endsection

