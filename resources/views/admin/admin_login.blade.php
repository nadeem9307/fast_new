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
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
WebFont.load({
    google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
    active: function () {
        sessionStorage.fonts = true;
    }
});
        </script>
        <!--end::Web font -->
        <!--begin::Base Styles -->
        <link href="{{ url('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{ url('public/assets/demo/default/media/img/logo/favicon.ico')}}" />
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login">
                <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
                    <div class="m-stack m-stack--hor m-stack--desktop">
                        <div class="m-stack__item m-stack__item--fluid">
                            <div class="m-login__wrapper">
                                <div class="m-login__logo">
                                    <a href="#">
                                        <img src="{{ url('public/assets/app/media/img//logos/logo-2.png')}}">
                                    </a>
                                </div>
                                <div class="m-login__signin">
                                    <div class="m-login__head">
                                        <h3 class="m-login__title">
                                            Sign In To Admin

                                        </h3>
                                    </div>

                                    <form class="m-login__form m-form" action="{{ route('userLogin')}}" method="POST">
                                        {{ csrf_field() }}
                                        @if(Session::has('message'))
                                        <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                                        @endif
                                        <div class="form-group m-form__group {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
                                            @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group m-form__group {{ $errors->has('password') ? ' has-error' : '' }}">
                                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
                                            @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="row m-login__form-sub">
                                            <div class="col m--align-left">
                                                <label class="m-checkbox m-checkbox--focus">
                                                    <input type="checkbox" name="remember">
                                                    Remember me
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="col m--align-right">
                                                <a href="javascript:;" id="m_login_forget_password" class="m-link">
                                                    Forget Password ?
                                                </a>
                                            </div>
                                        </div>
                                        <div class="m-login__form-action">
                                            <button type="submit" id="login" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                                Sign In
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="m-login__signup">
                                    <div class="m-login__head">
                                        <h3 class="m-login__title">
                                            Sign Up
                                        </h3>
                                        <div class="m-login__desc">
                                            Enter your details to create your account:
                                        </div>
                                    </div>
                                    <form class="m-login__form m-form" action="">
                                        <div class="form-group m-form__group">
                                            <input class="form-control m-input" type="text" placeholder="Fullname" name="fullname">
                                        </div>
                                        <div class="form-group m-form__group">
                                            <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
                                        </div>
                                        <div class="form-group m-form__group">
                                            <input class="form-control m-input" type="password" placeholder="Password" name="password">
                                        </div>
                                        <div class="form-group m-form__group">
                                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">
                                        </div>
                                        <div class="row form-group m-form__group m-login__form-sub">
                                            <div class="col m--align-left">
                                                <label class="m-checkbox m-checkbox--focus">
                                                    <input type="checkbox" name="agree">
                                                    I Agree the
                                                    <a href="#" class="m-link m-link--focus">
                                                        terms and conditions
                                                    </a>
                                                    .
                                                    <span></span>
                                                </label>
                                                <span class="m-form__help"></span>
                                            </div>
                                        </div>
                                        <div class="m-login__form-action">
                                            <button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                                Sign Up
                                            </button>
                                            <button id="m_login_signup_cancel" class="btn btn-outline-focus  m-btn m-btn--pill m-btn--custom">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="m-login__forget-password">
                                    <div class="m-login__head">
                                        <h3 class="m-login__title">
                                            Forgotten Password ?
                                        </h3>
                                        <div class="m-login__desc">
                                            Enter your email to reset your password:
                                        </div>
                                    </div>
                                    <form class="m-login__form m-form" action="{{ route('login.password.email')}}">
                                        @if(Session::has('emailvereify'))
                                        <div class="m-alert m-alert--outline alert alert-success alert-dismissible animated fadeIn" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                            <span>{{ Session::get('emailvereify') }}</span>
                                        </div>
                                         @endif
                                        <div class="form-group m-form__group">
                                            <input class="form-control m-input" type="email" placeholder="Email" name="email" id="m_email" autocomplete="off">
                                        </div>
                                        <div class="m-login__form-action">
                                            <button id="m_login_forget" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                                Request
                                            </button>
                                            <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <!--<div class="m-stack__item m-stack__item--center">
                   <div class="m-login__account">
                            <span class="m-login__account-msg">
                                Don't have an accoun                       t yet ?
                                                       </span>
                                                    &nbsp;&nbsp;
                                        <a href="javascript:;" id="m_login_signup" class="m-link m-link                           --focus m-login__account-link">
                                   Sign                    Up
                                               </a>
                                                  </div>
                              </div>--->
                    </div>
                </div>
                <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url(public/assets/app/media/img//bg/bg-4.jpg)">
                    <div class="m-grid__item m-grid__item--middle">
                        <h3 class="m-login__welcome">
                            Join Our Community
                        </h3>
                        <p class="m-login__msg">
                            Lorem ipsum dolor sit amet, coectetuer adipiscing
                            <br>
                            elit sed diam nonummy et nibh euismod
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!--                end:: Page -->
        <!--                begin::Base Scripts -->
        <script src="{{ url('public/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/assets/demo/demo5/base/scripts.bundle.js')}}" type="text/javascript"></script>
        <!--end::Base Scripts -->   
        <!--begin::Page Snippets -->
        <script src="{{ url('public/assets/snippets/custom/pages/user/login.js')}}" type="text/javascript"></script>
        <!--end::Page Snippets -->
</body>
<!-- end::Body -->
</html>
