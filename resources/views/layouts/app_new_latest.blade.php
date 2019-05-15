<!DOCTYPE html> 
<html lang="{{ app()->getLocale() }}" > 
    <head>
        <meta charset="utf-8" />
        <title>
            @yield('page_title')
        </title>
        <script>
            var APP_URL = {!! json_encode(url('/')) !!}
        </script>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ url('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/demo/demo5/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/demo/demo5/base/custom.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url('public/assets/demo/demo5/base/circle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/css/sweetalert.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{ url('public/assets/demo/demo5/media/img/logo/favicon.png')}}" />
        @yield('page_css')
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body class="dashboard m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default"  >
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- begin::Header -->
            <header class="m-grid__item m-header"  data-minimize="minimize" data-minimize-offset="200" data-minimize-mobile-offset="200" >
                <!-- top header -->
                @include('templates.header')
                <!-- end top header -->
                <!-- menu header -->
                @include('templates.menubar')
            </header>
            <!-- end::Header -->		
            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body">
                <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver	m-container m-container--responsive m-container--xxl m-page__container">
                    @yield('content')
                </div>
                @yield('bottom_content')
                <!-- end::Body -->
                <!-- begin::Footer -->
                <footer class="m-grid__item m-footer ">
                    <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
                        <div class="m-footer__wrapper row">
                            <div class="footer-section col-xl-3 col-sm-6">
                                <a href="#">
                                    <img src="{{ url('public/assets/demo/demo5/media/img/logo/FastIndexLogo.png')}}" alt="" class="logo" >
                                </a>
                                <p>Get a concrete, accurate description of who you are and why you do things the way you do, for free.
                                </p>
                                <button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom">Take a free test
                                </button>
                            </div>
                            <div class="footer-section col-xl-3 col-sm-6">
                                <h4>
                                    <a href="#" title="Articles">Articles
                                    </a>
                                </h4>
                                <ul class="footer_list">
                                    <li>
                                        <a href="">Creatures of Habit
                                        </a>
                                    </li>	
                                    <li>
                                        <a href="">You Say You Made a Resolution: How Your Personality Traits Might Give You an Edge
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">How to Get Off Your Phone and Actually Do Something, by Personality Type
                                        </a>
                                    </li>
                                    <li>	
                                        <a href="">New Year, New You?
                                        </a>
                                    </li>
                                    <li>	
                                        <a href="">Everything Happens for a Reason: Beliefs by Personality Type
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="footer-section col-xl-3 col-sm-6">
                                <h4>
                                    <a href="" title="Theory and Research">Theory and Research
                                    </a>
                                </h4> 
                                <ul class="footer_list">
                                    <li>
                                        <a href="">Our Theory
                                        </a>
                                    </li>	
                                    <li>
                                        <a href="">Country Profiles
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="footer-section col-xl-3 col-sm-6">
                                <h4>
                                    <a href="" title="Theory and Research">Theory and Research
                                    </a>
                                </h4> 
                                <ul class="footer_list">
                                    <li>
                                        <a href="">Contact
                                        </a>
                                    </li>	
                                    <li>
                                        <a href="">Tearms & Condiations
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">Privacy Policy
                                        </a>
                                    </li>	
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
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
            <!-- <script src="{{ url('public/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript">
            </script>
            <script src="{{ url('public/assets/demo/demo5/base/scripts.bundle.js')}}" type="text/javascript"> -->
            <script src="{{url('public/assets/library/vendors.bundle.js')}}" type="text/javascript"></script>
            <script src="{{url('public/assets/library/scripts.bundle.js')}}" type="text/javascript"></script>
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
            <script type="text/javascript">
                   $('.takefastbutton,.retakefastbutton').on('click', function (e) {
                    e.preventDefault();
                    taketestview();
                });
                function taketestview() {
                    $('#takefastmodel_content').show();
                    $('#takefastmodel_content2').hide();
                    $('#takefastmodel').modal('show');
                    var test_type = $(this).attr('data-type');
                    //alert(test_type);
                    var sublevel_id = $('#sublevel_type').val();
                    if (test_type == '1')
                    {
                        $('#modal_type').val(test_type);
                        $('#level_type').hide();
                        $('#sublevel_type').hide();
                        var data = {sublevel_id: sublevel_id, test_type: test_type};
                        //$('#level_type').trigger('change', data);
                    } else
                    {
                        $('#modal_type').val(test_type);
                        $('#level_type').show();
                        $('#sublevel_type').show();
                        var level_id = $('#level_type').val();
                        var data = {level_id: level_id, sublevel_id: sublevel_id, test_type: test_type}
                    }
                    getSemesters(data);
                    /*$('#level_type,#sublevel_type').trigger('change', data);*/

                }

                $('#level_type,#sublevel_type').change(function (e, data) {
                    e.preventDefault();
                    var test_type = $('#modal_type').val();
                    var sublevel_id = $('#sublevel_type').val();
                    if (test_type == '1')
                    {
                        //$('#level_type').hide();
                        var data = {sublevel_id: sublevel_id, test_type: test_type};
                        //$('#level_type').trigger('change', data);
                    } else
                    {
                        var level_id = $('#level_type').val();
                        var data = {level_id: level_id, sublevel_id: sublevel_id, test_type: test_type}
                    }
                    getSemesters(data);
                });
                /*-- Start take fast model ------------------*/
                function getSemesters(search_data) {
//                    console.log("search data");
//                    console.log(search_data);

                    var path = APP_URL + "/taketest/gettest_levels";
                    $.ajax({
                        method: 'POST',
                        url: path,
                        data: search_data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            //console.log(search_data);
                            var res = $.parseJSON(data);
                            if (res.status == 'error') {
                                swal('Error', res.message, 'error');
                            } else {
                                //$('#takefastmodel').modal('show');

                                var result = $.parseJSON(JSON.stringify(res.data));
                                console.log("result data");
                                console.log(result);
                                var semblocks = '';
                                if (!$.isEmptyObject(result))
                                {
                                    var result_length = Object.keys(result).length;
                                    $.each(result, function (key, val) {
                                        if (val.score!=0) {
                                            semblocks += ' <div class="col-md-6 text-center"><div class="enabled_test"><div class="enabled_test_inner">' + val.sem_name + '</h4>'
                                                    + '<div class="circle_score"><div class=""><h2>' + val.score + '%</h2><p>Your Previous Score</p>'
                                                    + '</div></div><button class="btn m-btn--square btn-retake btn-primary" onclick="gettaketest(' + val.level_id + ',' + val.sublevel_id + ',' + val.SemID + ')">'
                                                    + 'Retake Test </button></div></div></div>';
                                        }
                                        else if (val.score==0 && val.test_status == 1) {
                                            semblocks += ' <div class="col-md-6 text-center"><div class="enabled_test"><div class="enabled_test_inner">' + val.sem_name + '</h4>'
                                                    + '<div class="circle_score"><div class=""><h2>' + val.score + '%</h2><p>Your Previous Score</p>'
                                                    + '</div></div><button class="btn m-btn--square btn-retake btn-primary" onclick="gettaketest(' + val.level_id + ',' + val.sublevel_id + ',' + val.SemID + ')">'
                                                    + 'Retake Test </button></div></div></div>';
                                        }
                                        else if (val.score==0 && val.test_status == 2) { 
                                            semblocks += '<div class="col-md-6 text-center"><div class="disabled_test"><div class="disabled_test_inner"><h4>' + val.sem_name + '</h4>'
                                                    + '<div class="circle_score"><div class=""><h2>0%</h2><p>No test attempted for this Level and Sublevel.</p></div> </div>'
                                                    + '<button class="btn m-btn--square btn-retake btn-primary">Take Fast</button></div>'
                                                    + '<div class="overlay_content"><h5>You have not attempted this test.</h5></div></div></div>';
                                        }
                                        else
                                        {
                                            semblocks += "";
                                        }
                                    });
                                } else
                                {
                                    var test_type = $('#modal_type').val();
                                    if (test_type == '1')
                                    {
                                        semblocks += ' <div class="col-md-6 text-center"><div class="enabled_test"><div class="enabled_test_inner"></h4>'
                                                + '<div class="circle_score"><div class=""><h2>0%</h2><p>Congratulation you complete all parts of current level. Please change your level for proceed further.</p>'
                                                + '</div></div></div></div></div>';
                                    } else
                                    {
                                        semblocks += ' <div class="col-md-6 text-center"><div class="enabled_test"><div class="enabled_test_inner">No Test Attempted for this Level and Sublevel.</h4>'
                                                + '<div class="circle_score"><div class=""><h2>0%</h2><p>Not give any test, please click on taketest.</p>'
                                                + '</div></div></div></div></div>';
                                    }
                                }
                                $('#blocks').html(semblocks);
                            }
                        },
                        error: function (data) {
                            //            swal('Error', data, 'error');
                        }
                    });
                }
                /*--- End take fast model -------------------*/

                /*---- Start taketest url -----------*/
                function gettaketest(level_id, sublevel_id, sem_id) {
                    window.location.href = APP_URL + "/taketest?level_id=" + level_id + '&sublevel_id=' + sublevel_id + '&sem_id=' + sem_id;

                }
                /*---- End take test url -------------*/

                /*-- add retakefast test button --*/
                $('.retakefastbutton').click(function (e) {
                    e.preventDefault();
                    $('#takefastmodel_content2').show();
                    $('#takefastmodel_content').hide();
                    //              $('#reretakefastmodel').modal('show');
                    $('#level_type').show();
                    $('#sublevel_type').show();
                });
                $('.close_other').click(function (e) {
                    e.preventDefault();
                    $('#takefastmodel_content2').hide();
                    $('#takefastmodel_content').show();
                });

                /*-- end retakefast test button --*/
            </script>
            @yield('page_script')
            <!--end::Base Scripts -->   

    </body>
    <!-- end::Body -->
</html>
