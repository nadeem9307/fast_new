@extends('layouts.app_new')
@section('page_title') 
Test
@endsection 
@section('page_css')
<style>
    .sort_order {
        padding: 0;
    }
    .ui-sortable-helper {
        background: #f5b76f !important; 
    }
    ul#SortAnswer li { 
        list-style: none;
        background: #fff;
        padding: 15px;
        margin: 3px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        color: #353535;
        border-radius: 0;
        font-size: 18px;
        font-weight: 600;
        padding-left: 15px;
        cursor: move;
    }
    ul.list-group.checked-list-box li {
        font-size: 14px;
    }
    .quiz_note{
        text-align: left;
        padding-left: 0;
        color: #329f30 !important;
    }
    .list-group.checked-list-box {
        text-align: left;
        padding-left: 15px;
        margin-bottom: 5px;
    }

    .display_block{
        display:block;
    }
    .display_inline{
        display: inline;
    }
    .display_none{
        display: none;
    }
   
.question_media video, .question_media audio, .question_media img {
    width: 100%;
}
</style>
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="quiz_timer">
        <h2>Total Time</h2>
        <h3 id="timershow"><time>00:00:00.00</time></h3>
    </div>


    <div class="m-content download_section">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            @if(isset($questions) && !empty($questions[0]))
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-xl-8 mr-auto" id="complete">
                    <form id="SubmitFasttest" onsubmit="return false">
                        @csrf
                        @php $k =1; 
                        @endphp
                        @foreach($questions as $question)
                        @if($k ==1)
                        <div class="tab" id="tab_{{$k}}">
                                <input type="hidden" name="level_id" id="level_id" value="{{$question->level_id}}">
                                <input type="hidden" name="sublevel_id" id="sublevel_id" value="{{$question->sublevel_id}}">
                                <input type="hidden" name="semester_id" id="semester_id" value="{{$question->semester_id}}">
                            @else
                            <div class="tab display_none" id="tab_{{$k}}">
                                @endif
                                <input type="hidden" id="question_type_{{$k}}" value="{{$question->question_type}}">
                                <input type="hidden" name="question_id" id="question_id_{{$k}}" value="{{$question->question_id}}">
                                <!-- start questio image media -->
                                 <div class="question_media">
                                    @if(isset($question->file_attached) && $question->file_attached!="")
                                        @php
                                            $extension = strtolower(pathinfo(storage_path('app/questions/'.$question->file_attached), PATHINFO_EXTENSION));
                                        @endphp
                                        @if($extension=="mp4")
                                            <video id="myVedio" controls>
                                                <source src="{{asset('storage/app/questions/'.$question->file_attached)}}" type="video/mp4">
                                            </video>
                                        @elseif($extension=="mp3")
                                            <audio id="myAudio" controls>
                                                <source src="{{asset('storage/app/questions/'.$question->file_attached)}}" type="audio/mpeg">
                                            </audio>
                                        @else
                                            <img src="{{asset('storage/app/questions/'.$question->file_attached)}}" class="img-responsive user_img">
                                        @endif
                                    @endif
                                </div>
                                <!-- end question image media -->
                                <div class="question_block">
                                    <h4>{{$k}}. {{$question->question_name}}</h4>
                                    @php ($fillanswers = explode("_^@", $question->options))
                                    @if($question->question_type==1)
                                    <div class="question_start" id="AnswersDiv{{$k}}">
                                        @php($ans_no = 1)
                                        @foreach($fillanswers as $answer)
                                        <div class="form-group">
                                            <input type="text" placeholder="Write Your Answer Here..." class="textbox" id="answer{{$k}}" value="">
                                        </div>
                                        @php($ans_no++)
                                        @endforeach

                                    </div>
                                    @elseif($question->question_type==2)
                                    @php($chk_count = 1)
                                    <ul class="chk_list quesDiv{{$k}}">
                                        @foreach($fillanswers as $answer)
                                        <li>
                                            <div class="chk optionbox{{$chk_count}}">
                                                <div class="form-group">
                                                    <input type="checkbox" id="{{'option-'.$chk_count.'-'.$question->question_id.'chk1'}}" class="multi_{{$chk_count}}" data-option{{$chk_count}}="{{$answer}}" value="">
                                                           <label for="{{'option-'.$chk_count.'-'.$question->question_id.'chk1'}}" onclick="CheckCorrectAns($(this).attr('for'))"></label>
                                                </div>
                                            </div>
                                            <div class="chk_lable">{{$answer}}</div>
                                        </li>
                                        @php($chk_count++)
                                        @endforeach
                                    </ul>
                                    @elseif($question->question_type==3)
                                    <div class="question_start clearfix">

                                        <p class="quiz_note">Drag lists to arrange in order</p>
                                        <ul id="SortAnswer" class="sort_order">
                                            @php($j = 1)
                                            @foreach($fillanswers as $ordr)
                                            <li class="custom_checkbox" id="sort_list{{$j.'-'.$question->question_id.'arr'}}" style="cursor: pointer;">{{$ordr}}
                                            </li>
                                            @php($j++)
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                </div>
                               
                            </div>
                            @php ($k++) 
                            @endforeach
                             <div class="progress-wrapper">
                                    <div class="progress-tick" style="left:0">0%</div>
                                    <div class="progress test-progress">
                                        <div class="progress-bar" role="progressbar" style="width:0%">

                                        </div>
                                    </div>
                                </div>
                                 <div class="percentage_footer">
                                         <span>Percentage of Test Completed</span>
                                </div>
                            <span class="step"></span> <span class="step"></span> 
                            <!--</div>-->
                            <div class="text-center next_prev_btn_group " id="test_submit_btn">
                                <button type="button"id="prevBtn"  class="button_2 btn pre_btn m-btn--square btn-retake btn-lg m-btn m-btn--custom" onclick="nextPrev(-1)">
                                    <i class="la la-angle-left"></i>&nbsp;&nbsp;Back
                                </button>
                                <button type="button" id="nextBtn" class="button_1 btn m-btn--square btn-retake btn-primary btn-lg m-btn m-btn--custom" onclick="nextPrev(1)">
                                    Next&nbsp;&nbsp;<i class="la la-angle-right"></i>
                                </button>
                            </div>

                        </div>
                        <div class="custom_loader" id="animation_stop" style="display: none;">
                            <div class="m-spinner m-spinner--brand m-spinner--lg"></div>
                            <p>Please wait while calculating result...</p>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="row m-row--no-padding m-row--col-separator-xl"> 
                <div class="col-xl-8 mr-auto">
                    <div class="congrats_block">
                        <div class="text-center col-xl-12" >
                            <h2>There is no question for this level.</h2>
                            <div class="text-center next_prev_btn_group ">
                                <a href="{{url('overview')}}">
                                    <button type="button" class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom">
                                        Dashboard
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('page_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('public/js/test.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<script>
                                    jQuery.browser = {};
                                    (function () {
                                        jQuery.browser.msie = false;
                                        jQuery.browser.version = 0;
                                        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                                            jQuery.browser.msie = true;
                                            jQuery.browser.version = RegExp.$1;
                                        }
                                    })();
                                    $(".sort_order").sortable({
                                        stop: function (event, ui) {
                                        }
                                    });
                                    function CheckCorrectAns(check_id) {
                                        if ($("#" + check_id).val() == '1') {
                                            $("#" + check_id).val('0');
                                            $("#" + check_id).find($(this), 'chk_list').parent().removeClass('active');
                                        } else {
                                            $("#" + check_id).val('1');
                                            $("#" + check_id).parent().addClass('active');
                                            $("#" + check_id).find($(this), 'chk_list').parent().addClass('active');
                                        }
                                    }
</script>
@endsection