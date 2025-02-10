<script>
    $(function () {
        function filterMenu(term) {
            var filter, input = term.toUpperCase();
            $(".navbar-nav a").each(function (i, el) {
                filter = $(el).text().toUpperCase();

                if (filter.indexOf(input) < 0) {

                    $(el).parent().hide();

                } else $(el).parent().closest('.dk').parent().find('.auto').parent().show()

            });

        }

        $("#txt_search").keyup(function (event) {
            // Show all Items
            $(".navbar-nav li").show();

            // If Empty, do nothing
            if ($(this).val() !== "") {
                // Filter out items that do not match
                filterMenu($(this).val().toUpperCase());
            }
        });
    });
</script>
<style>

    #navbar-nav   .active{
        background-color: #0a58ca;
        color: #FFFFFF;
    }
</style>
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">

        <a href="{{url('/')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{asset(config('webconfig.logo'))}}" alt="" height="22">
                        </span>
            <span class="logo-lg">
                            <img src="{{asset(config('webconfig.logo'))}}" alt="" height="17">
                        </span>
        </a>

        <a href="{{url('/')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{asset(config('webconfig.logo'))}}" alt="" height="22">
                        </span>
            <span class="logo-lg">
                            <img src="{{asset(config('webconfig.logo'))}}" alt="" height="17">
                        </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user  m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                    <span class="d-flex align-items-center gap-2">
                        <img class="rounded header-profile-user" src="@if (Auth::user()->photo != ''){{ URL::asset(  Auth::user()->photo) }}@else{{ URL::asset('assets/images/users/avatar-1.jpg') }}@endif"
                             alt="{{Auth::user()->name}}">
                        <span class="text-start">
                            <span class="d-block fw-medium sidebar-user-name-text">{{Auth::user()->name}}</span>
                            <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                                    class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                                    class="align-middle">{{ Auth::user()->roles()->first()->name }}</span></span>
                        </span>
                    </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Welcome Anna!</h6>
            <a class="dropdown-item" href="pages-profile.html"><i
                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="apps-chat.html"><i
                    class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Messages</span></a>
            <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Taskboard</span></a>
            <a class="dropdown-item" href="pages-faqs.html"><i
                    class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Help</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="pages-profile.html"><i
                    class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>
            <a class="dropdown-item" href="pages-profile-settings.html"><span
                    class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
            <a class="dropdown-item" href="auth-lockscreen-basic.html"><i
                    class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Lock screen</span></a>
            <a class="dropdown-item" href="auth-logout-basic.html"><i
                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle"
                                                                                         data-key="t-logout">Logout</span></a>
        </div>
    </div>



    <div id="scrollbar">
        <div class="container-fluid">


            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs  ">
              <spam>    <div class="form-icon right p-2">
                        <input type="text" id="txt_search"
                               class="form-control input-sm bg-light  border-0 rounded-pill "
                               placeholder="Search menu...">
                        <i class="fa fa-search"></i>

                    </div>
                    </spam>


                </li>


                @php
                        $section[0] = 'Menu';
                        $section[1] = 'Site Data';
                        $section[2] = 'Settings';

                        $mainMenu = App\Models\Setting::loadMainMenu();
                        $userMenu = App\Models\Setting::loadUserMenu();

                       $classArr = array(); $activeClass = '';

                @endphp


                @foreach($section as $skey=>$sItem)
                    <li class="menu-title"><span data-key="t-menu">{{$sItem}}</span></li>
                    @foreach ($userMenu[0] as  $key=>$value)

                        @if(!empty($userMenu[$value]) &&  array_key_exists($value,$mainMenu))
                            @foreach ($userMenu[$value] as  $key2=>$classval)

                                @if(( !empty($mainMenu[$classval]['route']) ))

                                    @php
                                        $classArr = explode('.', $mainMenu[$classval]['route'] );
                                        if( $classArr[0]  == Request::segment(1) )
                                        $activeClass =   'active';

                                    @endphp
                                @endif

                            @endforeach

                            <?php
                            //echo '<pre>';
                            //print_r($mainMenu);
                            // exit;
                            ?>


                            <li class="nav-item {{ $activeClass }}" >

                                @if($skey == $mainMenu[$value]['admin_left_section'])
                                    {{--    <a href="javascript:;" class="nav-link menu-link auto">
                                                      <span class="pull-right text-muted">
                                                          <i class="fa fa-fw fa-angle-right text"></i>
                                                          <i class="fa fa-fw fa-angle-down text-active"></i>
                                                      </span>
                                            <i class="{{ $mainMenu[$value]['icon'] ?? '' }}"></i>
                                            <span>{{ $mainMenu[$value]['title'] ?? '' }}</span>
                                        </a>--}}
                                    <a class="nav-link menu-link  " href="#sidebar{{$value}}"
                                       data-bs-toggle="collapse" role="button"
                                       aria-expanded="false" aria-controls="sidebar{{$value}}">

                                        <i class="ri-dashboard-2-line"></i> <span>    {{ $mainMenu[$value]['title'] ?? '' }}</span>
                                    </a>
                                    <div class="collapse menu-dropdown " id="sidebar{{$value}}">
                                        <ul class="nav nav-sm flex-column   dk">
                                            @foreach ($userMenu[$value] as  $key3=>$subvalue)
                                                @if(!empty($mainMenu[$subvalue]['title']))
                                                    <li class="">
                                                        <a class="nav-link {{ ($mainMenu[$subvalue]['route'] == Request::path()) ? 'active' : '' }}"
                                                           href="{{ url($mainMenu[$subvalue]['route']) ?? '' }}"
                                                           data-key="t-{{$mainMenu[$subvalue]['route']}}">

                                                            <span data-key="t-{{$mainMenu[$subvalue]['route']}}">
                                                                <span> {{ $mainMenu[$subvalue]['title'] ?? ''}}  </span> </a>
                                                    </li>
                                                @endif
                                            @endforeach

                                        </ul>
                                    </div>

                        @endif
                        @elseif(  array_key_exists($value,$mainMenu))
                            @if($skey == $mainMenu[$value]['admin_left_section'])

                                <li class="nav-item  ">
                                    <a class="nav-link   {{ (  $mainMenu[$value]['route']  == Request::path()) ? 'active' : '' }} menu-link auto"
                                       href="{{ url($mainMenu[$value]['route']) ?? '' }}"><i
                                            class="{{ $mainMenu[$value]['icon'] }}"></i>
                                        <span>   {{ $mainMenu[$value]['title'] ?? '' }}</span> </a>
                                </li>
                                @endif
                                @endif

                                </li>

                                @php
                                    $activeClass = '';
                                @endphp

                                @endforeach
                                @endforeach


            </ul>

        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
