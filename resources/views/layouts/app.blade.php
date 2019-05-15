<!DOCTYPE html> 
<html lang="{{ app()->getLocale() }}" > 
    <head>
        <meta charset="utf-8" />
        <title>
            @yield('page_title')
        </title>
        <meta name="description" content="Financial Aptitude & Success Traits">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta property="og:image" content="https://staging.quizme.com.my/fast_index/Monytree.png">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="1024">
        <meta property="og:image:height" content="1024">
        <link href="{{url('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/assets/demo/demo5/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/assets/demo/demo5/base/custom.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/css/sweetalert.css')}}" rel="stylesheet" type="text/css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{url('public/assets/demo/demo5/media/img/logo/favicon.png')}}" />
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
        @yield('page_css')
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body class="dashboard m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default"  >
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- begin::Header -->
            <header class="m-grid__item m-header "  data-minimize="minimize" data-minimize-offset="200" data-minimize-mobile-offset="200" >
                <!-- top header -->
                @include('header.app_fastheader')
                <!-- end top header -->
                <!-- menu header -->
                @include('header.app_menuheader')
                <!-- end menu header -->
            </header>
            <!-- end::Header -->        
            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body">
                <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver    m-container m-container--responsive m-container--xxl m-page__container">
                    @yield('content')
                </div>
            </div>
            <!-- end::Body -->
            <!-- begin::Footer -->

            @include('footer.footer')

            <!-- end::Footer -->
        </div>
        <!-- end:: Page -->
        <!-- begin::Scroll Top -->
        <div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
            <i class="la la-arrow-up">
            </i>
        </div>
        <!-- end::Scroll Top -->
        <!--begin::Base Scripts -->      
        <script src="{{url('public/assets/library/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{url('public/assets/library/scripts.bundle.js')}}" type="text/javascript"></script>
<!--        <script src="{{url('public/assets/vendors/library/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{url('public/assets/demo/demo5/base/scripts.bundle.js')}}" type="text/javascript"></script>-->
        <!-- <script src="{{url('public/assets/app/js/dashboard.js')}}" type="text/javascript"></script> -->
        <script src="{{ url('public/js/sweetalert.min.js')}}"></script>
        <script>
            var user_id = "{{Auth::user()->id}}";
            var path = APP_URL + "/get_user_data";
            $.ajax({
                method: "POST",
                url: path,
                data: {user_id, user_id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    //console.log("here is the data");
                    //console.log(result);
                    var res = $.parseJSON(result);
                    $('.total_notification').html(res.total_notification);
                    if (!$.isEmptyObject(res.notification_data))
                    {
                        var html = "";

                        $.each(res.notification_data, function (key, values) {
                            console.log(values.request_type);
                            if (values.request_type == '1') {
                                var request_url = APP_URL + "/manage_request/" + values.request_type;
                            } else if (values.request_type == '2') {
                                var request_url = APP_URL + "/manage_request/" + values.request_type;
                            } else if (values.request_type == '3') {
                                var request_url = APP_URL + "/taketest/";
                            } else if (values.request_type == '4') {
                                var request_url = APP_URL + "/manage_request/" + values.request_type
                            }
                            html += '<div class="m-list-timeline__items notify_items"><div class="m-list-timeline__item"><span class="m-list-timeline__badge"></span><span class="m-list-timeline__text"><a href="' + request_url + '" onClick=messageRead(' + values.id + ')>' + values.message + '</a></span><span class="m-list-timeline__time">' + values.time + '</span></div></div>';
                        });
                        $('.notify_data').html(html);
                    }
                    if (!$.isEmptyObject(res.request_data))
                    {
                        var html = "";
                        $.each(res.request_data, function (key, values) {
                            html += '<div class="m-list-timeline__items notify_items"><div class="m-list-timeline__item"><span class="m-list-timeline__badge"></span><span class="m-list-timeline__text">' + values.from_user + '&nbsp' + values.status_message + '&nbspyou to tag as a friend</span><span class="m-list-timeline__time"><button class="btn btn-primary btn-sm accept_btn" data-id="' + values.from_id + '">Accept</button></span><span class="m-list-timeline__time"><button class="btn btn-danger btn-sm decline_btn" data-id="' + values.from_id + '">Decline</button></span></div></div>';
                        });
                        $('.request_data').html(html);
                    }

                },
                error: function () {
                    //alert("Error");
                }
            });
            $(document).ready(function () {
                $(document).on('click', '.accept_btn', function () {
                    var path = APP_URL + "/request_response";
                    var type = "2";
                    var from_id = $(this).data('id');
                    //alert(from_id);
                    $.ajax({
                        method: "POST",
                        url: path,
                        data: {from_id, type: type},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            var res = $.parseJSON(data);
                            if (res.status == 'error') {
                                swal('Error', res.message, 'error');
                            } else
                            {
                                swal('success', res.message, 'success');
                            }
                        },
                        error: function () {
                            //alert("Error");
                        }
                    });
                });
                $(document).on('click', '.decline_btn', function () {
                    var path = APP_URL + "/request_response";
                    var type = "3";
                    var from_id = $(this).data('id');
                    //alert(from_id);
                    //return false;
                    $.ajax({
                        method: "POST",
                        url: path,
                        data: {from_id, type: type},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            var res = $.parseJSON(data);
                            if (res.status == 'error') {
                                swal('Error', res.message, 'error');
                            } else
                            {
                                swal('success', res.message, 'success');
                            }
                        },
                        error: function () {
                            //alert("Error");
                        }
                    });
                });
            });
            /*-----------read message --------------*/
            function messageRead(id) {
                var path = APP_URL + "/change_notification_status";
                $.ajax({
                    method: "POST",
                    url: path,
                    data: {id: id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        var res = $.parseJSON(data);

                    },
                    error: function () {
                        return false;
                        //alert(retur"Error");
                    }
                });
            }
            /*-----------mark all read message --------------*/
            function markNotificationRead() {
                var path = APP_URL + "/markNotificationRead";
                $.ajax({
                    method: "POST",
                    url: path,
                    data: {},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        var res = $.parseJSON(data);
                        if (res.status == 'error') {
                            window.location.reload();
                        } else
                        {
                            window.location.reload();
                        }

                    },
                    error: function () {
                        return false;
                        //alert(retur"Error");
                    }
                });
            }
        </script>
        @yield('page_script')
    </body>
    <!-- end::Body -->
</html>
