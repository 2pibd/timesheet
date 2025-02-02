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
            @lang('translation.webmaster')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Webmaster</h4>
                    <div class="flex-shrink-0">

                    </div>
                </div><!-- end card header -->
                <div class="card-body">


                    <div class="row">
                        <div class="col-md-2 bg-light  p-0">
                            <div class="nav flex-column nav-pills text-left" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link mb-2 active" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="true">Settings</a>
                                <a class="nav-link mb-2" id="v-pills-seo-tab" data-bs-toggle="pill" href="#v-pills-seo" role="tab" aria-controls="v-pills-seo" aria-selected="false">SEO Settings</a>
                                <a class="nav-link mb-2" id="v-pills-mail-settings-tab" data-bs-toggle="pill" href="#v-pills-mail-settings" role="tab" aria-controls="v-pills-mail-settings" aria-selected="false">Mail Settings</a>
                                <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">RESTful API</a>
                                <a class="nav-link" id="v-pills-contacts-tab" data-bs-toggle="pill" href="#v-pills-contacts" role="tab" aria-controls="v-pills-contacts" aria-selected="false">Contacts</a>
                                <a class="nav-link" id="v-pills-notification-tab" data-bs-toggle="pill" href="#v-pills-notification" role="tab" aria-controls="v-pills-notification" aria-selected="false">Notification Settings</a>
                                <a class="nav-link" id="v-pills-social-links-tab" data-bs-toggle="pill" href="#v-pills-social-links" role="tab" aria-controls="v-pills-social-links" aria-selected="false">Social Links</a>
                                <a class="nav-link" id="v-pills-website-status-tab" data-bs-toggle="pill" href="#v-pills-website-status" role="tab" aria-controls="v-pills-website-status" aria-selected="false">Website Status</a>
                            </div>
                        </div><!-- end col -->
                        <div class="col-md-10   border-start">
                            <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                     @include('admin.settings.general')
                                </div>


                                <div class="tab-pane fade" id="v-pills-seo" role="tabpanel" aria-labelledby="v-pills-seo-tab">
                                    @include('admin.settings.seo')
                                </div>


                                <div class="tab-pane fade" id="v-pills-mail-settings" role="tabpanel" aria-labelledby="v-pills-mail-settings-tab">
                                    @include('admin.settings.mail-settings')
                                </div>


                                <div class="tab-pane fade" id="v-pills-restful_api" role="tabpanel" aria-labelledby="v-pills-restful_api-tab">
                                    @include('admin.settings.restful_api')
                                </div>


                                <div class="tab-pane fade" id="v-pills-contacts" role="tabpanel" aria-labelledby="v-pills-contacts-tab">
                                    @include('admin.settings.contacts')
                                </div>


                                <div class="tab-pane fade" id="v-pills-notification" role="tabpanel" aria-labelledby="v-pills-notification-tab">
                                    @include('admin.settings.notification')
                                </div>

                                <div class="tab-pane fade" id="v-pills-social-links" role="tabpanel" aria-labelledby="v-pills-social-links-tab">
                                    @include('admin.settings.social_links')
                                </div>

                                <div class="tab-pane fade" id="v-pills-website-status" role="tabpanel" aria-labelledby="v-pills-website-status-tab">
                                    @include('admin.settings.website_status')
                                </div>


                            </div>
                        </div><!--  end col -->
                    </div>



            </div>

        </div>
    </div>

@endsection
