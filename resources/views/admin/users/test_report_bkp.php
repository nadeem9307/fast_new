@extends('layouts.admin')

@section('page_title') 
User Report
@endsection 

@section('page_css')

@endsection


@section('content')

<!-- BEGIN: Subheader -->


<div class="m-subheader "> 
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Users report
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="{{ url('/users')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Users
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div>
 
    </div>
</div>
<!-- END: Subheader -->
<div class="dashboard m-grid__item m-grid__item--fluid m-wrapper user_report">
    <!-- BEGIN: Subheader -->

    <div class="m-content download_section">
        <!--Begin::Main Portlet-->
        <div class="m-portlet user_portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding">
                    <div class="col-xl-4 col-md-4 text-center">
                        <div class="user_main_img">
                        <img src="{{url('public/assets/demo/demo5/media/img/user.svg')}}" class="img-responsive user_img">
                            </div>
                    </div>
                    <div class="col-xl-8  col-md-8">

                        <div class="user_info_data">
                            <div class="m-widget1">
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">
                                                Name
                                            </h3>

                                        </div>
                                        <div class="col m--align-right">
                                            <span class="m-widget1__number m--font-brand" id="user_name" data-userid="{{$user->id}}">
                                                {{$user->name}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">
                                                Username
                                            </h3> 
                                        </div>
                                        <div class="col m--align-right">
                                            <span class="m-widget1__number m--font-info">
                                                {{$user->username}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">
                                                Email
                                            </h3> 
                                        </div>
                                        <div class="col m--align-right">
                                            <span class="m-widget1__number m--font-success">
                                                {{$user->email}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-widget25">
                            <div class="m-widget25--progress" id="category_wise_score">
                                <div class="m-widget25__progress">
                                    <span class="m-widget25__progress-number" id="over_all_score">
                                        @if($testresult == '')
                                        0%
                                        @else
                                        {{$testresult->score}}%
                                        @endif
                                    </span>
                                    <div class="m--space-10">
                                    </div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-success" role="progressbar" style="width:@if($testresult == '') 0% @else {{$testresult->score}}% @endif" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="m-widget25__progress-sub">
                                        Fast Score
                                    </span>
                                </div>
                                <!-- Start current score for knowledge, habits ans score if test not given -->
                                @if($testresult == '')
                                <div class="m-widget25__progress">
                                    <span class="m-widget25__progress-number">
                                        0%
                                    </span>
                                    <div class="m--space-10">
                                    </div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-danger" role="progressbar" style="width: 1%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="m-widget25__progress-sub">
                                        Knowledge
                                    </span>
                                </div>
                                <div class="m-widget25__progress">
                                    <span class="m-widget25__progress-number">
                                        0%
                                    </span>
                                    <div class="m--space-10">
                                    </div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-accent" role="progressbar" style="width: 1%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="m-widget25__progress-sub">
                                        Habits
                                    </span>
                                </div>
                                <div class="m-widget25__progress">
                                    <span class="m-widget25__progress-number">
                                        0%
                                    </span>
                                    <div class="m--space-10">
                                    </div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-warning" role="progressbar" style="width: 1%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="m-widget25__progress-sub">
                                        Social Pressure Defence
                                    </span>
                                </div>
                                <!-- End category score if test not given -->
                                @elseif(isset($testresult) && (isset($cat_result)))
                                @php
                                $i = 0;
                                @endphp

                                @foreach($cat_result as $cat_results)
                                <div class="m-widget25__progress">
                                    <span class="m-widget25__progress-number">
                                        {{$cat_results['score']}}%
                                    </span>
                                    <div class="m--space-10">
                                    </div>

                                    <div class="progress m-progress--sm">
                                        @if($cat_results['category_name'] == 'Knowledge')
                                        <div class="progress-bar m--bg-danger" role="progressbar" style="width: {{$cat_results['score']}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                        @endif
                                        @if($cat_results['category_name'] == 'Habits')
                                        <div class="progress-bar m--bg-accent" role="progressbar" style="width: {{$cat_results['score']}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                        @endif
                                        @if($cat_results['category_name'] == 'Social Pressure Defence')
                                        <div class="progress-bar m--bg-warning" role="progressbar" style="width: {{$cat_results['score']}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                        @endif
                                    </div>
                                    <span class="m-widget25__progress-sub">
                                        {{$cat_results['category_name']}}
                                    </span>

                                </div>
                                @php
                                $i++;
                                @endphp
                                @endforeach
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-12">

                        <div class="control_heading">
                            <div class="left_control prev_result_id">
                                @if(isset($testresult->prev_id) && $testresult->prev_id!="")
                                <button class="ctrl_btn next_data" data-id="{{$testresult->prev_id}}"><i class="la la-arrow-circle-left"></i><span>Previous Result</span></button>
                                @else
                                <button class="ctrl_btn" style="visibility: hidden;"><i class="la la-arrow-circle-left"></i><span>Previous Result</span></button>
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
                                <button class="ctrl_btn next_data" data-id="{{$testresult->next_id}}"><span>Next Result</span><i class="la la-arrow-circle-right"></i></button>
                                @else
                                <button class="ctrl_btn" style="visibility: hidden;"><i class="la lla-arrow-circle-right"></i><span>Next Result</span></button>
                                @endif
                            </div>                          
                        </div>

                        @if(isset($testresult->interpretation))
                        <div class="user_description">
                            {{$testresult->long_summary}}
                        </div>
                        @endif
                    </div>
                    <div class="col-xl-12" id="allbase">
                        @if(!empty($cat_result))
                        @foreach($cat_result as $category_score_data)
                        <div class="user_progress_bar">
                            <div class="m-widget14">
                                <div class="m-widget14__header  text-center">

                                    <h3 class="m-widget14__title category_name_{{$category_score_data['category_id']}}">
                                        <!--   KNOWLEDGE-->
                                        {{$category_score_data['category_name']}}
                                    </h3>
                                    <span class="m-widget14__desc">
                                        Check out each collumn for more details
                                    </span>
                                </div>

                                <div class="m-widget14__bar m--margin-bottom-30 text-center">
                                    <div class="bar">
                                        <div class="left category_left_{{$category_score_data['category_id']}}" style="width:{{100 - $category_score_data['score']}}%">
                                            <div class="count category_left_count_{{$category_score_data['category_id']}}">{{100 - $category_score_data['score']}}%
                                            </div>
                                            <span class="hidden-xs">Extraverted
                                            </span>
                                        </div>
                                        <div class="right active category_right_{{$category_score_data['category_id']}}" style="width: {{$category_score_data['score']}}%">
                                            <div class="count category_right_count_{{$category_score_data['category_id']}}">{{$category_score_data['score']}}%
                                            </div>
                                            <span class="hidden-xs">Introverted
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget14__footer text-center">
            <!--                                    <p>Is able to take financial decisions without being too influenced by peers although may still prefer to follow the trend.
                                        Able to apply most financial concepts and knowledge to real life situations.
                                    </p>-->
                                    <p class="interpretation text-center cat_interpretation_{{$category_score_data['category_id']}}">
                                        {{$category_score_data['interpretation']}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                </div>
                <!-- Start Bottom Knowledge base -->

                <!-- End Bottom Knowledge base -->
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('page_script')
<script>
    /*--------- start prev and next link show and hidden ------------*/
    $(document).on('click', '.next_data', function () {
        var next_id = $(this).data('id');
        var userid = $('#user_name').attr('data-userid');
        if (next_id == "")
        {
            swal('Error', 'No Result Found', 'error');
        } else
        {
            var path = APP_URL + "/get_user/test_data";
            $.ajax({
                type: 'POST',
                url: path,
                data: {
                    id: next_id,
                    child_id: userid
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var res = $.parseJSON(data);
                    //console.log(res); 
                    if (res.status = "success")
                    {
                        if (!$.isEmptyObject(res.data.testresult))
                        {
                            let overall_html = "";
                            var DateCreated = moment(res.data.testresult.created_at).format('DD/MM/YYYY');
                            $('.test_date').text('Result ( ' + DateCreated + ' )');
                            if (res.data.testresult.next_id != "")
                            {
                                $('.next_result_id').html('<button class="ctrl_btn next_data" data-id="' + res.data.testresult.next_id + '"><span>Next Result</span><i class="la la-arrow-circle-right"></i></button>');
                            } else
                            {
                                $('.next_result_id').html('<button style="visibility:hidden" class="ctrl_btn"><span>Next Result</span><i class="la la-arrow-circle-right"></i></button>');
                            }
                            if (res.data.testresult.prev_id != "")
                            {
                                $('.prev_result_id').html('<button class="ctrl_btn next_data" data-id="' + res.data.testresult.prev_id + '"><i class="la la-arrow-circle-left"></i><span>Previous Result</span></button>');
                            } else
                            {
                                $('.prev_result_id').html('<button style="visibility:hidden" class="ctrl_btn"><span>Previous Result</span><i class="la la-arrow-circle-left"></i></button>');
                            }

                        }
                        if (!$.isEmptyObject(res.data.category_result))
                        {
                            var overall_score = '<div class="m-widget25__progress"><span class="m-widget25__progress-number">' + res.data.testresult.score + '%</span><div class="m--space-10"></div>'
                                    + '<div class="progress m-progress--sm"><div class="progress-bar m--bg-success" role="progressbar" style="width:' + res.data.testresult.score + '%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div> </div><span class="m-widget25__progress-sub">Fast Score </span></div>';
                            var category_wise_score = '';
                            $.each(res.data.category_result, function (key, values) {
                                category_wise_score += '<div class="m-widget25__progress"><span class="m-widget25__progress-number"> ' + (values.score) + '% </span><div class="m--space-10"></div>'
                                        + '<div class="progress m-progress--sm"><div class="progress-bar  cat' + [key] + '" role="progressbar" style="width:' + (values.score) + '%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                        + '<span class="m-widget25__progress-sub">' + (values.category_name) + '</span></div>';
                                +'<span class="m-widget25__progress-sub">' + (values.category_name) + '</span>';
                                $('.category_name_' + values.category_id).html(values.category_name);
                                $('.category_left_' + values.category_id).css('width', (100 - values.score) + '%');
                                $('.category_left_count_' + values.category_id).html((100 - values.score));
                                $('.category_right_' + values.category_id).css('width', values.score + '%');
                                $('.category_right_count_' + values.category_id).html(values.score);
                                $('.cat_interpretation_' + values.category_id).html(values.interpretation);
                            });
                            $('#category_wise_score').html(overall_score + category_wise_score);
                            $('.cat0').addClass('m--bg-danger');
                            $('.cat1').addClass('m--bg-accent');
                            $('.cat2').addClass('m--bg-warning');
                        }
                    }
                },
                error: function (data) {
                    swal('Error', data, 'error');
                    return false;
                }
            });
        }
    });



</script>
@endsection