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
                            <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center  m-dropdown--mobile-full-width" data-dropdown-toggle="click" data-dropdown-persistent="true">
                                <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                    <span class="m-nav__link-badge m-badge--danger badge badge-light total_notification"></span>
                                    <span class="m-nav__link-icon">
                                        <span class="m-nav__link-icon-wrapper">
                                            <i class="flaticon-music-2"></i>
                                        </span>
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                    <div class="m-dropdown__inner">

                                        <div class="m-dropdown__header m--align-center" style="background:  url({{url('public/assets/app/media/img/misc/notification_bg.jpg')}}); background-size: cover;">
                                            <span class="m-dropdown__header-title total_notification">

                                            </span>
                                            <span class="m-dropdown__header-subtitle">
                                                User Notifications
                                            </span>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                                                    <li class="nav-item m-tabs__item">
                                                        <button type="button" class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" onclick="markNotificationRead()">
                                                            Mark as Read
                                                        </button>
                                                        <a class="nav-link m-tabs__link active notification-color" data-toggle="tab" href="#topbar_notifications_notifications" >
                                                            Notifications
                                                        </a>

                                                    </li>
                                                    <li class="nav-item m-tabs__item">

                                                    </li> 
                                                   <li class="nav-item m-tabs__item">
                                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_request">
                                                            Friend Request
                                                        </a>
                                                    </li> 
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                                                        <div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                                                            <div class="m-list-timeline m-list-timeline--skin-light">
                                                                <div class="m-list-timeline__items notify_data">
                                                                    <div class="m-list-timeline__item">
                                                                        <span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
                                                                        <span class="m-list-timeline__text">
                                                                            No Notification Found
                                                                        </span>
                                                                       <!--  <span class="m-list-timeline__time">
                                                                            Just now
                                                                        </span> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="tab-pane" id="topbar_request" role="tabpanel" aria-expanded="false">
                                                        <div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                                                            <div class="m-list-timeline m-list-timeline--skin-light">
                                                                <div class="m-list-timeline__items request_data">
                                                                    <div class="m-list-timeline__item">
                                                                        <span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
                                                                        <span class="m-list-timeline__text">
                                                                            No Request Found
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__welcome">
                                        Welcome,&nbsp;
                                    </span>
                                    <span class="m-topbar__username text-warning">
                                        {{Auth::user()->name}}
                                    </span>
                                    <span class="m-topbar__userpic test">
                                      
                                        @if(isset($user->instructor_avatar) && $user->instructor_avatar !='')
                                        <img src="{{asset('storage/'.$user->instructor_avatar)}}" class="img-responsive user_img">
                                        @elseif(isset($images['images']) && !empty($images['images']))
                                        <img src="{{asset('storage/app/levelavatar/'.$images['dir']['subdir'].'/'.$images['images'][0])}}" class="img-responsive m--img-rounded m--marginless m--img-centered" alt="my profile">
                                        @else
                                        <img src="{{url('public/assets/demo/demo5/media/img/user.svg')}}" class="img-responsive m--img-rounded m--marginless m--img-centered" alt="my profile">
                                        @endif
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
                                                    @if(Auth::user()->user_type=='3')
                                                    <li class="m-nav__item">
                                                        <a href="{{url('/manage_request/1')}}" class="m-nav__link">                        
                                                            <span class="m-nav__link-text">
                                                                My Parents
                                                            </span>
                                                            <i class="m-nav__link-icon flaticon-avatar">
                                                            </i>
                                                        </a>
                                                    </li> 
                                                    @endif
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