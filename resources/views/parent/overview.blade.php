@extends('layouts.app_new')
@section('page_title')
Dashboard
@endsection
@section('page_css')
<style type="text/css" media="screen">
    .user_info {
        margin-bottom: 30px;
    }

    .block.text-center img {
        min-height: 150px;
    }

    .block.text-center {
        max-height: 150px;
        overflow: hidden;
    }

    i.fa.fa-pencil.edit_icon {
        position: absolute;
        cursor: pointer;
        background: #f69420;
        padding: 8px;
        border-radius: 100%;
        color: #fff;
    }

    .block.text-center.active:before {
        content: '\2713';
        color: #ec9835;
        position: absolute;
        background: #000000a3;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        font-size: 40px;
    }

    #blocks .text-center {
        margin-bottom: 10px;
    }

    .block {
        cursor: pointer;
    }

    button.close {
        cursor: pointer;
    }

    #blocks .col-xl-4.col-sm-4 {
        margin-bottom: 15px;
    }

    .block.text-center.active {
        position: relative;
    }
</style>

@endsection
@section('content')
@if(Auth::user()->type==2 && Auth::user()->age =='' || Auth::user()->gender=='')
<div class="modal fade" id="afterlogin" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">
                    Some information to get started
                </h5>
            </div>
            <form name="fm-student" id="selectage_gender" action="{{route('updateAgeGender')}}">

                <div class="modal-body">
                    <div class="form-group m-form__group">
                        <select class="form-control m-input" id="gender" name="gender">
                            <option value="">Please select your gender</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
                    </div>
                    <div class="form-group m-form__group">
                        <input name="age" class="form-control m-input" id="age" type="text" placeholder="Age in years" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary  background_gradient btn-view no_border_field" id="afterloginsubmit">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content download_section">
        <!--Begin::Main Portlet-->
        <div class="m-portlet user_portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="container">
                    <div class="row m-row--no-padding dashboard_top">
                        <div class="col-md-7 text-center">
                            <!-- <div class="user_main_img">
                                <img src="{{url('public/assets/demo/demo5/media/img/user.svg')}}" class="img-responsive user_img">                        
                            </div>  -->
                            <div class="user_main_img mb-5">
                                @if(!empty($images['images']))
                                <a href="#" id="avtars" class="" data-toggle="modal" data-target="#change_avtars">
                                    <i class="fa fa-pencil edit_icon"></i></a>
                                @endif
                                @if(isset($user->instructor_avatar) && $user->instructor_avatar !='')
                                <img src="{{asset('storage/'.$user->instructor_avatar)}}" class="img-responsive user_img">
                                @elseif(isset($images['images']) && !empty($images['images']))
                                <img src="{{asset('storage/app/levelavatar/'.$images['dir']['subdir'].'/'.$images['images'][0])}}" class="img-responsive user_img">
                                @else
                                <img src="{{url('public/assets/demo/demo5/media/img/user.svg')}}" class="img-responsive user_img">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-5 d-flex align-items-center">
                            <div class="user_info">
                                <h4>Hey {{Auth::user()->name}} <br>
                                    @if(isset($summary->summary) && $summary->summary!="") <span> You are a - <strong>{{$summary->summary}}</strong>
                                    </span> @endif
                                </h4>
                                <div class="user_info_data">
                                    <div class="m-widget1">
<!--                                        <div class="m-widget1__item">
                                            <div class="row m-row--no-padding align-items-center">
                                                <div class="col">
                                                    <h3 class="m-widget1__title">
                                                        Name
                                                    </h3>
                                                </div>
                                                <div class="col m--align-left">
                                                    <span class="m-widget1__number">
                                                        {{Auth::user()->name}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="m-widget1__item">
                                            <div class="row m-row--no-padding align-items-center">
                                                <div class="col">
                                                    <h3 class="m-widget1__title">
                                                        User Name
                                                    </h3>
                                                </div>
                                                <div class="col m--align-left">
                                                    <span class="m-widget1__number">
                                                        {{Auth::user()->username}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
<!--                                        <div class="m-widget1__item">
                                            <div class="row m-row--no-padding align-items-center">
                                                <div class="col">
                                                    <h3 class="m-widget1__title">
                                                        Email
                                                    </h3>
                                                </div>
                                                <div class="col m--align-left">
                                                    <span class="m-widget1__number">
                                                        {{Auth::user()->email}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>-->
                                        @if(!empty($share_result))
                                        <div class="m-widget1">
                                            <div class="m-widget1__item">
                                                <div class="row m-row--no-padding align-items-center">
                                                    <div class="col">
                                                        <h3 class="m-widget1__title">
                                                            Share
                                                        </h3>
                                                    </div>
                                                    <div class="col m--align-left">
                                                        <span class="m-widget1__number">
                                                            <ul class="share_list">
                                                                <li><a href="{{$share_result['facebook']}}"><i class="socicon-facebook"></i></a></li>
                                                                <li><a href="{{$share_result['linkedin']}}"><i class="socicon-linkedin"></i></a></li>
                                                                <li><a href="{{$share_result['twitter']}}"><i class="socicon-twitter"></i></a></li>
                                                            </ul>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="refer_friend user_info_data">
                                    <div class="m-widget1">
                                        <div class="m-widget1__item">
                                            <div class="row m-row--no-padding align-items-center">
                                                <div class="col">
                                                    <h3 class="m-widget1__title">
                                                        Refer a friend
                                                    </h3>
                                                </div>
                                                <div class="col m--align-left">
                                                    <a href="javascript::void(0)" class="m-widget1__number theme-text" data-toggle="modal" data-target="#model_add_refer_freind">
                                                        Refer a friend
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="progress_row">
                    <div class="container">
                        <div class="row align-items-center m-row--no-padding">
                            <div class="col-md-3 text-center">
                                @if($limit == 'true')
                                <a class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" href="{{route('parent_taketest')}}">
                                    Take FAST
                                </a>
                                @else
                                <a class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" disabled>
                                    Take FAST
                                </a>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="m-widget25">

                                    <div class="m-widget25--progress">
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number">
                                                {{Auth::user()->fast_score}} %
                                            </span>

                                            <span class="m-widget25__progress-sub">
                                                Fast Score
                                            </span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar" role="progressbar" style="width:@if($testresult == '') 0% @else {{$testresult->score}}% @endif" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                        @if($testresult)
                                        @foreach($cat_result as $cat_results)
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number">
                                                {{$cat_results['score']}} %
                                            </span>
                                            <span class="m-widget25__progress-sub">
                                                {{$cat_results['category_name']}}
                                            </span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar" role="progressbar" style="width:{{$cat_results['score']}}% " aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number">
                                                0 %
                                            </span>
                                            <span class="m-widget25__progress-sub">
                                                Knowledge
                                            </span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar" role="progressbar" style="width: 0% " aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number">
                                                0 %
                                            </span>
                                            <span class="m-widget25__progress-sub">
                                                Habits
                                            </span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar" role="progressbar" style="width: 0% " aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number">
                                                0 %
                                            </span>
                                            <span class="m-widget25__progress-sub">
                                                Social Pressure Defence
                                            </span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar" role="progressbar" style="width: 0% " aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    @if(isset($testresult->overall_interpretation) && $testresult->overall_interpretation!="")
                    <div class="col-xl-12">
                        <div class="user_description">
                            {{$testresult->overall_interpretation}}
                        </div>
                    </div>
                    @endif
                    <div class="col-xl-12">
                        <div class="m-widget1 c-widget">
                            <div class="m-widget1__item">
                                @if($testresult)
                                @foreach($cat_result as $cat_results)
                                <div class="row m-row--no-padding align-items-center c-widget2">
                                    <div class="col-md-8">
                                        <h3 class="m-widget1__title">
                                            {{$cat_results['category_name']}}
                                        </h3>
                                        <!-- <span class="m-widget1__desc">
                                            Check out each column to more details
                                        </span> -->
                                        <span class="m-widget1__desc_other">
                                            {{$cat_results['interpretation']}}
                                        </span>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-3 m--align-center">
                                        <div class="c-wrapper">
                                            <!-- <div class="c100 p{{100 - $cat_results['score']}} small">
                                                <span>{{100 - $cat_results['score']}}%</span>
                                                <div class="slice">
                                                    <div class="bar"></div>
                                                    <div class="fill"></div>
                                                </div>
                                                <div class="c100-title">Extraverted</div>
                                            </div>  -->
                                            <div class="c100 p{{$cat_results['score']}} small">
                                                <span>{{$cat_results['score']}}%</span>
                                                <div class="slice">
                                                    <div class="bar"></div>
                                                    <div class="fill"></div>
                                                </div>
                                                <!-- <div class="c100-title">Introverted</div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="m-widget1 c-widget  whithout_test">
                                    <div class="m-widget1__item">
                                        @foreach($cat_result as $cat_results)
                                        <div class="row m-row--no-padding align-items-center c-widget2">
                                            <div class="col-md-8">
                                                <h3 class="m-widget1__title">
                                                    {{$cat_results->category_name}}
                                                </h3>
                                                <!-- <span class="m-widget1__desc">
                                                    Check out each column to more details
                                                </span> -->
                                                <span class="m-widget1__desc_other">

                                                </span>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-3 m--align-center">
                                                <div class="c-wrapper">
                                                    <div class="c100 p0 small">
                                                        <span>0%</span>
                                                        <div class="slice">
                                                            <div class="bar"></div>
                                                            <div class="fill"></div>
                                                        </div>
                                                        <!-- <div class="c100-title">Introverted</div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="whithout_test_overlay">
                                        <a class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" href="{{route('parent_taketest')}}">
                                            Take FAST
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(!empty($images['images']))
<!-- Start model show on upload avtars button -->
<div class="modal fade" id="change_avtars" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">
                    Choose Your Avatar
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-remove"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="blocks">
                    @if(!empty($images['images']))
                    @foreach($images['images'] as $image)
                    <div class="col-xl-4 col-sm-4" onclick="ChangeOverviewImage(this);">
                        <div class="block text-center">
                            <img class="img-responsive" src="{{asset('storage/app/levelavatar/'.$images['dir']['subdir'].'/'.$image)}}" title="select Images">
                        </div>
                    </div>
                    @endforeach
                    @else
                    <span>No Instructor Image Found</span>
                    @endif
                </div>
                <input type="hidden" name="checked_image" id="checked_image">
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-danger m-btn" data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary m-btn" id="image_upload">
                    Set
                </button>
            </div>
        </div>
    </div>
</div>
@endif
<div class="modal fade" id="model_add_refer_freind" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">
                    Refer to friend
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-remove"></span>
                </button>
            </div>

            <form class="m-form m-form--fit" name="refer_friend" id="refer_friend" method="POST" action="{{ route('referFriend')}}">
                {{ csrf_field() }}

                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label col-sm-12">
                            Enter Name
                            <span class="required" aria-required="true"> * </span>
                        </label>

                        <div class="col-sm-12">
                            <div class="m-typeahead">
                                <input name="referal_name" class="form-control m-input" id="referal_name" type="text" placeholder="Enter Name" value="" required="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-sm-12">
                            Email
                            <span class="required" aria-required="true"> </span>
                        </label>

                        <div class="col-sm-12">
                            <div class="m-typeahead">
                                <input name="referal_email" class="form-control m-input" id="referal_email" type="email" placeholder="Enter Email" value="">
                            </div>
                        </div>


                    </div>
                    <div class="form-group mt-4">
                        <label class="col-form-label col-sm-12 text-center">
                            --------- OR --------
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label col-sm-12">
                            Mobile Number
                            <span class="required" aria-required="true"> </span>
                        </label>

                        <div class="col-sm-12">
                            <div class="m-typeahead">
                                <input name="referal_phone" class="form-control m-input" id="referal_phone" type="email" placeholder="Enter contact number" value="">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger m-btn" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary m-btn" id="refer_friends">
                        Refer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('bottom_content')
<!-- start bottom footer -->
<!-- <div class="row m-row--no-padding c-widget3">
    <div class="m-portlet col-sm-6  portlet_gray">
        <div class="m-portlet__body">
            <span class="m-portlet__head-icon">
                <i class="la la-download">
                </i>
            </span>
            <h3 class="m-portlet__head-text">
                Social Pressure Defence
            </h3>

            <p>
                In our free type descriptions you'll learn what really deives, inspire, and worries other types, helping you build more meaninful relationships.
            </p>
            <button class="btn">See all Services
            </button>
        </div>
    </div>
    <div class="m-portlet col-sm-6 portlet_orange">
        <div class="m-portlet__body">
            <span class="m-portlet__head-icon">
                <i class="la la-info-circle">
                </i>
            </span>
            <h3 class="m-portlet__head-text">
                About MoneyTree Course
            </h3>
            <p>
                In our free type descriptions you'll learn what really deives, inspire, and worries other types, helping you build more meaninful relationships.
            </p>
            <button class="btn">Enter the Academy
            </button>
        </div>
    </div>
</div> -->
<!-- end bottom footer -->
@endsection
@section('page_script')
<script>
    $('#refer_friends').click(function (e) {
        e.preventDefault();
        var referal_name = $('#referal_name').val();
        var referal_email = $('#referal_email').val();
        var referal_phone = $('#referal_phone').val();

        if (referal_name == '') {
            swal("Error", " Name  is required", "error");
            return false;
        }
        if (referal_email == '' && referal_phone == '') {
            swal("Error", "please enter email/mobile number.", "error");
            return false;
        }

        $.ajax({
            method: 'POST',
            url: $("#refer_friend").attr('action'),
            data: {
                referal_name: referal_name,
                referal_email: referal_email,
                referal_phone: referal_phone,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                //var res = $.parseJSON(data);
                if (data.status == 'error') {
                    swal('Error', data.message, 'error');
                } else {
                    $('#referal_name').val('');
                    $('#referal_email').val('');
                    $('#referal_phone').val('');
                    $('#model_add_refer_freind').modal('hide');
                    swal("Success", "send successfully", "success");
                }
            },
            error: function (data) {
                $('#referal_name').val('');
                $('#referal_email').val('');
                $('#referal_phone').val('');
                swal('Error', data.message, 'error');
            }
        });
    });

    function ChangeOverviewImage(e) {
        var user_id = "{{Auth::user()->id}}";
        var instrutor_file = $(e).find('img').attr('src');
        $('.block').removeClass('active');
        $(e).find('.block').addClass('active');
        $('#checked_image').val(instrutor_file);
    }
    $('#image_upload').on('click', function () {

        var instrutor_files = $('#checked_image').val();
        $.ajax({
            method: 'POST',
            url: APP_URL + '/parent/instructor/imageUpdate',
            data: {
                image: instrutor_files
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    swal("Success", "Change avatars successfully", "success");
                    window.location.reload();
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });
    });


    $(document).ready(function () {
        $('#afterlogin').modal('show');
        $('#afterlogin').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    $('#afterloginsubmit').click(function (e) {
        e.preventDefault();
//                var user_type = $('#user_type').val();
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
    });
</script>
@endsection