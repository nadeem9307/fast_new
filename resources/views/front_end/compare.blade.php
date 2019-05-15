@extends('layouts.app_new')
@section('page_title') 
Compare
@endsection 
@section('page_css')
<style>
  @media (max-width: 767px) {
    .rank_table {
      margin-top: 40px;
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
        <div class="container">
        <div class="row">
          <div class="col-md-6">
              <div class="rank_table">
                <div class="table_heading"> 
                    <h2>Your Ranking</h2>
                    </div>
              <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
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
                  <tbody> 
                    @if(!empty($country_result))
                    @foreach($country_result as $result)
                    @if(Auth::user()->id==$result['user_id'])
                    <tr class="user_highlight">
                    @else
                    <tr>
                    @endif
                        <td>#{{$result['Rank']}}</td>
                        <td>{{$result['username']}}</td>
                        <td>{{$result['fast_score']}} / 100</td>
                    </tr>
                    @endforeach
                    @endif
                    @if($user_result)
                    <tr class="user_highlight">
                        <td>#{{$user_result->Rank}}</td>
                        <td>{{$user_result->username}}</td>
                        <td>{{$user_result->fast_score}} / 100</td>
                    </tr>
                    @endif
                    @if(!$user_result && empty($country_result))
                    <tr>
                        <td colspan="3" class="text-center">No Data Found</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
            </div> 
          </div>
          <div class="col-md-6">
              <div class="rank_table">
                <div class="table_heading"> 
                    <h2>Friend Ranking</h2>
                    <a href="{{url('manage_request/2')}}" class="btn m-btn add_friend_btn">
                                      
                                         <i class="la la-user-plus"></i> Add Friend
                                        
                                      </a>
                    </div>
              <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
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
                  <tbody> 
                    @if(!empty($friend_result))
                    @foreach($friend_result as $result) 
                    @if(Auth::user()->id==$result['user_id'])
                    <tr class="user_highlight">
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
          <div class="col-xl-12 text-center mt-5">
            <div class="table_heading"> 
              <h2>GLOBAL RANKING HISTORICAL  FAST  SCORE</h2>
            </div>
            <canvas id="barchart" style="width: 100%;"></canvas>
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
<style type="text/css">
    tr.user_highlight {
        background: rgba(246, 148, 32, 0.2784313725490196);
    }
    .header_btn
    {
        padding: 2px 15px;
        font-size: 15px;
    }
</style>
<script>
    /*---- Start bar chart js ------*/
    var chart_data = "";
    var total_scores = '';
    var id = "{{Auth::user()->id}}";

    $.ajax({
        method: 'POST',
        url: 'get_global_chart_data',
        async: false,
        data: {
            id: id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            var res = $.parseJSON(data);
            chart_data = res.scores;
            total_scores = res.your;
        },
        error: function (data) {
        }
    });
    var score = [];
    var country = [];
    var backgroundColor = [];

    if (chart_data != '') {
        var i = 1;
        $.each(chart_data, function (index, value) {
            if (value.score != '' || value.country_name != '' && chart_data.Your == '') {
                score.push(value.score);
                country.push(value.country_name);
                backgroundColor.push('rgb(246, 148, 32)');
            }
            i++;
        });
        if (total_scores != '') {
            score.push(total_scores);
            country.push('My Score');
            backgroundColor.push('rgb(76, 76, 77)');
        }

    }
    //== Class definition
    var ctx = document.getElementById("barchart");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: country,
            datasets: [{
                    label: 'Average Fast score',
                    data: score,
                    backgroundColor: backgroundColor,
                    borderWidth: 1
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
    /*---- End bar chart js ------*/

</script>
@endsection