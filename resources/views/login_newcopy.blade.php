<!DOCTYPE html> 
<html lang="en" > 
    <head>
        <meta charset="utf-8" />
        <title>
            Login
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{url('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/assets/demo/demo5/homebase/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/assets/demo/demo5/homebase/custom.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/css/sweetalert.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{url('public/assets/demo/demo5/media/img/logo/favicon.png')}}" />
        <script>
            var APP_URL = {!! json_encode(url('/')) !!}
        </script>
        <style>
            .m-grid__item.m-grid__item--fluid.m-grid.m-grid--hor.m-login.m-login--singin.m-login--2.m-login-2--skin-1{
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                background-attachment: fixed;
                background-repeat: no-repeat;

            }
            .m-login__logo {
                padding: 20px 30px;
            }
            .m-login__logo img {
                max-width: 200px;
                width: 100%;
            }
            a {
                color: #f69420;
            }

            .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .form-control::-moz-placeholder { 
                color:#777;
                opacity: 1;
            }
            .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .form-control:-ms-input-placeholder { 
                color:#777;
            }
            .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .form-control::-ms-input-placeholder {
                color:#777;
            }

            .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .form-control::placeholder {
                color:#777;
            }

            .m-login.m-login--2 .m-login__wrapper{
                padding: 0;
            }
            .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .form-control, .m-login.m-login--2 .m-login__wrapper .m-login__container .m-login__form .m-form__group .form-control.m-login__form-input--last { 
                background:transparent; 
                border-bottom: 1px solid #ccc;
                border-radius: 0;
                padding-left: 5px;
                color: #4c4c4d;
                margin-top: 0;
            }
            .m-checkbox.m-checkbox--light > span:after {
                border: solid #f69420;
            }
            .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .m-login__form-sub .m-checkbox {
                color: #4c4c4d;
            }
            .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .form-control:focus {
                background: #fff;
                color: #000;
            }
            .m-checkbox.m-checkbox--light > span {
                border: 1px solid #4c4c4d !IMPORTANT;
            }
            .m-login.m-login--2 .m-login__wrapper .m-login__container .m-login__form .m-login__form-sub {
                padding-left: 0;
                padding-right: 0;
                margin: 15px auto;
            }
            .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__account .m-login__account-link {
                color: #f69420;
            }
            .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__account .m-login__account-link:hover{
                color: #4c4c4d;
            }
            .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__head .m-login__title {
                color: #909090;
                font-size: 30px;
                margin-bottom: 10px;
                font-weight: 600;
            }
            .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .m-login__form-action .m-login__btn.m-login__btn--primary, .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .m-login__form-action .m-login__btn {
                color: white;
                background-image: linear-gradient(to top, #fec60b 0%, #ee6e3b);
                border: 0;
                border-radius: 10px;
                padding: 10px 40px;
            }
            .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .m-login__form-action .m-login__btn.m-login__btn--primary :hover, .dashboard .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__form .m-login__form-action .m-login__btn:hover {
                box-shadow: 0 5px 10px 2px #4c4c4d9c !important;
            }
            .m-login.m-login--2 .m-login__wrapper .m-login__container { 
                margin: 0 auto;
                max-width: 400px;
            }
            .m-login.m-login--2.m-login-2--skin-1 .m-login__container .m-login__head .m-login__bottom {
                text-align: center;
                font-size: 14px;
                color: #909090;
                font-weight: 400;
                line-height: 20px;
            }
            .m-login.m-login--2 .m-login__wrapper .m-login__container .m-login__form .m-form__group.has-danger .form-control-feedback {
                font-weight: 400;
                font-size: 0.85rem;
                padding-left: 0;
            }
            @media (max-width: 768px){
                .m-login__logo a{
                    display: block;
                    text-align: center;

                }
                .m-login.m-login--2 .m-login__wrapper .m-login__container {
                    width: 100%;
                    margin: 0 auto;
                    padding: 0 15px;
                }
            }
        </style>
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body class="dashboard m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default"  >

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--singin m-login--2 m-login-2--skin-1 {{$refer ? "m-login--signup": ''}}" id="m_login" style="background-image:url({{url('public/assets/demo/demo5/media/img/background.png')}})">
                <div class="m-login__logo">
                    <a href="javascript:(0);">
                        <img src="{{url('public/assets/demo/demo5/media/img/logo/FastIndexLogo.png')}}" width="250">
                    </a>
                </div>
                <div class="m-grid__item m-grid__item--fluid    m-login__wrapper">
                    <div class="m-login__container">
                        <div class="m-login__signin">

                            @if(Session::has('success'))
                            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
                            @endif
                            @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                            @endif
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    Login
                                </h3>
                                <h4  class="m-login__bottom">Welcome back to FAST <br> Did you <a href="javascript:;" id="m_login_forget_password">forget your password?</a></h4>
                            </div>
                            <form class="m-login__form m-form" action="{{route('userLogin')}}" method="POST">
                                {{csrf_field()}}
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input"   type="text" placeholder="Username"  name="email" id="email" autocomplete="off">
                                </div>

                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password" id="password">
                                </div>
                                <div class="row m-login__form-sub">
                                    <div class="col m--align-left m-login__form-left">
                                        <label class="m-checkbox  m-checkbox--light">
                                            <input type="checkbox" name="remember">
                                            Remember me
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col m--align-right m-login__form-right">
                                        <!-- <a href="javascript:;" id="m_login_forget_password" class="m-link">
                                            Forget Password ?
                                        </a> -->
                                    </div>
                                </div>
                                <div class="m-login__form-action">
                                    <button id="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                        Sign In
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="m-login__signup" id="abcd">
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    Sign Up
                                </h3>
                                <div class="m-login__desc">
                                    Enter your details to create your account:
                                </div>
                            </div>
                            <form id="registered_user" class="m-login__form m-form" action="{{route('Adduser','default')}}" method="POST">
                                <!--<form id="registered_user" class="m-login__form m-form" method="POST">-->
                                <input type = "hidden" id="login_tag_id" name="login_tag_id" value="">
                                <div class="form-group m-form__group">
                                    <select class="form-control m-input" id="user_type" name="user_type">
                                        <option value="">Please Select User Type</option>
                                        <option value="2">Parent</option>
                                        <option value="3">Child</option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    @if(!empty($countries))
                                    <select class="form-control m-input" id="country" name="country">
                                        <option value="">Please select country name</option>
                                        @foreach($countries as $allcountry)
                                        <option value="{{$allcountry['id']}}">{{$allcountry['country_name']}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                <!-- start html for gender -->
                                <div class="form-group m-form__group">
                                    <select class="form-control m-input" id="gender" name="gender">
                                        <option value="">Please select your gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                                <!-- end html for gender -->
                                <div class="form-group m-form__group" id="userschool">
                                    <input name="school_name" class="form-control m-input" id="school_name" type="text" placeholder="School Name (Optional)" value="">
                                </div>
                                <div class="form-group m-form__group">
                                    <input name="name" class="form-control m-input" id="name" type="text" placeholder=" Name" value="">
                                </div>
                                <div class="form-group m-form__group">
                                    <input name="username" class="form-control m-input" id="username" type="text" placeholder="Username" value="">
                                    <p class="msg_check"></p>
                                </div>
                                <div class="form-group m-form__group">
                                    <input name="useremail" class="form-control m-input" id="useremail" type="email" placeholder="Email (Optional)" value="">
                                </div>
                                <!-- start html for age -->
                                <div class="form-group m-form__group">
                                    <input name="age" class="form-control m-input" id="age" type="text" placeholder="Age in years" value="">
                                </div>
                                <!-- end html for age -->
                                <div class="form-group m-form__group">
                                    <!--<input name="contact" class="form-control m-input" id="contact" type="number" placeholder="Contact Number" value="">-->
                                    <input name="contact" class="form-control m-input" id="contact" type="text" placeholder="Contact Number (Optional)" value="">
                                </div>
                                <div class="form-group m-form__group">
                                    <input name="userpassword" class="form-control m-input" id="userpassword" type="password" placeholder="Password" value="">
                                </div>

                                <div class="m-login__form-action">
                                    <button id="add_user" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                        Sign Up
                                    </button>
                                    &nbsp;&nbsp;
                                    <button id="m_login_signup_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
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
                                {{ csrf_field() }}
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
                                </div>
                                <div class="m-login__form-action">
                                    <button id="m_login_forget" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                        Request
                                    </button>
                                    &nbsp;&nbsp;
                                    <button id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="m-login__account">
                            <span class="m-login__account-msg">
                                Don't have an account yet ?
                            </span>
                            &nbsp;&nbsp;
                            <a href="javascript:;" id="m_login_signup" class="m-link m-link--light m-login__account-link">
                                Sign Up
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Page -->


        <!--begin::Base Scripts -->
        <script src="{{ url('public/assets/library/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/assets/library/scripts.bundle.js')}}" type="text/javascript"></script>
        <!--end::Base Scripts -->   

        <!--begin::Page Snippets -->
        <script src="{{ url('public/js/sweetalert.min.js')}}"></script>
        <script src="{{ url('public/assets/demo/demo5/base/login.js')}}" type="text/javascript"></script>

        <script>
            /*---------- Start trigger singup --------------------*/
            $(document).ready(function () {
                var url = window.location.href;
                var fast_key = url.substring(url.lastIndexOf('/') + 1);
                if (fast_key != '')
                {
                    $('#registered_user').attr('action', APP_URL + '/register/' + fast_key)
//                    $('#m_login_signup').trigger('click');

                }
            });
            /*---------- end trigger singup--------------------*/
            /*---------- Start add country code --------------------*/
            $('#userschool').hide();
            $('#user_type').change(function () {
                $('#school_name').val('');
                if ($('#user_type').val() == '3') {
                    $('#userschool').show();
                    $('#contact').attr('placeholder','Contact Number (Optional)');
                } else {
                    $('#userschool').hide();
                    $('#contact').attr('placeholder','Contact Number');
                }
            });


            $('#add_user').click(function (e) {
                e.preventDefault();
                var id = $('#login_tag_id').val();
                var user_type = $('#user_type').val();
                var country = $('#country').val();
                var gender = $('#gender').val();
                var school_name = $('#school_name').val();
                var name = $('#name').val();
                var username = $('#username').val();
                var useremail = $('#useremail').val();
                var age = $('#age').val();
                var contact = $('#contact').val();
                var userpassword = $('#userpassword').val();


                if (user_type == '') {
                    swal("Error", "User type is required", "error");
                    return false;
                }

                if (country == '') {
                    swal("Error", "Country name is required", "error");
                    return false;
                }
                if (gender == '') {
                    swal("Error", "Please select your gender", "error");
                    return false;
                }
                if (name == '') {
                    swal("Error", "Name is required", "error");
                    return false;
                }
                if (username == '') {
                    swal("Error", "User name is required", "error");
                    return false;
                }
                if (useremail != '') {
                    if (!validateEmail(useremail)) {
                        swal("Error", "Invalid email address", "error");
                        return false;
                    }
                }
                if (age == '') {
                    swal("Error", "Please enter your age", "error");
                    return false;
                }
                if (age < 1 || age > 100) {
                    swal("Error", "Please enter your correct age", "error");
                    return false;
                }
                if (user_type == '2') {
                    if (contact == '') {
                        swal("Error", "Contact is required", "error");
                        return false;
                    }
                }
                if (userpassword == '') {
                    swal("Error", "Password is required", "error");
                    return false;
                }

                $.ajax({
                    method: 'POST',
                    url: $("#registered_user").attr('action'),
                    data: {
                        id: id,
                        country: country,
                        user_type: user_type,
                        gender: gender,
                        school_name: school_name,
                        contact: contact,
                        name: name,
                        username: username,
                        age: age,
                        useremail: useremail,
                        userpassword: userpassword,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        var res = $.parseJSON(data);
                        if (res.status == 'error') {
                            swal('Error', res.message, 'error');
                        } else {
//                            location.reload();
                            window.location.href = APP_URL;
                        }
                    },
                    error: function (data) {
                        var error_message =  $JSON.stringify(data);
                        swal('Error', error_message, 'error');
                    }
                });
            });

            /*---------- End add country code ------------------------------*/


            /*---- Check username availability -----------------------*/
            $('#username').keyup(function (e) {
                var path = APP_URL + "/registered/username";
                var id = $('#login_tag_id').val();
                var username = $('#username').val();

                $.ajax({
                    method: 'POST',
                    url: path,
                    data: {
                        id: id,
                        username: username,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        var res = $.parseJSON(data);
                        if (res.status == 'error') {
                            $myspan = '<span id="usravailability">' + res.message + '</span>';
                            $('.msg_check').html($myspan);
                            $('#add_user').attr("disabled", "disabled");
                        } else {
                            if (username == '') {
                                $myspan = '<span id="usravailability">' + res.message + '</span>';
                                $('.msg_check').html('');
                            } else if (username != '') {
                                $myspan = '<span id="usravailability">' + res.message + '</span>';
                                $('.msg_check').html($myspan);
                                $('#add_user').removeAttr("disabled");
                            }


                        }
                    },
                    error: function (data) {
                        //swal('Error', data, 'error');
                    }
                });
            });
            /*---- End Check username availability -----------------------*/
            /*---- Start  validation for email address -----------*/
            function validateEmail(useremail) {
                var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if (filter.test(useremail)) {
                    return true;
                } else {
                    return false;
                }
            }
            /*---- End validation for email address --------------*/
            /*-- input masking for age --*/
            var Inputmask = {
                init: function ()
                {
                    $("#age").inputmask({mask: "9", repeat: 2, greedy: !1});
                    $("#contact").inputmask({mask: "9", repeat: 10, greedy: !1});
                }
            }
            jQuery(document).ready(function () {
                Inputmask.init()
            });
            /*-- end input masking for age --*/


        </script>

    </body>
    <!-- end::Body -->
</html>