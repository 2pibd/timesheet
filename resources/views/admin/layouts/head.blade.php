<meta charset="utf-8"/>
<title>@yield('title')</title>
<meta name="description" content="{{ @Helper::GeneralSiteSettings("site_desc_".@Helper::currentLanguage()->code) }}"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
<link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">
<meta name="apple-mobile-web-app-title" content="{{ Helper::GeneralWebmasterSettings('company_name') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="mobile-web-app-capable" content="yes">
<link rel="shortcut icon" sizes="196x196" href="{{ asset('assets/images/logo.png') }}">
@stack('before-styles')
 <link rel="stylesheet" href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}?v={{ @Helper::system_version() }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}?v={{ @Helper::system_version() }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}?v={{ @Helper::system_version() }}"
      type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}?v={{ @Helper::system_version() }}"
      type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}?t=255656">
<link rel="stylesheet" href="{{ asset('assets/css/custom.min.css') }}?v={{ @Helper::system_version() }}"
      type="text/css"/>
<!-- Layout config Js -->
<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>

<link rel="stylesheet" href="{{ asset('fonts/font-awesome/css/font-awesome.min.css') }}?v={{ Helper::system_version() }}"
      type="text/css"/>
<link rel="stylesheet" href="{{ asset('fonts/material-design-icons/material-design-icons.css') }}?v={{ Helper::system_version() }}"
      type="text/css"/>

<link href="{{asset('/plugins/fontawesome5pro/css/all.min.css')}}" rel="stylesheet"/>
<link href="{{asset('/plugins/fontawesome6/css/all.min.css')}}" rel="stylesheet"/>
<link rel="stylesheet" href="{{asset('/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('fonts/glyphicons/glyphicons.css') }}?v={{ Helper::system_version() }}" type="text/css"/>
@stack('after-styles')
