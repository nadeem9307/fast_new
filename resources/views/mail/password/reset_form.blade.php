<!DOCTYPE html> 
<html lang="en" > 
    <head>
        <meta charset="utf-8" />
        <title>
            Password Reset form
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="{{url('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/assets/demo/demo5/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/assets/demo/demo5/base/custom.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{url('assets/demo/demo5/media/img/logo/favicon.png')}}" />
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body class="dashboard m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default"  >

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--singin m-login--2 m-login-2--skin-1" id="m_login" style="background:#000;">
                <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
                    <div class="m-login__container">
                        <div class="m-login__logo">
                            <a href="javascript:(0);">
                                <img src="{{url('public/assets/demo/demo5/media/img/logo/FastIndexLogo.png')}}" width="250">
                            </a>
                        </div>
                        <div class="m-password_reset_form">
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    Reset Password
                                </h3>
                                <div class="m-login__desc">
                                    Enter your details to reset your password:
                                </div>
                            </div>
                            <form class="m-login__form m-form" action="{{ url('change/password')}}" method="post" onsubmit="return validate()">
                                @csrf
                                @if(isset($userId))
                                <input class="form-control m-input" type="hidden" placeholder="" name="userId" id="userId" value="{{ $userId}}">
                                <input class="form-control m-input" type="hidden" placeholder="" name="userEmail" id="userEmail" value="{{ $userEmail}}">
                                @else
                                <input type="hidden" id="userId" name="userId" value=""/>
                                @endif
<!--                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off" value="">
                                </div>-->
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="password" placeholder="Password" id="password" name="password" value="">
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="confirmPassword" id="confirmPassword">
                                </div>
                                <div class="row form-group m-form__group m-login__form-sub">
                                    <div class="col m--align-left">
                                        
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>
                                <div class="m-login__form-action">
                                    <button id="test" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                        Submit
                                    </button>
                                    &nbsp;&nbsp;
                                    <a href="{{ url('/')}}" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Cancel</a>
<!--<button class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">-->
                                        <!--Cancel-->
                                    </button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Page -->


        <!--begin::Base Scripts -->
        <script src="{{ url('public/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/assets/demo/demo5/base/scripts.bundle.js')}}" type="text/javascript"></script>
        <!--end::Base Scripts -->   
        <!--begin::Page Snippets -->
        <script src="{{ url('public/assets/snippets/custom/pages/user/login.js')}}" type="text/javascript"></script>




    </body>
    <!-- end::Body -->
</html>
<script>
                                function validate() {
                                    var password = $("#password").val();
                                    var confirm_password = $("#confirmPassword").val();
                                    if (password == '' || confirm_password == '') {
                                        swal("", "All fields are required", "warning");
                                        return false;
                                    }
                                    if (password != confirm_password) {
                                        swal("", "Password not matched", "warning");
                                        return false;
                                    }
                                    $('.ResetForm').submit();
                                }
// 	$("#ChangePasswordBtn").on('click',function(){

// })
</script>
