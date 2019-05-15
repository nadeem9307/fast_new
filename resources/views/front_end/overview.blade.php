@extends('layouts.app_new')
@section('page_title')
Dashboard
@endsection
@section('page_css')
<style>
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

    #ResponseHeading {
        color: #f69420;
    }

    .btn-success {
        color: #fff;
        background-color: #f69420;
        border-color: #f69420;
    }

    .btn-success:hover {
        color: #fff;
        background-color: #4c4c4d;
        border-color: #4c4c4d;
    }

    button.close {
        cursor: pointer;
    }

    #blocks .col-xl-4.col-sm-4 {
        margin-bottom: 15px;
    }

    #blocks .score_range_block {
        padding: 20px 10px;
    }

    #blocks .score_range_block.sem {
        cursor: pointer;
    }

    .score_range_block h5 {
        font-size: 14px;
        font-weight: 300;
    }

    .block {
        cursor: pointer;
    }

    .score_range_block.bg-danger {
        background: #4c4c4d !important;
    }

    .score_range_block.bg-success {
        background: #f69420 !important;
    }

    .bg-success .align-items-center.text-white {
        background: #e07e0b;
        padding: 5px 15px;
        border-radius: 15px;
        font-size: 12px;
    }

    .bg-danger .align-items-center.text-white {
        background: #424244;
        padding: 5px 15px;
        border-radius: 15px;
        font-size: 12px;
    }

    .take_test_modal .modal-body {
        padding: 0 !important;
    }

    .take_test_option .modal-body {
        padding: 25px !important;
    }

    .take_test_modal .modal_right {
        background: url(public/assets/demo/demo5/media/img/take_test_modal_bg.png);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        width: 50%;
        text-align: center;
    }

    .take_test_modal .close {
        padding: 0;
        background: transparent;
        border: 0;
        -webkit-appearance: none;
        position: absolute;
        left: 5px;
        color: #fff;
        opacity: 1;
    }

    .modal_left svg {
        width: 80%;
        height: 100%;
        fill: #fff;
        transform: rotate(135deg);
    }

    .modal_left {
        text-align: center;
        background: #ed7d31;
        width: 50%;
    }

    .top_modal {
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    .take_test_modal .btn-primary {
        background: transparent;
        border: 2px solid #ffffff;
        transition: .5s ease all;
        border-radius: 0 !important;
        padding: 10px 30px !important;
        margin-bottom: 35px;
    }

    .take_test_modal h3 {
        font-size: 15px;
        margin-bottom: 10px;
        margin-top: 0;
        color: #fff;
        font-weight: 400;
    }

    .take_test_modal .modal-content {
        box-shadow: none;
    }

    #blocks .text-center {
        margin-bottom: 10px;
    }
    @media (min-width: 576px) {
        .modal-dialog.take_test_modal {
            max-width: 800px;
            width: 95%;
        }
    }

    @media (max-width: 767px) {
        .modal-dialog.take_test_modal {
            max-width: 400px;
            margin: auto;
            margin-top: 20px;
            padding: 10px;

        }

        .take_test_modal .d-flex {
            display: flex !important;
            width: 100%;
            flex-wrap: wrap;
        }

        .take_test_modal .modal_left {
            width: 100%;
        }

        .take_test_modal .modal_right {
            width: 100%;
        }

        .take_test_modal .top_modal {
            /* min-height: 300px;*/
        }

        .modal_left svg {
            width: 55%;
        }
    }

    .circle_score {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 200px;
        height: 200px;
        background: #ed7d31;
        border-radius: 50%;
        margin: 20px auto;
        color: #fff;
    }

    .circle_score h2 {
        font-size: 3rem;
    }

    .enabled_test,
    .disabled_test {
        min-height: 440px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        box-shadow: 2px 2px 4px #0000008c;
    }

    .enabled_test_inner,
    disabled_test_inner {
        width: 100%;
    }

    .enabled_test {
        background: #eee;
    }

    .disabled_test {
        position: relative;
    }

    .disabled_test .overlay_content {
        position: absolute;
        background: rgba(0, 0, 0, 0.61);
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
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

    .disabled_test .circle_score {
        background: #a5a5a5 !important;
    }

    .enabled_test .btn-retake {
        padding: 15px 30px !IMPORTANT;
        border: 2px solid #f69420;
        border-radius: 0px !important;
        background: transparent;
        color: #f69420;
        font-weight: 600;
    }

    .disabled_test .btn-retake {
        padding: 15px 30px !IMPORTANT;
        border: 2px solid #4c4c4c;
        border-radius: 0px !important;
        background: transparent;
        color: #4c4c4c;
        font-weight: 600;

    }

    button.close_other {
        cursor: pointer;
    }


    .block.text-center.active {
        position: relative;
    }

    .whithout_test {
        position: relative;
    }
</style>
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content download_section">
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
                            <button type="button" class=" btn btn-primary  background_gradient btn-view no_border_field" id="afterloginsubmit">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <!--Begin::Main Portlet-->
        <div class="m-portlet user_portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="container">
                    <div class="row m-row--no-padding dashboard_top">
                        <div class="col-md-7 text-center">
                            <div class="user_main_img mb-5">
                                @if(!empty($images['images'])) 
                                <a href="#" id="avtars" class="" data-toggle="modal" data-target="#change_avtars">
                                    <i class="fa fa-pencil edit_icon"></i>
                                </a>
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
                                <h4>Hey {{$user->name}} <br>
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
                                                        {{$user->name}}
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
                                                        {{$user->username}}
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
                                                        {{$user->email}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>-->
                                        <!-- start level for overview -->
                                        @if(!empty($level))
                                        <div class="m-widget1__item">
                                            <div class="row m-row--no-padding align-items-center">
                                                <div class="col">
                                                    <h3 class="m-widget1__title">
                                                        Level
                                                    </h3>
                                                </div>
                                                <div class="col m--align-left">
                                                    <span class="m-widget1__number styled-select slate">
                                                        <select class="" id="level" name="level" onChange="Getlevel(this)">
                                                            @foreach($level as $levels)
                                                            @if($user->level_id == $levels->id)
                                                            <option value="{{$levels->id}}" selected>{{$levels->level_name}}</option>
                                                            @else
                                                            <option value="{{$levels->id}}">{{$levels->level_name}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
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
                                <button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom takefastbutton" data-type="1">
                                    Take FAST
                                </button>
                                @else
                                <button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" disabled>
                                    Take FAST
                                </button>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="m-widget25">

                                    <div class="m-widget25--progress">
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number">
                                                {{$user->fast_score}}%
                                            </span>

                                            <span class="m-widget25__progress-sub">
                                                Fast Score
                                            </span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar" role="progressbar" style="width:{{$user->fast_score}}%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                        @if($testresult)
                                        @foreach($cat_result as $cat_results)
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number">
                                                {{$cat_results['score']}}%
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
                                                0%
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
                                                0%
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
                                                0%
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
                                        <button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom takefastbutton" data-type="1">Take FAST</button>
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
<!--begin::Modal for take fasts-->
<div class="modal" id="takefastmodel">
    <div class="modal-dialog modal-lg take_test_modal " role="document">
        <div class="modal-content" id="takefastmodel_content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
                <div class="d-flex">
                    <div class="modal_left">
                        <div class="top_modal">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="561px" height="561px" viewBox="0 0 561 561" style="enable-background:new 0 0 561 561;" xml:space="preserve">
                            <g>
                            <g id="loop">
                            <path d="M280.5,76.5V0l-102,102l102,102v-76.5c84.15,0,153,68.85,153,153c0,25.5-7.65,51-17.85,71.4l38.25,38.25C471.75,357,484.5,321.3,484.5,280.5C484.5,168.3,392.7,76.5,280.5,76.5z M280.5,433.5c-84.15,0-153-68.85-153-153c0-25.5,7.65-51,17.85-71.4l-38.25-38.25C89.25,204,76.5,239.7,76.5,280.5c0,112.2,91.8,204,204,204V561l102-102l-102-102V433.5z" />
                            </g>
                            </g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            <g></g>
                            </svg>

                        </div>
                        <h3>Repeat a previous test</h3>
                        <button class="btn m-btn--square btn-retake btn-primary retakefastbutton" data-toggle="modal" data-target="#retakefastmodel" data-type="2">
                            Retake
                        </button>
                    </div>
                    <div class="modal_right">
                        <div class="top_modal">
                        </div>
                        <h3>&nbsp;</h3>
                        <button class="btn m-btn--square btn-retake btn-primary" onclick="gettaketest({{$semester[0]['levelid']}},{{$semester[0]['sublevel_id']}},{{$semester[0]['SemID']}})">

                            Take Test
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-content" id="takefastmodel_content2" style="display: none">
            <div class="modal-header flext-start-responsive">
                <div class="header_filter">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Take Fast
                    </h5>
                    <input type="hidden" name="modal_type" id="modal_type" value="2">
                    <select class="form-control m-input " id="level_type" name="level_type">
                        @foreach($level as $levels)
                        @if(Auth::user()->level_id == $levels->id)
                        <option value="{{$levels->id}}" selected>{{$levels->level_name}}</option>
                        @else
                        <option value="{{$levels->id}}">{{$levels->level_name}}</option>
                        @endif
                        @endforeach
                    </select>
                    <select class="form-control m-input" id="sublevel_type" name="sublevel_type">
                        @foreach($sublevels as $sublevel)
                        <option value="{{$sublevel->id}}">{{$sublevel->sublevel_name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="close_other" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body" style="padding: 25px !important;">
                <div class="row" id="blocks">
                    <div class="col-md-6 text-center">
                        <div class="enabled_test">
                            <div class="enabled_test_inner">
                                <h4>Part 1</h4>
                                <div class="circle_score">
                                    <div class="">
                                        <h2>72%</h2>
                                        <p>Your Previous Score</p>
                                    </div>
                                </div>
                                <button class="btn m-btn--square btn-retake btn-primary" data-toggle="modal" data-target="#retakefastmodel">
                                    Retake Test
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Modal for take fast-->


<!-- Start model show on take fast button -->
<div class="modal fade" id="takefastmodel1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header flext-start-responsive">
                <div class="header_filter">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Take Fast
                    </h5>
                    <input type="hidden" name="modal_type" id="modal_type" value="">
                    <select class="form-control m-input " id="level_type" name="level_type">
                        @foreach($level as $levels)
                        @if(Auth::user()->level_id == $levels->id)
                        <option value="{{$levels->id}}" selected>{{$levels->level_name}}</option>
                        @else
                        <option value="{{$levels->id}}">{{$levels->level_name}}</option>
                        @endif
                        @endforeach
                    </select>
                    <select class="form-control m-input" id="sublevel_type" name="sublevel_type">
                        @foreach($sublevels as $sublevels)
                        <option value="{{$sublevels->id}}">{{$sublevels->sublevel_name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="blocks">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End model show on take fast button -->
<!-- Start model show on upload avtars button -->
@if(!empty($images['images']))
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
                    
                    @foreach($images['images'] as $image)
                    <div class="col-xl-4 col-sm-4" onclick="ChangeOverviewImage(this);">
                        <div class="block text-center">
                            <img class="img-responsive" src="{{asset('storage/app/levelavatar/'.$images['dir']['subdir'].'/'.$image)}}" title="select Images">
                        </div>
                    </div>
                    @endforeach
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
<!-- End model show on take fast button -->
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
            $('#refer_friends').click(function(e) {
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
            success: function(data) {
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
            error: function(data) {
            $('#referal_name').val('');
                    $('#referal_email').val('');
                    $('#referal_phone').val('');
                    swal('Error', data.message, 'error');
            }
    });
    });
            /*----------- For level --------------------*/
                    function Getlevel(level) {
                    var path = APP_URL + "/overview/levels";
                            level = $('#level').val();
                            if (level == '') {
                    swal('Error', 'Please select your level', 'error');
                            return false;
                    }
                    swal({
                    title: "Are you sure want to change your level?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes, change it!",
                            closeOnConfirm: false
                    },
                            function(isConfirm) {
                            if (isConfirm) {
                            $.ajax({
                            type: 'POST',
                                    url: path,
                                    data: {
                                    id: level,
                                    },
                                    headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(data) {
                                    var res = $.parseJSON(data);
                                            if (res.status == 'error') {
                                    swal('Error', res.message, 'error');
                                    } else {
                                    swal("Success", "Change level successfully", "success");
                                            window.location.reload();
                                    }
                                    },
                                    error: function(data) {
                                    swal('Error', data, 'error');
                                    }
                            });
                            }
                            });
                    }

            function ChangeOverviewImage(e) {
            var user_id = "{{Auth::user()->id}}";
                    var instrutor_file = $(e).find('img').attr('src');
                    $('.block').removeClass('active');
                    $(e).find('.block').addClass('active');
                    $('#checked_image').val(instrutor_file);
            }
            $('#image_upload').on('click', function() {

            var instrutor_files = $('#checked_image').val();
                    $.ajax({
                    method: 'POST',
                            url: APP_URL + '/instructor/imageUpdate',
                            data: {
                            image: instrutor_files
                            },
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                            var res = $.parseJSON(data);
                                    if (res.status == 'error') {
                            swal('Error', res.message, 'error');
                            } else {
                            swal("Success", "Change Avatars successfully", "success");
                                    window.location.reload();
                            }
                            },
                            error: function(data) {
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
                     window.location.reload();
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