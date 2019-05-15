@extends('layouts.app_new')
@section('page_title')
@if(Auth::user()->user_type=='2')Child @else Friend @endif
@endsection
@section('page_css')

@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
  <div class="m-content download_section">
    <!--Begin::Main Portlet-->
    <div class="m-portlet user_portlet">
      <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="mt-2">
          <a href="@if(Auth::user()->user_type=='2'){{url('manage_request/1')}} @else {{url('manage_request/2')}} @endif ">
            <button class="btn m-btn child_list_btn"><i class="fa fa-file-text-o"></i> View @if(Auth::user()->user_type=='2')Child @else Friend @endif List</button>
          </a>
        </div>
        <div class="container">
          <div class="row dashboard_top">
            <div class="col-md-12">
              <div class="control_heading no_padding">
                <div class="left_control">
                  @if($prev_child_id!='')
                  <a href="{{url('child/').'/'.$prev_child_id}}">
                    <button class="ctrl_btn"><i class="la la-long-arrow-left"></i><span class="theme-text">Previous</span></button>
                  </a>
                  @endif

                </div>
                <div class="main_heading" id="">

                </div>
                <div class="right_control">
                  @if($next_child_id!='')
                  <a href="{{url('child/').'/'.$next_child_id}}">
                    <button class="ctrl_btn"><span class="theme-text">Next</span><i class="la la-long-arrow-right"></i></button>
                  </a>
                  @endif
                  <input type="hidden" id="child_id" name="child_id" value="{{$childrecord->id}}">
                </div>
              </div>
            </div>
            <div class="col-md-4 text-center">
              <div class="user_main_img child_img mb-5">
                @if(isset($user->instructor_avatar) && $user->instructor_avatar !='')
                                <img src="{{asset('storage/'.$user->instructor_avatar)}}" class="img-responsive user_img">
                                @elseif(isset($images['images']) && !empty($images['images']))
                                <img src="{{asset('storage/app/levelavatar/'.$images['dir']['subdir'].'/'.$images['images'][0])}}" class="img-responsive user_img">
                                @else
                                <img src="{{url('public/assets/demo/demo5/media/img/user.svg')}}" class="img-responsive user_img">
                                @endif
              </div>
            </div>
            <div class="col-md-4">
              <div class="table_heading">
                <h3>&nbsp;</h3>
              </div>
              <div class="user_info">
                <h4>Hey {{$childrecord->name}} <br>
                  @if(isset($summary->summary) && $summary->summary!="") <span> You are a - <strong>{{$summary->summary}}</strong>
                  </span> @endif
                </h4>
                <div class="user_info_data">
                  <div class="m-widget1">
                    <div class="m-widget1__item">
                      <div class="row m-row--no-padding align-items-center">
                        <div class="col">
                          <h3 class="m-widget1__title">
                            Name
                          </h3>
                        </div>
                        <div class="col m--align-left">
                          <span class="m-widget1__number">
                            {{$childrecord->name}}
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="m-widget1__item">
                      <div class="row m-row--no-padding align-items-center">
                        <div class="col">
                          <h3 class="m-widget1__title">
                            User Name
                          </h3>
                        </div>
                        <div class="col m--align-left">
                          <span class="m-widget1__number">
                            {{$childrecord->username}}
                          </span>
                        </div>
                      </div>
                    </div>
<!--                    <div class="m-widget1__item">
                      <div class="row m-row--no-padding align-items-center">
                        <div class="col">
                          <h3 class="m-widget1__title">
                            Email
                          </h3>
                        </div>
                        <div class="col m--align-left">
                          <span class="m-widget1__number">
                            {{$childrecord->email}}
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
              </div>
            </div>
            <div class="col-md-4">
              <div class="rank_table">
                <div class="table_heading">
                  <h3>Comparing your @if(Auth::user()->user_type == '2') child @else friend @endif & friends:</h3>
                </div>
                <table class="table m-table m-table--border-brand m-table--head-bg-brand">
                  <thead>
                    <tr>
                      <th class="text-center">
                        Rank
                      </th>
                      <th class="text-center">
                        User Name
                      </th>
                      <th class="text-center">
                        Score
                      </th>
                    </tr>
                  </thead>
                  <tbody id="next_child_record">
                    @if(!empty($child_result))
                    @foreach($child_result as $result)
                    @if($childrecord->id==$result['user_id'])
                    <tr class="user_result_data">
                      @else
                    <tr>
                      @endif
                      <td>#{{$result['Rank']}}</td>
                      <td>{{$result['username']}}</td>
                      <td>{{$result['fast_score']}} / 100</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="3" class="text-center">No Data Found</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="progress_row">
          <div class="container">
            <div class="row align-items-center m-row--no-padding">
              <div class="col-md-3 text-center">
                <button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" onclick="sendRetestRequest('{{$childrecord->id}}')">
                  Request Re-test
                </button>
              </div>
              <div class="col-md-9">
                <div class="m-widget25">

                  <div class="m-widget25--progress">
                    <div class="m-widget25__progress">
                      <span class="m-widget25__progress-number">
                        {{$childrecord->fast_score}}%
                      </span>

                      <span class="m-widget25__progress-sub">
                        Fast Score
                      </span>
                      <div class="progress m-progress--sm">
                        <div class="progress-bar" role="progressbar" style="width:{{$childrecord->fast_score}}%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
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
          <div class="col-xl-12 overall_inter">
            @if(isset($testresult->overall_interpretation) && $testresult->overall_interpretation!="")
            <div class="user_description">
              {{$testresult->overall_interpretation}}
            </div>
            @endif
          </div>

          <div class="col-sm-12">
            @if($testresult)
            <div class="control_heading">
              @else
              <div class="control_heading no_padding" style="display:none;">
                @endif
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
                        <!-- <div class="c100 p{{100 - $category_score_data['score']}} small">
                            <span>{{100 - $category_score_data['score']}}%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                            <div class="c100-title">Extraverted</div>
                        </div>  -->
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
                      <button class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom" onclick="sendRetestRequest('{{$childrecord->id}}')">
                        Request Re-test
                      </button>
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
  @section('page_script')
  <script>
    $(document).on('click', '.next_data', function() {
      var next_id = $(this).data('id');
      if (next_id == "") {
        swal('Error', 'No Result Found', 'error');
      } else {
        var path = APP_URL + "/user/testdata";
        var child_id = $('#child_id').val();
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
                $('.over_all_score').html(res.data.testresult.score + ' %');
                $('.overall_progress').css('width', res.data.testresult.score + ' %');
                $('.overall_interpretation').text(res.data.testresult.overall_interpretation);
                if (res.data.testresult.overall_interpretation != '') {
                  $('.overall_inter').html('<div class="user_description">' + res.data.testresult.overall_interpretation + '</div>');
                } else {
                  $('.overall_inter').html('');
                }
                var DateCreated = moment(res.data.testresult.created_at).format('DD/MM/YYYY');
                $('.test_date').text('Result ( ' + DateCreated + ' )');
                if (res.data.testresult.next_id != "") {
                  $('.next_result_id').html('<button class="ctrl_btn next_data" data-id="' + res.data.testresult.next_id + '"><span class="theme-text">View More Recent Results</span><i class="la la la-long-arrow-right"></i></button>');
                } else {
                  $('.next_result_id').html('<button style="visibility:hidden" class="ctrl_btn"><span class="theme-text">View More Recent Results</span><i class="la la la-long-arrow-right"></i></button>');
                }
                if (res.data.testresult.prev_id != "") {
                  $('.prev_result_id').html('<button class="ctrl_btn next_data" data-id="' + res.data.testresult.prev_id + '"><i class="la la la-long-arrow-left"></i><span class="theme-text">View Previous Results</span></button>');
                } else {
                  $('.prev_result_id').html('<button style="visibility:hidden" class="ctrl_btn"><span class="theme-text">View Previous Results</span><i class="la la la-long-arrow-left"></i></button>');
                }

              }
              if (!$.isEmptyObject(res.data.category_result)) {

                $.each(res.data.category_result, function(key, values) {
                  /*$('.category_score_'+values.category_id).html(values.score+' %');
                  $('.category_progress_'+values.category_id).css('width',values.score+'%');
                  $('.category_name_'+values.category_id).html(values.category_name);
                  $('.category_left_'+values.category_id).css('width',(100-values.score)+'%');
                  $('.category_left_count_'+values.category_id).html((100-values.score));
                  $('.category_right_'+values.category_id).css('width',values.score+'%');
                  $('.category_right_count_'+values.category_id).html(values.score);
                  $('.cat_interpretation_'+values.category_id).html(values.interpretation);*/
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

    /********************************Send Retest Request *************/

    /*----- Send Retest Request----------------------*/
    function sendRetestRequest(id) {
      var path = APP_URL + "/test/request";
      swal({
          title: "Are you sure to send request for Retest?",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-info",
          confirmButtonText: "Yes, Send it!",
          closeOnConfirm: false
        },
        function(isConfirm) {
          if (isConfirm) {
            $.ajax({
              type: 'POST',
              url: path,
              data: {
                id: id,
              },
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                  swal('Error', res.message, 'error');
                } else {
                  $('.sweet-overlay').remove();
                  $('.showSweetAlert ').remove();
                  swal("Success", res.message, "success");
                }
              },
              error: function(data) {
                swal('Error', data.message, 'error');
                return false;
              }
            });
          }
        });
    }
  </script>
  @endsection