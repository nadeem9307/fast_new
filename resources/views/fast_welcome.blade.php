<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            Welcome Fast Index
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <link href="{{ url('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/demo/demo5/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
         <link href="{{url('public/css/sweetalert.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{ url('public/assets/demo/demo5/media/img/logo/favicon.png')}}" />
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
            body.dashboard{
                font-family: 'Poppins', sans-serif !important; 
            }

            .w_main {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100%;
                width: 100%;
            }
            .w_block {
                text-align: center;
            }
            .w_block {
                max-width: 530px;
            }
            .w_image img {
                max-width: 100%;
                padding: 0 5%;
                width: auto;
                margin-bottom: 20px;
            }
            .w_description {
                font-size: 18px;
                color: #fff;
                font-weight: 400;
            }
            .lets_start_btn {
                border: 2px solid #fff;
                color: #fff;
                padding: 14px 25px;
                font-weight: 600;
                text-decoration: none;
                font-size: 16px;
            }
            .lets_start_btn:hover {
                color: #fff;
                text-decoration: none;
            }
            .w_footer {
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                height: 100px;
            }
            .w_footer img {
                width: 110px; 
                margin-right: -100px;
            }

            @media (max-width: 580px){
                .w_footer img {
                    width: 65px;
                    margin-right: -30px;
                }
                .lets_start_btn { 
                    padding: 5px 18px; 
                    font-size: 13px;
                }
                .w_description {
                    font-size: 14px;
                }
            }

        </style>
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
        <!-- begin:: Page --> 
        <div class="w_main" style="background-position: center; background-image: url({{url('public/assets/demo/demo5/media/img/fast_welcome.png')}})">
            <div class="w_block">
                <div class="w_image">
                    <img src="{{url('public/assets/demo/demo5/media/img/home.png')}}">
                </div>
                <div class="w_description">
                    F.A.S.T is a tool designed to measure a person's. especially kids, personality towards money. Our studies show that a person's money personality strongly influences their chances to be financially successful.
                </div>
                <div class="w_footer">
                    
                    @if(Auth::user()->user_type==3)
                    <a href="{{url('overview')}}" class="lets_start_btn">Let's Get Started</a>
                    @else
                    <a href="{{url('parent/overview')}}" class="lets_start_btn">Let's Get Started</a>
                   
                    @endif
                    <img src="{{url('public/assets/demo/demo5/media/img/plain_icon.png')}}">
                </div>
            </div> 
        </div>
        <!-- end:: Page -->
        <!--begin::Base Scripts -->
        <script src="{{url('public/assets/library/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{url('public/assets/library/scripts.bundle.js')}}" type="text/javascript"></script>
        <script src="{{ url('public/js/sweetalert.min.js')}}"></script>
        <script>
            /*
$(document).ready(function () {
    $('#afterlogin').modal('show');
    $('#afterlogin').modal({
        backdrop: 'static',
        keyboard: false
    });
});
$('#afterloginsubmit').click(function (e) {
    e.preventDefault();
    var user_type = $('input[name=user_type]:checked').val();
    var gender = $('#gender').val();
    var age = $('#age').val();


    if (user_type == '') {
        swal("Error", "User type is required", "error");
        return false;
    }

    if (gender == '') {
        swal("Error", "Please select your gender", "error");
        return false;
    }
    if (age == '') {
        swal("Error", "Please enter your age", "error");
        return false;
    }
    if (age < 1 || age > 100) {
        swal("Error", "Please enter your correct age", "error");
        return false;
    }

    $.ajax({
        url: $('#selectage_gender').attr('action'),
        method: 'POST',
        data: {
            user_type: user_type,
            gender: gender,
            age: age,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            var res = $.parseJSON(data);
            if (res.status == 'error') {
                swal('Error', res.message, 'error');
            } else {
                 $('#afterlogin').modal('hide');
            }
        },
        error: function (data) {
            var error_message = $JSON.stringify(data);
            swal('Error', error_message, 'error');
        }
    });
});*/
        </script>
        <!--end::Base Scripts -->
    </body>
    <!-- end::Body -->
</html>
