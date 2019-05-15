<div class="m-header__top">
    <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- begin::Brand -->
            <div class="m-stack__item m-brand">
                <div class="m-stack m-stack--ver m-stack--general m-stack--inline">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{url('overview')}}" class="m-brand__logo-wrapper">
                            <img alt="" class="brand_logo" src="{{url('public/assets/demo/demo5/media/img/logo/FastIndexLogo.png')}}">
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- begin::Responsive Header Menu Toggler-->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span>
                            </span>
                        </a>
                        <!-- end::Responsive Header Menu Toggler-->
                        <!-- begin::Topbar Toggler-->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more">
                            </i>
                        </a>
                        <!--end::Topbar Toggler-->
                    </div>
                </div>
            </div>
            <!-- end::Brand -->		
            <!-- begin::Topbar -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__welcome">
                                        Welcome,&nbsp;
                                    </span>
                                    <span class="m-topbar__username">
                                        {{Auth::user()->name}}
                                    </span>
                                    <span class="m-topbar__userpic">
                                        <img src="{{url('public/assets/app/media/img/users/user4.jpg')}}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust">
                                    </span>
                                    <div class="m-dropdown__inner">                    
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light"> 
                                                    <li class="m-nav__item">
                                                        <a href="{{url('profile')}}" class="m-nav__link">                        
                                                            <span class="m-nav__link-text">
                                                                My Profile
                                                            </span>
                                                            <i class="m-nav__link-icon flaticon-settings">
                                                            </i>
                                                        </a>
                                                    </li> 
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('logout') }}" class="m-nav__link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">                        
                                                            <span class="m-nav__link-text">
                                                                Logout
                                                            </span>
                                                            <i class="m-nav__link-icon la la-power-off text-danger">
                                                            </i>
                                                        </a>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> 
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end::Topbar -->
        </div>
    </div>
</div>