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

            .dashboard .m-login.m-login--1 .m-login__container .m-login__form .form-control::-moz-placeholder {
                color:#777;
                opacity: 1;
            }
            .dashboard .m-login.m-login--1 .m-login__container .m-login__form .form-control:-ms-input-placeholder {
                color:#777;
            }
            .dashboard .m-login.m-login--1 .m-login__container .m-login__form .form-control::-ms-input-placeholder {
                color:#777;
            }

            .dashboard .m-login.m-login--1 .m-login__container .m-login__form .form-control::placeholder {
                color:#777;
            }

            .m-login.m-login--2 .m-login__wrapper{
                padding: 0;
            }
            .dashboard .m-login.m-login--1 .m-login__container .m-login__form .form-control, .m-login.m-login--1 .m-login__wrapper .m-login__container .m-login__form .m-form__group .form-control.m-login__form-input--last {
                background: transparent;
                border: 2px solid #e7eaf0;
                border-radius: 5px;
                padding-left: 10px;
                color: #4c4c4d;
                margin-top: 0;
                height: auto;
            }
            .m-checkbox.m-checkbox--light > span:after {
                border: solid #f69420;
            }
            .dashboard .m-login.m-login--1 .m-login__container .m-login__form .m-login__form-sub .m-checkbox {
                color: #4c4c4d;
                margin: 0;
            }
            .dashboard .m-login.m-login--1 .m-login__container .m-login__form .form-control:focus {
                background: #fff;
                color: #000;
            }
            .m-checkbox.m-checkbox--light > span {
                border: 1px solid #4c4c4d !IMPORTANT;
            }
            .m-login.m-login--1 .m-login__wrapper .m-login__container .m-login__form .m-login__form-sub {
                padding-left: 0;
                padding-right: 0;
                margin: 15px auto 0;
            }

            .m-login.m-login--1 .m-login__container .m-login__account .m-login__account-link{
                color: #f69420;
            }
            .forget_link{
                color: #f69420;
                font-size: 1.1rem;
            }
            .m-login.m-login--1 .m-login__container .m-login__account .m-login__account-link:hover{
                color: #4c4c4d;
            }
            .m-login.m-login--1 .m-login__wrapper .m-login__head {
                margin: 0;
            }
            .m-login.m-login--1 .m-login__container .m-login__head .m-login__title {
                color: #909090;
                font-size: 25px;
                margin-bottom: 10px;
                font-weight: 600;
            }
            h4.m-login__bottom a:hover {
                color: #4c4c4d;
                text-decoration: none;
            }
            .dashboard .login_left .login_btn{
                color: white;
                background: #ed7d31;
                border: 0;
                border-radius: 3px;
                padding: 15px 40px !important;
                box-shadow: none !IMPORTANT;
                transition: .5s ease all;
                width: 100%;
            } 
            .dashboard .login_left .login_btn:hover{

            }
            .m-login.m-login--1 {
                background: #f4f6f9;
            }
            @media (max-width: 1024px){
                .login_right {
                    background: none !important;
                    text-align: center;
                }     
            }
            /*---start css for brek registration page---- */
            .middle {
                width: 100%;
                text-align: center;
                display: flex;
                justify-content: space-between;
            }
            .middle input[type="radio"] {
                display: none;
            }
            .middle input[type="radio"]:checked + .box {
                background-color: #f69420;
            }
            .middle input[type="radio"]:checked + .box span {
                color: white;
                /*  transform: translateY(70px);*/
            }
            .middle input[type="radio"]:checked + .box span:before {
                transform: translateY(0px);
                opacity: 1;
            }
            .middle .box {
                width: 150px;
                height: 150px;
                border-radius: 10px;
                background-color: #4c4c4d;
                transition: all 250ms ease;
                cursor: pointer;
            }
            .middle .box:active {
                transform: translateY(10px);
            }
            .middle .box span {
                display: block;
                left: 0;
                right: 0;
                transition: all 300ms ease;
                font-size: 1.5em;
                user-select: none;
                color: #fff;
                font-weight: 400;
            }
            .middle label { 
            }
            .box svg {
                width: 50px;
                fill: #fff;
                margin-top: 30px;

            }
            /*--- end css for brek registration page-----*/

            .login_left  {
                background: #f4f6f9;
            }
            .m-login.m-login--1 .m-login__aside {
                width: 100%;
                max-width: 650px;
                padding: 2rem 10rem;
            }
            .m-login.m-login--1 .m-login__content {
                padding: 3rem 2rem;
                background-size: cover !important;
                background-position: bottom !important;
                background-attachment: inherit;
            }
            .m-login.m-login--1 .m-login__content .m-login__welcome {
                color: #9c9a9a;
                font-size: 2rem;
                font-weight: 600;
                margin-bottom: 2rem;
            }
            .m-login.m-login--1 .m-login__content .m-login__msg {
                color: #9c9a9a;
                font-size: 1.1rem;
                font-weight: normal;
            }
            .m-login.m-login--1 .m-login__wrapper .m-login__form {
                margin-top: 0;
                border: 2px solid #e4e4e4;
                padding: 30px;
                border-radius: 3px;
                background:#fff;
                max-width: 400px;
                margin: auto;
            }
            .m-login.m-login--1 .m-login__wrapper .m-login__form .m-form__group {
                margin-bottom: 15px;
            }
            .m-form .m-form__group .col-form-label, .m-form .m-form__group .form-control-label, .m-form .m-form__group>label {
                color: #afafaf;
                font-size: 12px;
                font-weight: 600;
            }
            .m-login.m-login--1 .m-login__wrapper { 
                padding: 0;
                display: flex;
                align-items: center;
                width: 100%;
                height: 100%;
            }
            .m-login__container {
                width: 100%;
            }
            .sign_up_link a {
                border: 2px solid;
                padding: 8px 15px;
                transition: .5s ease all;
                cursor: pointer;
            }
            .sign_up_link {
                margin: 20px 0;
            }
            .custom-btn-group {
                display: flex;
            }
            .custom-btn-group .login_btn, .custom-btn-group .login_btn_2 {
                width: 50% !important;
            }
            .custom-btn-group .login_btn{
                margin-right: 3px;
            }
            .custom-btn-group .login_btn_2 {
                margin-left: 3px;
            }
            .login_btn_2 {
                background: #4c4c4d;
                color: #fff;
            }
             .danger #usravailability {
                color: red;
            }
            .user_available_success {
                color: green;
            }
            @media (max-width: 768px){
                .m-login.m-login--1 .m-login__aside {
                    padding: 2rem 1rem;
                }
            }

        </style>
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body class="dashboard m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default"  >

        <!-- begin:: Page -->

        <!-- end:: Page -->


        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login">
                <div class="login_left m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">

                    <div class="m-grid__item m-grid__item--fluid    m-login__wrapper">
                        <div class="m-login__container">
                            <div class="m-login__head text-center mb-4">
                                <img src="{{url('public/assets/demo/demo5/media/img/logo/FastIndexLogo.png')}}" width="250">
                            </div>
                            <div class="m-login__signin">

                                @if(Session::has('success'))
                                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
                                @endif
                                @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                                @endif

                                <form class="m-login__form m-form" action="{{route('userLogin')}}" method="POST">
                                    {{csrf_field()}}
                                    <div class="form-group m-form__group">
                                        <label>User Name</label>
                                        <input class="form-control m-input"   type="text" placeholder=""  name="email" id="email" autocomplete="off">
                                    </div>

                                    <div class="form-group m-form__group">
                                        <label>Password</label>
                                        <input class="form-control m-input m-login__form-input--last" type="password" placeholder="" name="password" id="password">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <button id="submit" class="btn login_btn">
                                            Sign In
                                        </button>
                                    </div>
                                    <div class="row m-login__form-sub">
                                        <div class="m--align-left m-login__form-left">
                                            <label class="m-checkbox  m-checkbox--light">
                                                <input type="checkbox" name="remember">
                                                Remember me
                                                <span></span>
                                            </label>
                                        </div> 
                                    </div>  
                                    <div class="row m-login__form-sub">
                                        <div class="m--align-left m-login__form-left">
                                            <h4  class="m-login__bottom"><a href="javascript:;" id="m_login_forget_password" class="forget_link">Forget password?</a></h4>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- Sign Up form -->

                            <div class="m-login__signup" id="">

                                <form id="registered_user" class="m-login__form m-form" action="{{route('Adduser','default')}}" method="POST">
                                    <div class="m-login__head">
                                        <h3 class="m-login__title">
                                            Sign Up
                                        </h3>
                                        <div class="form-group m-form__group text-center">
                                            <!--<label>Enter your details to create your account</label>--> 
                                        </div>

                                    </div>
                                    <!--<form id="registered_user" class="m-login__form m-form" method="POST">-->
                                    <input type = "hidden" id="login_tag_id" name="login_tag_id" value="">
                                    <div class="step_1">
                                        <!--  <div class="form-group m-form__group">
                                             <select class="form-control m-input" id="user_type" name="user_type">
                                                 <option value="">Please Select User Type</option>
                                                 <option value="2">Parent</option>
                                                 <option value="3">Child</option>
                                             </select>
                                         </div>-->
                                        <div class="middle mt-4">
                                            <label>
                                                <input type="radio" id="radio_1" name="user_type" value="3"/>
                                                <div class="front-end box">
                                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve"><g> <g> <path d="M481.999,273.586v-47.58c0-8.284-6.716-15-15-15c-30.988,0-59.878,2.615-87.173,7.955 c-15.911-15.365-35.308-26.513-56.313-32.606c22.904-19.277,37.486-48.14,37.486-80.349c0-58.449-47.103-106-105-106 c-57.897,0-105,47.551-105,106c0,32.209,14.582,61.072,37.487,80.348c-21.005,6.094-40.402,17.242-56.313,32.606 c-27.295-5.339-56.185-7.955-87.173-7.955c-8.284,0-15,6.716-15,15v47.58c-17.459,6.192-30,22.865-30,42.42v30 c0,19.555,12.541,36.228,30,42.42v47.58c0,8.284,6.716,15,15,15c78.429,0,142.832,18.583,202.68,58.481 c5.015,3.342,11.621,3.35,16.641,0c59.848-39.898,124.25-58.481,202.68-58.481c8.284,0,15-6.716,15-15v-47.58 c17.459-6.192,30-22.865,30-42.42v-30C511.999,296.451,499.458,279.778,481.999,273.586z M180.999,106.006 c0-41.907,33.645-76,75-76s75,34.093,75,76c0,41.355-33.645,75-75,75C214.644,181.006,180.999,147.361,180.999,106.006z M44.999,361.006c-8.271,0-15-6.729-15-15v-30c0-8.271,6.729-15,15-15s15,6.729,15,15v30 C59.999,354.277,53.27,361.006,44.999,361.006z M240.999,470.091c-54.453-31.141-112.886-46.88-181-48.869v-32.796 c17.459-6.192,30-22.865,30-42.42v-30c0-19.555-12.541-36.228-30-42.42v-32.368c70.481,2.023,127.134,18.62,181,52.916V470.091z M255.999,268.145c-27.686-17.469-56.504-30.77-87.268-40.117c16.904-10.986,36.803-17.022,57.268-17.022h60 c20.465,0,40.364,6.036,57.268,17.022C312.503,237.375,283.684,250.676,255.999,268.145z M451.999,421.222 c-68.113,1.989-126.548,17.732-181,48.871V294.146c53.867-34.299,110.516-50.906,181-52.928v32.368 c-17.459,6.192-30,22.865-30,42.42v30c0,19.555,12.541,36.228,30,42.42V421.222z M481.999,346.006c0,8.271-6.729,15-15,15 s-15-6.729-15-15v-30c0-8.271,6.729-15,15-15s15,6.729,15,15V346.006z"/> </g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg> 
                                                    <span>Child</span> 
                                                </div>
                                            </label>
                                            <label> 
                                                <input type="radio" id="radio_2" name="user_type" value="2"/> <div class="back-end box"> <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve"><g> <g> <path d="M163.1,183.614c-3.217-2.61-7.94-2.117-10.549,1.1c-3.19,3.934-7.425,6.1-11.925,6.1s-8.735-2.166-11.925-6.1 c-2.608-3.217-7.332-3.709-10.549-1.1c-3.217,2.609-3.709,7.332-1.1,10.549c6.004,7.403,14.596,11.65,23.573,11.65 s17.569-4.247,23.575-11.65C166.809,190.946,166.317,186.223,163.1,183.614z"/> </g>
                                                    </g>
                                                    <g> 
                                                    <g> 
                                                    <path d="M105.125,137.563c-4.142,0-7.5,3.358-7.5,7.5v8.875c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5v-8.875 C112.625,140.921,109.267,137.563,105.125,137.563z"/> </g></g><g> <g> <path d="M176.125,137.563c-4.142,0-7.5,3.358-7.5,7.5v8.875c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5v-8.875 C183.625,140.921,180.267,137.563,176.125,137.563z"/>
                                                    </g>
                                                    </g><g>
                                                    <g>
                                                    <path d="M67.458,345.833l-17.75-35.5c-1.852-3.705-6.357-5.207-10.062-3.354c-3.705,1.852-5.207,6.357-3.354,10.062l16.958,33.917 v140.229c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5v-142C68.25,348.022,67.979,346.874,67.458,345.833z"/> </g></g><g> <g> <path d="M241.604,306.979c-3.705-1.853-8.21-0.351-10.062,3.354l-17.75,35.5c-0.521,1.042-0.792,2.189-0.792,3.354v142 c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5V350.958l16.958-33.917C246.811,313.337,245.309,308.832,241.604,306.979z"/> </g></g><g> <g> <path d="M402.725,227.988c-3.217-2.61-7.94-2.117-10.549,1.1c-3.19,3.934-7.425,6.1-11.925,6.1s-8.735-2.166-11.925-6.1 c-2.608-3.217-7.332-3.709-10.549-1.1c-3.217,2.609-3.709,7.332-1.1,10.549c6.005,7.404,14.598,11.65,23.575,11.65 c8.977,0,17.567-4.246,23.573-11.65C406.434,235.32,405.942,230.597,402.725,227.988z"/> </g></g><g> <g> <path d="M344.75,181.938c-4.142,0-7.5,3.358-7.5,7.5v8.875c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5v-8.875 C352.25,185.295,348.892,181.938,344.75,181.938z"/> </g></g><g> <g> <path d="M415.75,181.938c-4.142,0-7.5,3.358-7.5,7.5v8.875c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5v-8.875 C423.25,185.296,419.892,181.938,415.75,181.938z"/> </g></g><g> <g> <path d="M490.549,335.529l-60.856-24.343c-3.914-1.565-6.443-5.301-6.443-9.517v-18.433c4.164-2.35,8.147-5.039,11.89-8.065 c15.239-12.317,26.006-29.568,30.319-48.573c1.437-6.333,2.166-12.864,2.166-19.412c0-43.685-31.643-49.967-62.243-56.042 c-19.57-3.885-39.806-7.903-55.947-20.815c-1.766-1.413-4.078-1.949-6.286-1.466c-2.209,0.482-4.085,1.939-5.103,3.959 c-0.042,0.083-4.244,8.355-11.351,16.41c-6.019,6.822-15.472,14.954-26.321,14.954c-3.648,0-7.115,0.784-10.25,2.183v-12.433 c0-49.695,40.43-90.125,90.125-90.125s90.125,40.43,90.125,90.125v17.75c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5 v-17.75c0-39.318-21.7-73.657-53.75-91.687c0.325-1.962,0.5-3.946,0.5-5.938c0-23.71-23.271-43-51.875-43s-51.875,19.29-51.875,43 c0,1.993,0.173,3.977,0.499,5.939c-32.049,18.03-53.749,52.369-53.749,91.686v35.5c0,11.398,7.592,21.057,17.985,24.185 c0.32,4.378,0.965,8.722,1.931,12.977c4.313,19.005,15.081,36.256,30.319,48.573c3.743,3.026,7.726,5.715,11.89,8.065v18.433 c0,4.216-2.529,7.951-6.443,9.517l-60.855,24.342c-13.031,5.212-21.451,17.649-21.451,31.684v44.104 c0,1.99,0.791,3.898,2.198,5.305c1.406,1.406,3.313,2.195,5.302,2.195c0.001,0,0.002,0,0.004,0h1.371v72.371 c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5v-72.375h20.5v72.375c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5 v-97.625c0-4.142-3.358-7.5-7.5-7.5c-4.142,0-7.5,3.358-7.5,7.5v10.25h-28c-0.001,0-0.002,0-0.004,0H263.5v-36.6 c0-7.866,4.719-14.836,12.022-17.757l47.326-18.93c6.282,10.646,24.113,37.028,54.047,51.995c1.056,0.528,2.205,0.792,3.354,0.792 c1.149,0,2.298-0.264,3.354-0.792c29.934-14.967,47.766-41.349,54.047-51.995l47.327,18.931 c7.303,2.921,12.022,9.892,12.022,17.757v36.6h-1.375h-28v-10.25c0-4.142-3.358-7.5-7.5-7.5c-4.142,0-7.5,3.358-7.5,7.5v97.625 c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5v-72.375h20.5v72.375c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5 v-72.375h1.375c4.142,0,7.5-3.358,7.5-7.5v-44.1C512,353.179,503.58,340.742,490.549,335.529z M380.25,28.313 c19.967,0,36.266,12.114,36.847,27.171c-11.473-4.308-23.888-6.671-36.847-6.671s-25.375,2.363-36.847,6.671 C343.984,40.427,360.283,28.313,380.25,28.313z M334.789,263.508c-12.629-10.209-21.55-24.495-25.121-40.228 c-1.19-5.245-1.793-10.66-1.793-16.092c0-4.142-3.358-7.5-7.5-7.5c-5.652,0-10.25-4.598-10.25-10.25s4.598-10.25,10.25-10.25 c22.743,0,39.239-20.594,46.688-32.116c17.491,11.261,37.496,15.233,55.398,18.788c32.963,6.544,50.164,11.354,50.164,41.329 c0,5.433-0.604,10.847-1.793,16.092c-3.57,15.733-12.492,30.019-25.121,40.227c-12.995,10.504-28.715,16.056-45.461,16.056 C363.504,279.564,347.784,274.012,334.789,263.508z M380.25,367.34c-22.628-12.499-37.183-32.724-43.272-42.492 c9.294-3.995,15.272-13.013,15.272-23.178v-11.745c8.97,3.034,18.432,4.638,28,4.638s19.03-1.604,28-4.638v11.745 c0,10.165,5.978,19.182,15.272,23.177C417.43,334.62,402.875,354.843,380.25,367.34z"/> </g></g><g> <g> <path d="M256.931,274.187l-48.699-14.609l-8.117-12.175c-1.18-1.771-3.058-2.957-5.164-3.262c-0.824-0.12-1.651-0.096-2.452,0.053 v-11.141c19.895-14.732,33.355-37.684,35.266-63.805c10.392-3.128,17.984-12.787,17.984-24.185c0-7.378-3.316-14.371-8.875-19.125 V74.063c0-14.222-7.203-27.525-19.008-35.497C213.921,23.738,200.621,13.313,185,13.313h-71 c-38.392,0-69.625,31.233-69.625,69.625v43c-5.559,4.754-8.875,11.746-8.875,19.125c0,11.398,7.592,21.057,17.984,24.185 c1.911,26.121,15.37,49.073,35.266,63.805v11.14c-0.801-0.15-1.628-0.174-2.452-0.053c-2.106,0.306-3.983,1.491-5.164,3.262 l-8.117,12.175l-48.699,14.609C9.773,278.551,0,291.686,0,306.873v184.315c0,4.142,3.358,7.5,7.5,7.5s7.5-3.358,7.5-7.5V306.873 c0-8.511,5.478-15.873,13.63-18.319l33.502-10.051c0.065,1.556,0.614,3.092,1.636,4.369l30.126,37.658 c3.245,4.056,7.977,6.173,12.771,6.173c3.421,0,6.875-1.079,9.84-3.303l16.619-12.464v180.25c0,4.142,3.358,7.5,7.5,7.5 c4.142,0,7.5-3.358,7.5-7.5v-180.25l16.619,12.464c2.965,2.224,6.418,3.303,9.84,3.303c4.794,0,9.527-2.118,12.771-6.173 l30.126-37.658c1.024-1.277,1.572-2.813,1.638-4.369l33.502,10.051c8.152,2.446,13.63,9.808,13.63,18.319 c0,4.142,3.358,7.5,7.5,7.5c4.142,0,7.5-3.358,7.5-7.5C281.25,291.686,271.477,278.551,256.931,274.187z M68.25,162.813 c0-4.142-3.358-7.5-7.5-7.5c-5.652,0-10.25-4.598-10.25-10.25c0-3.638,1.924-6.93,5.147-8.806 c0.166-0.097,0.317-0.211,0.474-0.319c1.427-0.725,3.01-1.125,4.629-1.125h10.474c7.779,0,14.532-5.536,16.057-13.163 l5.457-27.282c0.076-0.381,0.275-0.671,0.59-0.862c0.248-0.15,0.659-0.293,1.209-0.132c13.322,3.886,29.259,5.939,46.088,5.939 c21.596,0,41.533-3.357,56.139-9.454c3.822-1.596,5.627-5.988,4.032-9.811c-1.596-3.822-5.987-5.626-9.811-4.032 c-12.631,5.272-30.987,8.296-50.361,8.296c-15.207,0-30.083-1.896-41.887-5.339c-4.449-1.297-9.254-0.677-13.183,1.704 c-3.888,2.356-6.631,6.274-7.526,10.75l-5.457,27.281c-0.128,0.64-0.695,1.105-1.348,1.105H60.75c-0.459,0-0.917,0.02-1.375,0.045 v-36.92c0-30.12,24.505-54.625,54.625-54.625h71c9.408,0,17.313,6.78,18.796,16.121c0.359,2.26,1.73,4.233,3.723,5.357 c8.855,4.994,14.355,14.294,14.355,24.272v55.712c0,2.67,1.42,5.139,3.728,6.482c3.223,1.876,5.147,5.168,5.147,8.806 c0,5.652-4.598,10.25-10.25,10.25c-4.142,0-7.5,3.358-7.5,7.5c0,39.908-32.467,72.375-72.375,72.375S68.25,202.72,68.25,162.813z M107.506,311.401c-0.598,0.449-1.431,0.342-1.898-0.241l-26.701-33.376l10.078-15.117l39.553,32.96L107.506,311.401z M140.625,286.175l-36.875-30.729v-13.44c11.211,5.241,23.704,8.182,36.875,8.182s25.664-2.94,36.875-8.182v13.44L140.625,286.175 z M175.642,311.16c-0.467,0.584-1.3,0.689-1.898,0.241l-21.032-15.773l39.553-32.96l10.078,15.117L175.642,311.16z"/> </g></g><g> <g> <path d="M114.089,368.313H114c-4.142,0-7.456,3.358-7.456,7.5c0,4.142,3.402,7.5,7.544,7.5c4.142,0,7.5-3.358,7.5-7.5 C121.588,371.671,118.231,368.313,114.089,368.313z"/> </g></g><g> <g> <path d="M114.089,439.313H114c-4.142,0-7.456,3.358-7.456,7.5c0,4.142,3.402,7.5,7.544,7.5c4.142,0,7.5-3.358,7.5-7.5 C121.588,442.671,118.231,439.313,114.089,439.313z"/> </g></g><g> <g> <path d="M114.089,403.813H114c-4.142,0-7.456,3.358-7.456,7.5c0,4.142,3.402,7.5,7.544,7.5c4.142,0,7.5-3.358,7.5-7.5 C121.588,407.171,118.231,403.813,114.089,403.813z"/> </g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>

                                                    <span>Parent</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="m-login__form-action">
                                            <button id="singup_next" type="button" class="login_btn">
                                                Next
                                            </button>
                                        </div>
                                    </div>

                                    <div class="step_2" style="display: none;">

                                        <div class="form-group m-form__group">
                                            <label class="parent_type">Username</label>
                                            <input name="username" class="form-control m-input" id="username" type="text" placeholder="" value="">
                                            <p class="msg_check"></p>
                                        </div>
                                        <div class="form-group m-form__group">
                                            @if(!empty($countries))
                                            <label>Please select country name</label>
                                            <select class="form-control m-input" id="country" name="country"> 
                                                @foreach($countries as $allcountry)
                                                <option value="{{$allcountry['id']}}">{{$allcountry['country_name']}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        <div class="form-group m-form__group">
                                            <label>Password</label>
                                            <input name="userpassword" class="form-control m-input" id="userpassword" type="password" placeholder="" value="">
                                        </div>


                                        <div class="custom-btn-group" role="group" aria-label="Large button group">
                                            <button type="button" id="add_user" class="btn login_btn">
                                                Sign Up
                                            </button> 
                                            <button id="m_login_signup_cancel" type="button" class="btn login_btn_2">
                                                Cancel
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <!-- Sign Up form END -->

                            <div class="m-login__forget-password">                           
                                <form class="m-login__form m-form" action="{{ route('login.password.email')}}">
                                    <div class="m-login__head">
                                        <h3 class="m-login__title text-left">
                                            Forgotten Password ?
                                        </h3> 
                                    </div>
                                    {{ csrf_field() }}
                                    <div class="form-group m-form__group mt-5">
                                        <label>Enter your email to reset your password</label>
                                        <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
                                    </div>
                                    <div class="custom-btn-group" role="group" aria-label="Large button group">
                                        <button type="button" id="m_login_forget" class="btn login_btn">
                                            Request
                                        </button> 
                                        <button id="m_login_forget_password_cancel" type="button" class="btn login_btn_2">
                                            Cancel
                                        </button>
                                    </div>

                                </form>
                            </div>


                            <div class="m-login__account sign_up_link">
                                <span class="m-login__account-msg ">
                                    Don't have an account yet ?
                                </span>
                                &nbsp;&nbsp;
                                <a href="javascript:;" id="m_login_signup" class="m-link m-link--light m-login__account-link ">
                                    Sign Up
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="login_right m-grid__item m-grid__item--fluid m-grid m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image:url('{{ url('public/assets/demo/demo5/media/img/logo/login_bg.jpg')}}')">
                    <div class="m-grid__item m-grid__item--middle">
                        <h3 class="m-login__welcome">
                            Measure your financial aptitude and behavior towards money.
                        </h3>
                        <p class="m-login__msg">
                            Result from FAST will give you an indication of how well informed and "equipped" you are the deal with money matters as well as grow your wealth.
                        </p>
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
            /*---------- Start show and hide child school --------------------*/

            $('#userschool').hide();
            /*-------------- End show and hide child school -------------*/

            $('#add_user').click(function (e) {
                e.preventDefault();
                var id = $('#login_tag_id').val();
//                var user_type = $('#user_type').val();
                var user_type = $('input[name=user_type]:checked').val();
                var country = $('#country').val();
                var gender = $('#gender').val();
                var school_name = $('#school_name').val();
                var name = $('#name').val();
                var username = $('#username').val();
//                var useremail = $('#useremail').val();
                var age = $('#age').val();
//                var contact = $('#contact').val();
                var userpassword = $('#userpassword').val();


                if (user_type == '') {
                    swal("Error", "User type is required", "error");
                    return false;
                }

                if (country == '') {
                swal("Error", "Country name is required", "error");
                        return false;
                }
                if ($('input[name=user_type]:checked').val() == 3){
                if (username == '') {
                    swal("Error", "User name is required", "error");
                    return false;
                    }
                } else {
                    if (username != '') {
                        if (!validateEmail(username)) {
                            swal("Error", "Invalid email address", "error");
                                    return false;
                        }
                    }
                }
//              
//             
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
//                        gender: gender,
//                        school_name: school_name,
//                        contact: contact,
//                        name: name,
                        username: username,
//                        age: age,
//                        useremail: useremail,
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
                        var error_message = $JSON.stringify(data);
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
                var user_type = $('input[name=user_type]:checked').val();

                $.ajax({
                    method: 'POST',
                    url: path,
                    data: {
                        id: id,
                        username: username,
                        user_type:user_type,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);
                        var res = $.parseJSON(data);
                        if (res.status == 'error') {
                            $myspan = '<span id="usravailability">' + res.message + '</span>';
                            $('.msg_check').html($myspan);
                            $('#add_user').attr("disabled", "disabled");
                        } else {
                           if (username == '') {
                                console.log(res.message);
                                $myspan = '<span id="usravailability">' + res.message + '</span>';
                                $('.msg_check').html('');
                                $('.msg_check').addClass('danger');
                            } else if (username != '') {
                                $myspan = '<span id="usravailability" class="user_available_success">' + res.message + '</span>';
                                $('.msg_check').html($myspan);
                                console.log(res.message);
                                $('.msg_check').removeClass('danger');
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
        <script type="text/javascript">
            $(document).ready(function () {
                $("#singup_next").click(function () {
                    var user_type = $('input[name=user_type]:checked').val();

                    if (user_type == undefined) {
                        swal("Error", "Please select user type", "error");
                        return false;
                    }
                    $('#school_name').val('');
                    if (user_type == '3') {
                        $('#userschool').show();
                        $('#username').attr('placeholder', 'Username');
                        $('#username').attr('type', 'text');
                        $('.parent_type').html('Username');
                    } else {
                        $('#userschool').hide();
                        $('#username').attr('placeholder', 'Email');
                        $('.parent_type').html('Email');
                        $('#username').attr('type', 'email');
                    }
                    $(".step_2").show();
                    $(".step_1").hide();
                });
                $("#m_login_signup_cancel").click(function () {
                    $(".step_1").show();
                    $(".step_2").hide();
                    $("input[name=user_type]").prop("checked", false);
                    $('#country').val('');
                    $('#username').val('');
                    $('#useremail').val('');
                    $('#userpassword').val('');
                });

            });
        </script>
    </body>
    <!-- end::Body -->
</html>