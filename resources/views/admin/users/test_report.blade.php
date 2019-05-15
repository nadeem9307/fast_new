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
                    <a href="{{ url('/home')}}" class="m-nav__link m-nav__link--icon">
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
<div class="dashboard m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->

    <div class="m-content download_section">
    <!--Begin::Main Portlet-->
    <div class="m-portlet user_portlet">
      <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="container">
        <div class="row m-row--no-padding dashboard_top">
          <div class="col-md-7 text-center">
              <div class="user_main_img mb-5">
                  <img src="{{url('public/assets/demo/demo5/media/img/user.svg')}}" class="img-responsive user_img">                        
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
<!--                <div class="m-widget1__item">
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
<!--                <div class="m-widget1__item">
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
                
              </div>
            </div> 
          </div>
          
          </div>
        </div>
      </div>
      <div class="progress_row">
      <div class="container">
        <div class="row align-items-center m-row--no-padding">
          <div class="col-md-12"> 
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
                            <div class="c100-title">Introverted</div>
                        </div>
                      </div>
                      </div>
                  </div>
                  @endforeach
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
@endsection

@section('page_script')
<!-- <link rel="stylesheet" href="{{url('public/assets/demo/demo5/base/custom.css')}}" /> -->
<link href="{{ url('public/assets/demo/demo5/base/circle.css')}}" rel="stylesheet" type="text/css" />
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