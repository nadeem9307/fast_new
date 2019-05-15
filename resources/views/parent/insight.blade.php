@extends('layouts.app_new')
@section('page_title')
Insight
@endsection
@section('page_css')
<style>
    @media (max-width: 992px) {
        .insight_top {
            padding: 30px 0;
        }
    }

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
                        <a class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" href="{{route('parent_taketest')}}">
                            Take FAST
                        </a>
                        @else
                        <a class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" disabled>
                            Take FAST
                        </a>
                        @endif
                    </div>

                    <div class="col-sm-12">
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
                                            <span class="m-widget25__progress-number fast_score">
                                                @if(!$testresult)
                                                0 %
                                                @else
                                                {{$testresult->score}} %
                                                @endif
                                            </span>

                                            <span class="m-widget25__progress-sub">
                                                Fast Score
                                            </span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar fast_score_bar" role="progressbar" style="width:@if(!$testresult) 0% @else {{$testresult->score}}% @endif" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                        @if($testresult)
                                        @foreach($cat_result as $cat_results)
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number category_score_{{$cat_results['category_id']}}">
                                                {{$cat_results['score']}} %
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
                    <div class="col-xl-12 overall_inter">
                        @if(isset($testresult->overall_interpretation) && $testresult->overall_interpretation!="")
                        <div class="user_description">
                            {{$testresult->overall_interpretation}}
                        </div>
                        @endif
                    </div>
                    <div class="col-xl-12">
                        <div class="m-widget1 c-widget">
                            <div class="m-widget1__item">
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
    var chart_data = "";
    var total_scores = '';
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
            chart_data = res;
        },
        error: function(data) {}
    });
    var score = [];
    var attempt = [];
    if (chart_data != '') {
        var i = 1;
        $.each(chart_data, function(index, value) {
            if (index == '0') {
                score.push("0");
                attempt.push(' ');
                score.push(value.score);
                attempt.push('ATTEMPT 1');
            } else {
                score.push(value.score);
                attempt.push('ATTEMPT ' + i);
            }

            i++;
        });
    } else {
        attempt = ["ATTEMPT 0"];
        score = [0, 0, ];
    }
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: attempt,
            datasets: [{
                label: 'Fast score',
                data: score,
                fill: 'transparent',
                backgroundColor: '#f69420',
                borderColor: '#f69420',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
<script>
    /*-        -------- start prev and next link show and hidden ------------*/
    $(document).on('click', '.next_data', function() {
        var next_id = $(this).data('id');
        if (next_id == "") {
            swal('Error', 'No Result Found', 'error');
        } else {
            var path = APP_URL + "/parent/user/testdata";
            var child_id = "{{Auth::user()->id}}";
            $.ajax({
                type: 'POST',
                url: path,
                data: {
                    id: next_id,
                    child_id: child_id
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
                            $('.fast_score').html(res.data.testresult.score + ' %');
                            $('.fast_score_bar').css('width', res.data.testresult.score + '%');
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
                                $('.prev_result_id').html('<button class="ctrl_btn next_data" data-id="' + res.data.testresult.prev_id + '"><i class="la la-long-arrow-left"></i><span class="theme-text">View Previous Result</span></button>');
                            } else {
                                $('.prev_result_id').html('<button style="visibility:hidden" class="ctrl_btn"><span class="theme-text">View Previous Result</span><i class="la la-long-arrow-left"></i></button>');
                            }

                        }
                        if (!$.isEmptyObject(res.data.category_result)) {

                            $.each(res.data.category_result, function(key, values) {
                                $('.category_name_' + values.category_id).html(values.category_name);
                                $('.category_score_' + values.category_id).html(values.score + ' %');
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
</script>
@endsection