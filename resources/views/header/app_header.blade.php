<!-- begin::Header -->

<div class="m-header__top">
    <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- begin::Brand -->
            <div class="m-stack__item m-brand">
                <div class="m-stack m-stack--ver m-stack--general m-stack--inline">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{url('/users')}}" class="m-brand__logo-wrapper">
                            <img alt="" src="{{ url('public/assets/demo/demo5/media/img/logo/FastIndexLogo.png')}}"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!--<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-left m-dropdown--align-push" m-dropdown-toggle="click" aria-expanded="true">
                        
                        <!-- begin::Responsive Header Menu Toggler-->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- end::Responsive Header Menu Toggler-->
                        <!-- begin::Topbar Toggler-->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
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

                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__welcome">
                                        Hello,&nbsp;
                                    </span>
                                    <span class="m-topbar__username text-warning">
                                        {{Auth::user()->name}}
                                    </span>
                                    <span class="m-topbar__userpic">
                                        @if(empty(Auth::user()->avatar))
                                        <img src="{{url('public/assets/app/media/img/users/user4.jpg')}}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
                                        @else
                                        <img src="{{asset('storage/app/profile/'.Auth::user()->avatar)}}" class="m--img-rounded m--marginless m--img-centered" alt="">
                                        @endif 
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">

                                        <div class="m-dropdown__header m--align-center" style="background: url({{url('public/assets/app/media/img/misc/user_profile_bg.jpg')}}); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark">

                                                <div class="m-card-user__pic">
                                                    @if(empty(Auth::user()->avatar))
                                                    <img src="{{url('public/assets/app/media/img/users/user4.jpg')}}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
                                                    @else
                                                    <img src="{{asset('storage/app/profile/'.Auth::user()->avatar)}}" class="m--img-rounded m--marginless m--img-centered" alt="">
                                                    @endif 
                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">
                                                        {{Auth::user()->name}}
                                                    </span>
                                                    <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                                        {{Auth::user()->email}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__section m--hide">
                                                        <span class="m-nav__section-text">
                                                            Section
                                                        </span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{ url('/myprofile')}}" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                            <span class="m-nav__link-title">
                                                                <span class="m-nav__link-wrap">
                                                                    <span class="m-nav__link-text">
                                                                        My Profile
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('logout')}}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                            Logout
                                                        </a>
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

<!-- end::Header -->