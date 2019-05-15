<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="{{ app()->getLocale() }}" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            @yield('page_title')
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--begin::Web font -->
        <script src="{{ url('public/js/webfont.js')}}"></script>

        <script>
WebFont.load({
    google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
    active: function () {
        sessionStorage.fonts = true;
    }
});
        </script>
        <script>
            var APP_URL = {!! json_encode(url('/')) !!}
        </script>
        <!--end::Web font -->
        <!--begin::Base Styles -->  
        <!--begin::Page Vendors -->
        <link href="{{ url('public/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Page Vendors -->
        <link href="{{ url('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/demo/demo5/homebase/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{url('public/assets/demo/demo5/base/admin_custom.css')}}" />
        <link href="{{ url('public/css/sweetalert.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{ url('public/assets/demo/demo5/media/img/logo/favicon.png')}}" />
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body  class="m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default"  >
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            <header id="m_header" class="m-grid__item m-header "  m-minimize="minimize" m-minimize-offset="200" m-minimize-mobile-offset="200" >
                @include('header.app_header')
                <!-- END: Sidebar -->
                @include('header.app_sidebar')
                <!-- END: Sidebar -->
            </header>
            <!-- END: Header -->		
            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop 	m-container m-container--responsive m-container--xxl m-page__container m-body">
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <!-- BEGIN: Content -->
                    @yield('content')
                    <!-- BEGIN: Content -->
                </div>
            </div>
            <!-- end::Body -->
        </div>
        <!-- end:: Page -->
      
        <!--begin::Base Scripts -->
<!--        <script src="{{ url('public/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/assets/demo/demo5/homebase/scripts.bundle.js')}}" type="text/javascript"></script>-->
        
         <script src="{{ url('public/assets/library/admin_vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/assets/library/admin_scripts.bundle.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/js/sweetalert.min.js')}}"></script>
        <script type="text/javascript">
            $(".number").keydown(function (event) {
            if (event.shiftKey) {
                event.preventDefault();
            }

            if (event.keyCode == 46 || event.keyCode == 8) {
            }
            else {
                if (event.keyCode < 95) {
                    if (event.keyCode < 48 || event.keyCode > 57) {
                        event.preventDefault();
                    }
                }
                else {
                    if (event.keyCode < 96 || event.keyCode > 105) {
                        event.preventDefault();
                    }
                }
            }
            });
        </script>
        <!--end::Page Snippets -->
        @yield('page_script')
    </body>
    <!-- end::Body -->
</html>
