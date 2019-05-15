@extends('layouts.app')
@section('page_title') 
Child   
@endsection 

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->

    <div class="m-content download_section">
        <!--Begin::Main Portlet-->
        <div class="m-portlet user_portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-4 text-center">
                        <img src="{{url('public/assets/demo/demo5/media/img/user.svg')}}" class="img-responsive user_img">
                        <button type="button" class="btn m-btn--square btn-retake btn-primary btn-lg m-btn m-btn--custom">
                            Re-take FAST
                        </button>
                    </div>
                    <div class="col-xl-8">
                        <div class="user_info">
                            <h4>Hey {{Auth::user()->name}} - You are the 
                                <span>logistics
                                </span>
                            </h4>
                        </div>
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
                                            <span class="m-widget1__number m--font-brand">
                                                {{Auth::user()->name}}
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
                                                {{Auth::user()->username}}
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
                                                 {{Auth::user()->email}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-widget25">
                            <div class="m-widget25--progress">
                                <div class="m-widget25__progress">
                                    <span class="m-widget25__progress-number">
                                        13%
                                    </span>
                                    <div class="m--space-10">
                                    </div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-success" role="progressbar" style="width: 63%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="m-widget25__progress-sub">
                                        Fast Score
                                    </span>
                                </div>
                                <div class="m-widget25__progress">
                                    <span class="m-widget25__progress-number">
                                        63%
                                    </span>
                                    <div class="m--space-10">
                                    </div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-danger" role="progressbar" style="width: 63%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="m-widget25__progress-sub">
                                        Knowledge
                                    </span>
                                </div>
                                <div class="m-widget25__progress">
                                    <span class="m-widget25__progress-number">
                                        39%
                                    </span>
                                    <div class="m--space-10">
                                    </div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-accent" role="progressbar" style="width: 39%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="m-widget25__progress-sub">
                                        Habits
                                    </span>
                                </div>
                                <div class="m-widget25__progress">
                                    <span class="m-widget25__progress-number">
                                        54%
                                    </span>
                                    <div class="m--space-10">
                                    </div>
                                    <div class="progress m-progress--sm">
                                        <div class="progress-bar m--bg-warning" role="progressbar" style="width: 54%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="m-widget25__progress-sub">
                                        Social Pressure Defence
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="user_description">
                            <p>Score reflects an acceptable knowledge of personal financial decision making in relation to personal and family saving, budgeting, smart
                                buying and investing, managing debt.
                            </p>
                            <p>Good understanding of financial concepts.
                            </p>
                            <p>Is able to take financial decisions without being too influenced by peers although may still prefer to follow the trend.
                            </p>
                            <p>Able to apply most financial concepts and knowledge to real life situations.
                            </p>
                            <p>Displays possession of good and sound money habits and attitude.
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="user_progress_bar">
                            <div class="m-widget14">
                                <div class="m-widget14__header  text-center">
                                    <h3 class="m-widget14__title">
                                        KNOWLEDGE
                                    </h3>
                                    <span class="m-widget14__desc">
                                        Check out each collumn for more details
                                    </span>
                                </div>
                                <div class="m-widget14__bar m--margin-bottom-30 text-center">
                                    <div class="bar">
                                        <div class="left" style="width:30%;">
                                            <div class="count">30%
                                            </div>
                                            <span class="hidden-xs">Extraverted
                                            </span>
                                        </div>
                                        <div class="right active" style="width:70%;">
                                            <div class="count">70%
                                            </div>
                                            <span class="hidden-xs">Introverted
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget14__footer text-center">
                                    <p>Is able to take financial decisions without being too influenced by peers although may still prefer to follow the trend.
                                        Able to apply most financial concepts and knowledge to real life situations.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="user_progress_bar">
                            <div class="m-widget14">
                                <div class="m-widget14__header  text-center">
                                    <h3 class="m-widget14__title">
                                        HABIT
                                    </h3>
                                    <span class="m-widget14__desc">
                                        Check out each collumn for more details
                                    </span>
                                </div>
                                <div class="m-widget14__bar m--margin-bottom-30 text-center">
                                    <div class="bar">
                                        <div class="left" style="width:60%;">
                                            <div class="count">60%
                                            </div>
                                            <span class="hidden-xs">Extraverted
                                            </span>
                                        </div>
                                        <div class="right active" style="width:40%;">
                                            <div class="count">40%
                                            </div>
                                            <span class="hidden-xs">Introverted
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget14__footer text-center">
                                    <p>Is able to take financial decisions without being too influenced by peers although may still prefer to follow the trend.
                                        Able to apply most financial concepts and knowledge to real life situations.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="user_progress_bar">
                            <div class="m-widget14">
                                <div class="m-widget14__header  text-center">
                                    <h3 class="m-widget14__title">
                                        SOCIAL PRESSURE DEFENECE
                                    </h3>
                                    <span class="m-widget14__desc">
                                        Check out each collumn for more details
                                    </span>
                                </div>
                                <div class="m-widget14__bar m--margin-bottom-30 text-center">
                                    <div class="bar">
                                        <div class="left" style="width:20%;">
                                            <div class="count">20%
                                            </div>
                                            <span class="hidden-xs">Extraverted
                                            </span>
                                        </div>
                                        <div class="right active" style="width:80%;">
                                            <div class="count">80%
                                            </div>
                                            <span class="hidden-xs">Introverted
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget14__footer  text-center">
                                    <p>Is able to take financial decisions without being too influenced by peers although may still prefer to follow the trend.
                                        Able to apply most financial concepts and knowledge to real life situations.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!--        <div class="m-portlet user_portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl"> 
                    <div class="col-xl-6">
                        <div class="user_info text-center rank_table m-portlet__body">
                            <div class="control_heading">
                                <div class="left_control"> </div>
                                <div class="main_heading">Your Ranking</div>
                                <div class="right_control"></div>
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
                                    <tr>
                                        <td>1</td>
                                        <td>Jhon Smith</td>
                                        <td>12/20</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Jhon Smith</td>
                                        <td>12/20</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Jhon Smith</td>
                                        <td>12/20</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                    <div class="col-xl-6">
                        <div class="user_info text-center rank_table m-portlet__body">                         
                            <div class="control_heading">
                                <div class="left_control"><button class="ctrl_btn"><i class="la la-arrow-circle-left"></i><span>Previous Child</span></button> </div>
                                <div class="main_heading">Jhon smith's Ranking</div>
                                <div class="right_control"><button class="ctrl_btn"><span>Next Child</span><i class="la la-arrow-circle-right"></i></button></div>
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
                                    <tr>
                                        <td>1</td>
                                        <td>Jhon Smith</td>
                                        <td>12/20</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Jhon Smith</td>
                                        <td>12/20</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Jhon Smith</td>
                                        <td>12/20</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                    </div> 

                    <div class="col-xl-12 text-center">
                        <div class="m-portlet__body">
                            <div class="control_heading">
                                <div class="left_control"><button class="ctrl_btn"><i class="la la-arrow-circle-left"></i><span>Previous Child</span></button> </div>
                                <div class="main_heading">Global Ranking</div>
                                <div class="right_control"><button class="ctrl_btn"><span>Next Child</span><i class="la la-arrow-circle-right"></i></button></div>
                            </div>
                            <h4 class="text-center">HISTORICAL  FAST  SCORE</h4> 
                            <div class="col-xl-8 col-md-12 mr-auto">
                                <div id="barchart"></div>
                            </div>
                        </div>
                    </div> 
                </div>



            </div>
        </div>-->

<!--        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="m-portlet col-xl-8">
                <div class="m-portlet__body"> 
                    <h4 class="text-center">HISTORICAL  FAST  SCORE</h4> 
                    <div class="mr-auto">
                        <div id="lineChart"></div>
                    </div>
                </div>
            </div>
            <div class="m-portlet col-xl-4 text-center d-flex align-items-center justify-center">
                <button class="btn_circle_large">Retake <br>FAST</button>
            </div>
        </div>-->
<!--        <div class="row m-row--no-padding m-row--col-separator-xl m--margin-bottom-30 result">
            <div class="col-xl-12">
                <div class="control_heading">
                    <div class="left_control"><button class="ctrl_btn"><i class="la la-arrow-circle-left"></i><span>Previous Child</span></button> </div>
                    <div class="main_heading">Result (10/10/2018)</div>
                    <div class="right_control"><button class="ctrl_btn"><span>Next Child</span><i class="la la-arrow-circle-right"></i></button></div>
                </div>

                <div class="user_description">
                    <p>Score reflects an acceptable knowledge of personal financial decision making in relation to personal and family saving, budgeting, smart
                        buying and investing, managing debt.
                    </p>
                    <p>Good understanding of financial concepts.
                    </p>
                    <p>Is able to take financial decisions without being too influenced by peers although may still prefer to follow the trend.
                    </p>
                    <p>Able to apply most financial concepts and knowledge to real life situations.
                    </p>
                    <p>Displays possession of good and sound money habits and attitude.
                    </p>
                </div>
            </div>


        </div>-->

        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="m-portlet col-xl-6">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="la la-download">
                                </i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Download Pending E-Book
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <p>In our free type descriptions you’ll learn what really drives, inspires, and worries other types, helping you build more meaningful relationships.
                    </p>
                    <button class="btn btn-info btn-block">SEE ALL SURVEYS
                    </button>	
                </div>
            </div>
            <div class="m-portlet col-xl-6">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="la la-file">
                                </i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                ABOUT MONEYTREE COURSE
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <p>In our free type descriptions you’ll learn what really drives, inspires, and worries other types, helping you build more meaningful relationships.
                    </p>
                    <button class="btn btn-danger btn-block">ENTER THE ACADEMY
                    </button>	
                </div>
            </div>
        </div>
    </div>
</div>
@endsection