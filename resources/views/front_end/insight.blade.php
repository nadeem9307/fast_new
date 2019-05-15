@extends('layouts.app_new')
@section('page_title')
Insight
@endsection
@section('page_css')
<style>
    #chartjs-tooltip {
        opacity: 1;
        position: absolute;
        background: rgba(0, 0, 0, .7);
        color: white;
        border-radius: 3px;
        -webkit-transition: all .1s ease;
        transition: all .1s ease;
        pointer-events: none;
        -webkit-transform: translate(-50%, 0);
        transform: translate(-50%, 0);
    }

    .chartjs-tooltip-key {
        display: inline-block;
        width: 10px;
        height: 10px;
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

    #blocks .text-center {
        margin-bottom: 10px;
    }

    .whithout_test_1 {
        border-bottom: none;
    }

    /*-- start test popup css*/
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

    .control_heading_top {
        padding: 50px 0 0;
        justify-content: center;
    }

    @media (max-width: 992px) {
        .insight_top {
            padding: 30px 0;
        }
    }

    /*-- end test popup css */
</style>
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content download_section">
        <!--Begin::Main Portlet-->
        <div class="m-portlet user_portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding insight_top">
                    <div class="col-md-6 text-center">
                        <h5 class="text-left">HISTORICAL FAST SCORE</h5>
                        <div class="mr-auto">

                            <canvas id="myChart" style="width: 100%;"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-center">
                        @if($limit == 'true')
                        <!--<button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" onclick="gettaketest({{$semester[0]['levelid']}},{{$semester[0]['sublevel_id']}},{{$semester[0]['SemID']}})" data-type="1">-->
                        <button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom takefastbutton" data-type="1">
                            Take FAST
                        </button>
                        @else
                        <button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" disabled>
                            Take FAST
                        </button>
                        @endif
                    </div>

                    <div class="col-sm-12">
                        <!-- Start sublevel and semester results -->
                        <div class="row control_heading_top">
                            <div class="col-sm-3 col-6">
                                <select class="form-control m-input" id="sublevelid" name="sublevelid">
                                    <!--<option value="">Please select your sublevel</option>-->
                                    @foreach($sublevels as $key=>$sublevel)
                                    @if($key ==0)
                                    <option value="{{$sublevel->id}}" selected>{{$sublevel->sublevel_name}}</option>
                                    @else
                                    <option value="{{$sublevel->id}}">{{$sublevel->sublevel_name}}</option>
                                    @endif
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-sm-3 col-6">
                                <select class="form-control m-input" id="semesterid" name="semesterid" onchange="getSublevelResult()">
                                    @foreach($level_semester as $key=>$sem)
                                    @if($key ==0)
                                    <option value="{{$sem->id}}" selected>{{$sem->sem_name}}</option>
                                    @else
                                    <option value="{{$sem->id}}">{{$sem->sem_name}}</option>
                                    @endif
                                    @endforeach
                                    <!--<option value="">Please select your semester</option>-->

                                </select>
                            </div>
                        </div>
                        <!-- End sublevel and semester results -->
                        <div class="control_heading">
                            <div class="left_control prev_result_id">
                                @if(isset($testresult->prev_id) && $testresult->prev_id!="")
                                <button class="ctrl_btn next_data" data-id="{{$testresult->prev_id}}"><i class="la la-long-arrow-left"></i><span class="theme-text">View Previous Results</span></button>
                                @else
                                <button class="ctrl_btn" style="visibility: hidden;"><i class="la la-long-arrow-left"></i><span class="theme-text">View Previous Results</span></button>
                                @endif
                            </div>
                            <div class="main_heading test_date" id="c_result">
                                @if($testresult)
                                Result ( {{date('d/m/Y', strtotime($testresult->created_at)) }} )
                                @else
                                @endif
                            </div>
                            <div class="right_control next_result_id">
                                @if(isset($testresult->next_id) && $testresult->next_id!="")
                                <button class="ctrl_btn next_data" data-id="{{$testresult->next_id}}"><span class="theme-text">View More Recent Results</span><i class="la la-long-arrow-right"></i></button>
                                @else
                                <button class="ctrl_btn" style="visibility: hidden;"><span class="theme-text">View More Recent Results</span><i class="la la-long-arrow-right"></i></button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>


                <div class="progress_row">
                    <div class="container">
                        <div class="row align-items-center m-row--no-padding">
                            <div class="col-md-3 text-center">
                                @if($limit == 'true')
                                <button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom takefastbutton" data-type="2">
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
                                            <span class="m-widget25__progress-number category_score_{{$cat_results['category_id']}}">
                                                {{$cat_results['score']}}%
                                            </span>

                                            <span class="m-widget25__progress-sub category_name_{{$cat_results['category_id']}}">
                                                {{$cat_results['category_name']}}
                                            </span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar category_progress_{{$cat_results['category_id']}}" role="progressbar" style="width:{{$cat_results['score']}}% " aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number sdf">
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
                    <div class="col-xl-12 overall_inter">
                        @if(isset($testresult->overall_interpretation) && $testresult->overall_interpretation!="")
                        <div class="user_description">
                            {{$testresult->overall_interpretation}}
                        </div>
                        @endif
                    </div>
                    <div class="col-xl-12">
                        <div class="m-widget1 c-widget">
                            @if($testresult)
                            <div class="m-widget1__item whithout_test_1">
                                @else
                                <div class="m-widget1__item whithout_test_2">
                                    @endif
                                    @if($testresult)
                                    @foreach($cat_result as $category_score_data)
                                    <div class="row m-row--no-padding align-items-center c-widget2">
                                        <div class="col-md-8">
                                            <h3 class="m-widget1__title category_name_{{$category_score_data['category_id']}}">
                                                {{$category_score_data['category_name']}}
                                            </h3>
                                            <!-- <span class="m-widget1__desc">
                                                Check out each column to more details
                                            </span> -->
                                            <span class="m-widget1__desc_other cat_interpretation_{{$category_score_data['category_id']}}">
                                                {{$category_score_data['interpretation']}}
                                            </span>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3 m--align-center">
                                            <div class="c-wrapper cat_score_{{$category_score_data['category_id']}}">
                                                <div class="c100 p{{$category_score_data['score']}} small">
                                                    <span>{{$category_score_data['score']}}%</span>
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
                                    <div class="whithout_test">
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
                                        <button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom takefastbutton" data-type="2">Take FAST</button>
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
                        @if(!empty($level))
                        @foreach($level as $levels)
                        @if(Auth::user()->level_id == $levels->id)
                        <option value="{{$levels->id}}" selected>{{$levels->level_name}}</option>
                        @else
                        <option value="{{$levels->id}}">{{$levels->level_name}}</option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                    <select class="form-control m-input" id="sublevel_type" name="sublevel_type">
                        @if(!empty($sublevels))
                        @foreach($sublevels as $sublevel)
                        <option value="{{$sublevel->id}}">{{$sublevel->sublevel_name}}</option>
                        @endforeach
                        @endif
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header flext-start-responsive">
                <div class="header_filter">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Take Fast
                    </h5>
                    <input type="hidden" name="modal_type" id="modal_type" value="">
                    <select class="form-control m-input" id="level_type" name="level_type">
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
@if(!empty($testresult))
<input type="hidden" id="cat_length" name="cat_length" value="{{count($cat_result)}}">
@endif
@endsection
@section('page_script')
<script>
    var chart_data = "";
    var sem_score = [];
    var label = [];
    var score = [];
    var prev_data = [];
    var last_data = [];
    var sub_data = [];
    var id = "{{Auth::user()->id}}";
    $.ajax({
        method: 'POST',
        url: 'get_chart_data',
        async: false,
        data: {
            id: id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            var res = $.parseJSON(data);
            $.each(res, function(index, value) {
                label.push(value.sublevel_name);
                sub_data.push(value.total_score);
                prev_data.push(value.prev_total_score);
                last_data.push(value.last_test_score);
            });
            /*if(res.sublevel_data!='')
             {
             $.each(res, function (index, value) {
             label.push(value.sublevel_name);
             sem_score.push(value);
             score.push('10');
             });
             }*/
        },
        error: function(data) {}
    });
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                    label: 'Last score',
                    data: last_data,
                    backgroundColor: 'black',
                    borderWidth: 1,
                    /*xAxisID: 'left-y-axis'*/
                },
                {
                    label: 'Previous score',
                    data: prev_data,
                    backgroundColor: 'rgb(76, 76, 77)',
                    borderWidth: 1,
                    /*xAxisID: 'left-y-axis'*/
                },
                {
                    label: 'Current score',
                    data: sub_data,
                    backgroundColor: '#f69420',
                    borderWidth: 1,
                    /*xAxisID: 'left-y-axis'*/
                }
            ]
        },
        options: {
            tooltips: {
                // Disable the on-canvas tooltip
                enabled: false,
                intersect: true,
                /*callbacks: {
                 label: function(tooltipItem, data) {
                 }
                 },*/

                custom: function(tooltipModel) {
                    var tooltipEl = document.getElementById('chartjs-tooltip');
                    // Create element on first render
                    if (!tooltipEl) {
                        tooltipEl = document.createElement('div');
                        tooltipEl.id = 'chartjs-tooltip';
                        tooltipEl.innerHTML = "<table></table>";
                        document.body.appendChild(tooltipEl);
                    }

                    // Hide if no tooltip
                    if (tooltipModel.opacity === 0) {
                        tooltipEl.style.opacity = 0;
                        return;
                    }

                    // Set caret Position
                    tooltipEl.classList.remove('above', 'below', 'no-transform');
                    if (tooltipModel.yAlign) {
                        tooltipEl.classList.add(tooltipModel.yAlign);
                    } else {
                        tooltipEl.classList.add('no-transform');
                    }

                    function getBody(bodyItem) {
                       
                        return bodyItem.lines;
                    }

                    // Set Text
                    if (tooltipModel.body) {
                        var titleLines = tooltipModel.title || [];
                        var bodyLines = tooltipModel.body.map(getBody);
                        var innerHtml = '<thead>';
                        titleLines.forEach(function(title) {
                            innerHtml += '<tr><th>' + title + '</th></tr>';
                        });
                        innerHtml += '</thead><tbody>';
                        bodyLines.forEach(function(body, i) {
                            var sub_name = tooltipModel.dataPoints[i].xLabel;
                            var index_val = tooltipModel.dataPoints[i].datasetIndex;
                            var total_points = "";
                            var sem_data = [];
                            var sem_points = [];
                            $.ajax({
                                method: 'POST',
                                url: 'get_chart_sub_data',
                                async: false,
                                data: {
                                    index_val: index_val,
                                    sub_name: sub_name,
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(data) {
                                    var res = data;
                                    total_points = res.score_data.total_score;
                                    sem_data = res.score_data.sem_name.split(',');
                                    sem_points = res.sem_score;
                                },
                                error: function(data) {
                                }
                            });
                            //var total_points = "100";
                            var colors = tooltipModel.labelColors[i];
                            var style = 'background:' + colors.backgroundColor;
                            style += '; border-color:' + colors.borderColor;
                            style += '; border-width: 2px';
                            var span = '<span style="' + style + '"></span>';
                            innerHtml += '<tr><td>' + span + 'Total : ' + total_points + ' Points </td></tr>';
                            $.each(sem_data, function(index, value) {
                                innerHtml += '<tr><td>' + span + value + ' : ' + sem_points[index].test_score + ' Points</td></tr>';
                            });
                        });
                        innerHtml += '</tbody>';
                        var tableRoot = tooltipEl.querySelector('table');
                        tableRoot.innerHTML = innerHtml;
                    }

                    // `this` will be the overall tooltip
                    var position = this._chart.canvas.getBoundingClientRect();
                    // Display, position, and set styles for font
                    tooltipEl.style.opacity = 1;
                    tooltipEl.style.position = 'absolute';
                    tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
                    tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                    tooltipEl.style.fontFamily = tooltipModel._bodyFontFamily;
                    tooltipEl.style.fontSize = tooltipModel.bodyFontSize + 'px';
                    tooltipEl.style.fontStyle = tooltipModel._bodyFontStyle;
                    tooltipEl.style.padding = tooltipModel.yPadding + 'px ' + tooltipModel.xPadding + 'px';
                    tooltipEl.style.pointerEvents = 'none';
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    /*var barChartData = {
     labels: label,
     datasets: [{
     label: 'Dataset 1',
     backgroundColor: '#f69420',
     data: [
     10,20,30
     ]
     }, {
     label: 'Dataset 2',
     backgroundColor: '#f69420',
     data: [
     5,20,30
     ]
     }, {
     label: 'Dataset 3',
     backgroundColor: '#f69420',
     data: [
     5,20,30
     ]
     }]
     
     };
     window.onload = function() {
     var ctx = document.getElementById('myChart').getContext('2d');
     window.myBar = new Chart(ctx, {
     type: 'bar',
     data: barChartData,
     options: {
     title: {
     display: true,
     text: 'Chart.js Bar Chart - Stacked'
     },
     tooltips: {
     mode: 'index',
     intersect: false
     },
     responsive: true,
     scales: {
     xAxes: [{
     stacked: true,
     }],
     yAxes: [{
     stacked: true
     }]
     }
     }
     });
     };*/
</script>
<script>
    /*--------- start prev and next link show and hidden ------------*/
    $(document).on('click', '.next_data', function() {
        var next_id = $(this).data('id');
        var sublevelid = $('#sublevelid').val();
        var semesterid = $('#semesterid').val();
        if (next_id == "") {
            i
            swal('Error', 'No Result Found', 'error');
        } else {
            var path = APP_URL + "/user/testdata";
            var child_id = "{{Auth::user()->id}}";
            $.ajax({
                type: 'POST',
                url: path,
                data: {
                    id: next_id,
                    child_id: child_id,
                    sublevelid: sublevelid,
                    semesterid: semesterid
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var res = $.parseJSON(data);
                    if (res.status = "success") {
                        if (!$.isEmptyObject(res.data.testresult)) {
                            let overall_html = "";
                            var DateCreated = moment(res.data.testresult.created_at).format('DD/MM/YYYY');
                            $('.test_date').text('Result ( ' + DateCreated + ' )');
                            if (res.data.testresult.overall_interpretation != '') {
                                $('.overall_inter').html('<div class="user_description">' + res.data.testresult.overall_interpretation + '</div>');
                            } else {
                                $('.overall_inter').html('');
                            }
                            if (res.data.testresult.next_id != "") {
                                $('.next_result_id').html('<button class="ctrl_btn next_data" data-id="' + res.data.testresult.next_id + '"><span class="theme-text">View More Recent Results</span><i class="la la-long-arrow-right"></i></button>');
                            } else {
                                $('.next_result_id').html('<button style="visibility:hidden" class="ctrl_btn"><span class="theme-text">View More Recent Results</span><i class="la la-long-arrow-right"></i></button>');
                            }
                            if (res.data.testresult.prev_id != "") {
                                $('.prev_result_id').html('<button class="ctrl_btn next_data" data-id="' + res.data.testresult.prev_id + '"><i class="la la-long-arrow-left"></i><span class="theme-text">View Previous Results</span></button>');
                            } else {
                                $('.prev_result_id').html('<button style="visibility:hidden" class="ctrl_btn"><span class="theme-text">View Previous Results</span><i class="la la-long-arrow-left"></i></button>');
                            }

                        }
                        if (!$.isEmptyObject(res.data.category_result)) {

                            $.each(res.data.category_result, function(key, values) {
                                $('.category_name_' + values.category_id).html(values.category_name);
                                $('.category_score_' + values.category_id).html(values.score + '%');
                                $('.category_progress_' + values.category_id).css('width', values.score + '%');
                                $('.cat_score_' + values.category_id).html('<div class="c100 p' + values.score + ' small"><span>' + values.score + '%</span><div class="slice"><div class="bar"></div><div class="fill"></div></div></div>');
                                $('.cat_interpretation_' + values.category_id).html(values.interpretation);
                            });
                        }
                    }
                },
                error: function(data) {
                    swal('Error', data, 'error');
                    return false;
                }
            });
        }
    });
    /*-------- Start code for onchange sublevel --*/

    $('#sublevelid').on('change', function() {
        var path = APP_URL + "/sublevels/get_semester";
        var sublevelid = $('#sublevelid').val();
        if (sublevelid == '') {
            swal("Error", "Please select your sub level", "error");
            return false;
        }
        $.ajax({
            method: 'POST',
            url: path,
            data: {
                sublevelid: sublevelid,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                var res1 = $.parseJSON(data);
                var semesters = "";
                $.each(res1.data, function(key, val) {
                    if (key == 0) {
                        semesters += "<option value=" + val.id + " selected>" + val.sem_name + "</option>";
                    } else {
                        semesters += "<option value=" + val.id + " >" + val.sem_name + "</option>";
                    }
                });
                $('#semesterid').html(semesters);
                getSublevelResult();
            },
            error: function(data) {
                swal('Error', data, 'error');
            }
        });
    });
    /*-------- End code for onchange sublevel --*/

    /*----- Start sublevel and semster result ---*/
    function getSublevelResult() {
        var path = APP_URL + "/insight/getSublevelSemresult";
        var sublevelid = $('#sublevelid').val();
        var semesterid = $('#semesterid').val();
        $.ajax({
            method: 'POST',
            url: path,
            data: {
                sublevelid: sublevelid,
                semesterid: semesterid,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                var res = $.parseJSON(data);
                if (res.status == 'success') {
                    $(".m-widget1__item").css('display', 'block');
                    if (!$.isEmptyObject(res.data.testresult)) {
                        let overall_html = "";
                        var DateCreated = moment(res.data.testresult.created_at).format('DD/MM/YYYY');
                        $('.test_date').text('Result ( ' + DateCreated + ' )');
                        if (res.data.testresult.overall_interpretation != '') {
                            $('.overall_inter').html('<div class="user_description">' + res.data.testresult.overall_interpretation + '</div>');
                        } else {
                            $('.overall_inter').html('');
                        }
                        if (res.data.testresult.next_id != "") {
                            $('.next_result_id').html('<button class="ctrl_btn next_data" data-id="' + res.data.testresult.next_id + '"><span class="theme-text">View More Recent Result</span><i class="la la-long-arrow-right"></i></button>');
                        } else {
                            $('.next_result_id').html('<button style="visibility:hidden" class="ctrl_btn"><span class="theme-text">View More Recent Result</span><i class="la la-long-arrow-right"></i></button>');
                        }
                        if (res.data.testresult.prev_id != "") {
                            $('.prev_result_id').html('<button class="ctrl_btn next_data" data-id="' + res.data.testresult.prev_id + '"><i class="la la-long-arrow-left"></i><span class="theme-text">View Previous Results</span></button>');
                        } else {
                            $('.prev_result_id').html('<button style="visibility:hidden" class="ctrl_btn"><span class="theme-text">View Previous Results</span><i class="la la-long-arrow-left"></i></button>');
                        }
                    }
                    if (!$.isEmptyObject(res.data.category_result)) {
                        $.each(res.data.category_result, function(key, values) {
                            $('.category_name_' + values.category_id).html(values.category_name);
                            $('.category_score_' + values.category_id).html(values.score + '%');
                            $('.category_progress_' + values.category_id).css('width', values.score + '%');
                            $('.cat_score_' + values.category_id).html('<div class="c100 p' + values.score + ' small"><span>' + values.score + '%</span><div class="slice"><div class="bar"></div><div class="fill"></div></div></div>');
                            $('.cat_interpretation_' + values.category_id).html(values.interpretation);
                        });
                        $(".whithout_test_overlay").css('display', 'none');
                    }
                } else if (res.status == 'error') {
                    $.each(res.data.category_result, function(key, values) {
                        $('.category_name_' + values.category_id).html(values.category_name);
                        $('.category_score_' + values.id).html(0 + '%');
                        $('.category_progress_' + values.id).css('width', 0 + '%');
                        $('.cat_score_' + values.id).html('<div class="c100 p0 small"><span>0%</span><div class="slice"><div class="bar"></div><div class="fill"></div></div></div>');
                        $('.m-widget1__desc_other').html('');
                    });
                    $("#c_result").empty();
                    $(".next_result_id").html('');
                    $(".prev_result_id").html('');
                    $(".overall_inter").html('');
                    var cat_length = $('#cat_length').val();
                    $i = 0;
                    for (i = 0; i <= cat_length; i++) {
                        $(".category_score_" + $i).html('0%');
                        $(".category_progress_" + $i).css('width', '0%');
                        $i++;
                    }
                    var mytext = "";
                    mytext += '<div class="whithout_test_overlay">' +
                        '<button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" data-type="2" onclick="taketestview()">Take FAST</button></div>'
                    $(".whithout_test_overlay").remove();
                    $(".whithout_test_1").after(mytext);
                    $(".whithout_test_2").after(mytext);
                    //            $(".m-widget1__item").css('display', 'none');
                    ////            swal('Error', res.message, 'error');
                }

            },
            error: function(data) {
                swal('Error', data, 'error');
            }
        });
    }
    /*---- End sublevel and semester result -----*/
</script>
@endsection