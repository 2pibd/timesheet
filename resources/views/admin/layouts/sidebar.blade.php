
<script>
    $(function() {
        function filterMenu(term) {
            var filter, input = term.toUpperCase();
            $(".nav a").each(function(i, el) {
                filter = $(el).text().toUpperCase();

                if (filter.indexOf(input) < 0   ) {

                    $(el).parent().hide();

                }else $(el).parent().closest('.dk').parent().find('.auto').parent().show()

            });

        }

        $("#txt_search").keyup(function(event) {
            // Show all Items
            $(".nav li").show();
            // If Empty, do nothing
            if ($(this).val() !== "") {
                // Filter out items that do not match
                filterMenu($(this).val().toUpperCase());
            }
        });
    });
</script>

<aside id="aside" class="app-aside hidden-xs bg-blue left-panel">
    <div class="aside-wrap">
        <style>
            .left-panel{
                overflow-y: scroll;
                float:left;
                height:calc(100vh - 60px);
            }

           .navi .active{
               background-color: #0a58ca;
           }
        </style>
        <div class="navi-wrap" >
            <!-- nav -->
            <nav ui-nav class="navi clearfix">
                <ul class="nav">
                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                        <div class="input-group">
                            <input type="text"   id="txt_search" class="form-control input-sm bg-light no-border rounded padder" placeholder="Search menu...">
                            <span class="input-group-btn">
                <button type="submit" class="btn btn-sm bg-light rounded"><i class="fa fa-search"></i></button>
              </span>
                        </div>

                    </li>
                    {{--   <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                         <span>Navigation</span>
                     </li>

                        <li class="line dk"></li>
               {{-- <li>
                          <a href="{{ url('admin') }}" class="auto">
                              <i class="glyphicon glyphicon-stats icon text-primary-dker"></i>
                              <span class="font-bold">Dashboard</span>
                          </a>
                      </li>--}}



                    @php
                        $section[0] = '';
                        $section[1] = 'Site Data';
                        $section[2] = 'Settings';


                            $mainMenu = App\Models\Setting::loadMainMenu();
                            $userMenu = App\Models\Setting::loadUserMenu();

                           $classArr = array(); $activeClass = '';

                    @endphp
                    @foreach($section as $skey=>$sItem)

                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span>{{$sItem}}</span>
                        </li>
                        @foreach ($userMenu[0] as  $key=>$value)

                            @if(!empty($userMenu[$value]) &&  array_key_exists($value,$mainMenu))
                                @foreach ($userMenu[$value] as  $key2=>$classval)
                                    @if(( !empty($mainMenu[$classval]['route']) ))
                                        @php $classArr = explode('.', $mainMenu[$classval]['route'] );
                                    if( $classArr[0]  == Request::segment(1) )
                                    $activeClass =   'class=active';

                                        @endphp
                                    @endif

                                @endforeach

                                <?php

                                //echo '<pre>';
                                //print_r($mainMenu);
                                // exit;
                                ?>


                                     <li {{ $activeClass }} >
                                         @if($skey == $mainMenu[$value]['admin_left_section'])
                                        <a href="javascript:;" class="auto">
                                                  <span class="pull-right text-muted">
                                                      <i class="fa fa-fw fa-angle-right text"></i>
                                                      <i class="fa fa-fw fa-angle-down text-active"></i>
                                                  </span>
                                            <i class="{{ $mainMenu[$value]['icon'] ?? '' }}"></i>
                                            <span>{{ $mainMenu[$value]['title'] ?? '' }}</span>
                                        </a>
                                        <ul class="nav nav-sub dk">
                                            @foreach ($userMenu[$value] as  $key3=>$subvalue)
                                                @if(!empty($mainMenu[$subvalue]['title']))
                                                    <li  {{ ($mainMenu[$subvalue]['route'] == Request::segment(1)) ? $activeClass : '' }}>
                                                        <a href="{{ url($mainMenu[$subvalue]['route']) ?? '' }}"> <span>
                                                         <i class="{{ $mainMenu[$subvalue]['icon'] ?? ''}}"></i> {{ $mainMenu[$subvalue]['title'] ?? ''}}  </span></a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                         @endif
                                        @elseif(  array_key_exists($value,$mainMenu))
                                    @if($skey == $mainMenu[$value]['admin_left_section'])
                                        <li>
                                            <a href="{{ url($mainMenu[$value]['route']) ?? '' }}"><i class="{{ $mainMenu[$value]['icon'] }}"></i> <span>    {{ $mainMenu[$value]['title'] ?? '' }}</span></a>
                                        </li>
                                    @endif
                                    @endif </li>

                                @php
                                    $activeClass = '';
                                @endphp

                                @endforeach
                                @endforeach

                </ul>
            </nav>


            <!-- / aside footer -->
        </div>
    </div>
</aside>
