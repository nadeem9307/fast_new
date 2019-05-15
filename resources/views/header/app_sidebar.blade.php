<div class="m-header__bottom">
    <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- begin::Horizontal Menu -->
            <div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
                    <i class="la la-close"></i>
                </button>
                <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
                    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                        @if(Route::currentRouteName() === "admin_dashboard")
                        <li class="m-menu__item  m-menu__item--active "  aria-haspopup="true">
                            @else
                        <li class="m-menu__item  m-menu__item" aria-haspopup="true" >
                            @endif
                            <a  href="{{url('/home')}}" class="m-menu__link ">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Dashboard
                                </span>

                            </a>
                        </li>
                        @if(Route::currentRouteName() === "allcountry")
                        <li class="m-menu__item  m-menu__item--active "  aria-haspopup="true">
                            @else
                        <li class="m-menu__item  m-menu__item" aria-haspopup="true" >
                            @endif
                            <a  href="{{url('/countries')}}" class="m-menu__link ">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Countries
                                </span>
                            </a>
                        </li>
                        @if(Route::currentRouteName() === "getusers")
                        <li class="m-menu__item  m-menu__item--active "  aria-haspopup="true">
                            @else
                        <li class="m-menu__item  m-menu__item" aria-haspopup="true" >
                            @endif
                            <a  href="{{url('/users')}}" class="m-menu__link ">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Users 
                                </span>
                            </a>
                        </li>
                        
                       @if(Route::currentRouteName() === "category")
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel m-menu__item--active"  m-menu-submenu-toggle="click" aria-haspopup="true">
                            @else
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
                            @endif
                            <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                     Categories
                                </span>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item "  aria-haspopup="true">
                                        <a  href="{{url('/parent/categories')}}" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-diagram"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Parent Categories
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item "  aria-haspopup="true">
                                        <a  href="{{url('categories')}}" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-diagram"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                         Child Categories
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        
                        @if(Route::currentRouteName() === "questionPage")
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel m-menu__item--active"  m-menu-submenu-toggle="click" aria-haspopup="true">
                            @else
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
                            @endif
                            <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                     Questions
                                </span>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item "  aria-haspopup="true">
                                        <a  href="{{url('/parent/questions')}}" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-diagram"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                        Parent Questions
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item "  aria-haspopup="true">
                                        <a  href="{{url('/questions')}}" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-diagram"></i>
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-menu__link-text">
                                                         Child Questions
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        @if(Route::currentRouteName() === "overall")
                        <li class="m-menu__item  m-menu__item--active "  aria-haspopup="true">
                            @else
                        <li class="m-menu__item  m-menu__item" aria-haspopup="true" >
                            @endif

                            <a  href="{{route('overall')}}" class="m-menu__link ">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Ranges
                                </span>
                            </a>
                        </li>
                        <!-- levels menu start -->
                        @if(Route::currentRouteName() === "levels_view")
                        <li class="m-menu__item  m-menu__item--active "  aria-haspopup="true">
                            @else
                        <li class="m-menu__item  m-menu__item" aria-haspopup="true" >
                            @endif
                            <a  href="{{route('levels_view')}}" class="m-menu__link ">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Levels
                                </span>
                            </a>
                        </li>
                        <!-- sublevels menu start -->
                        @if(Route::currentRouteName() === "sublevels_view")
                        <li class="m-menu__item  m-menu__item--active "  aria-haspopup="true">
                            @else
                        <li class="m-menu__item  m-menu__item" aria-haspopup="true" >
                            @endif
                            <a  href="{{route('sublevels_view')}}" class="m-menu__link ">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Sub Levels
                                </span>
                            </a>
                        </li>
                        <!-- Semester menu end -->
                        @if(Route::currentRouteName() === "setting")
                        <li class="m-menu__item  m-menu__item--active "  aria-haspopup="true">
                            @else
                        <li class="m-menu__item  m-menu__item" aria-haspopup="true" >
                            @endif
                            <a  href="{{route('setting')}}" class="m-menu__link ">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Settings
                                </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <!-- end::Horizontal Menu -->   
            <!--begin::Search-->
            <div class="m-stack__item m-stack__item--middle m-dropdown m-dropdown--arrow m-dropdown--large m-dropdown--mobile-full-width m-dropdown--align-right m-dropdown--skin-light m-header-search m-header-search--expandable m-header-search--skin-" id="m_quicksearch" m-quicksearch-mode="default">

                <!--begin::Search Results -->
                <div class="m-dropdown__wrapper">
                    <div class="m-dropdown__arrow m-dropdown__arrow--center"></div>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true"  data-max-height="300" data-mobile-max-height="200">
                                <div class="m-dropdown__content m-list-search m-list-search--skin-light"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Search Results -->
            </div>
            <!--end::Search-->
        </div>
    </div>
</div>