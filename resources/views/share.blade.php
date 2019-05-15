<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>
            Fast Index
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="{{url('public/assets/demo/demo5/base/custom.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/assets/demo/demo5/base/circle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('public/assets/demo/demo5/base/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{url('public/assets/demo/demo5/media/img/logo/favicon.png')}}" />
        <style>
            .background_gradient {
                background-image: linear-gradient(to right, #f69420 0%, #eb5b4c);
            }

            .progress_row
            {
                padding: 30px;
            }

            .mr-auto {
                margin: auto;
            }

            .m-portlet.m-portlet--full-height {
                box-shadow: 0px 1px 15px 1px rgba(140, 140, 140, 0.26);
                margin-bottom: 0;
            }

            .brand_logo_share {
                max-width: 330px;
                margin: auto;
                margin-bottom: 20px;
            }

            .brand_logo_share img {
                width: 100%;
                margin-bottom: 30px;
            }

            .m-card-profile__pic-wrapper {
                margin: 0 !IMPORTANT;
            }

            .m-portlet .m-portlet__body {
                padding: 2.2rem 2.2rem;
            }

            .user_info h2 {
                color: #373737;
                font-size: 25px;
            }

            .user_info h2 span {
                color: #f69420;
                font-weight: bold;
            }

            .m-card-profile .m-card-profile__pic img {
                width: 100px;
                height: 100px;
            }

            .m-card-profile .m-card-profile__pic .m-card-profile__pic-wrapper {
                border: 1px solid #ffb86b;
            }

            .m-card-profile .m-card-profile__details .m-card-profile__name {
                color: #1b1c1e;
                font-size: 2em;
                font-weight: 600;
                margin-top: 10px;
            }

            .m-widget1 .m-widget1__item .m-widget1__number {
                font-size: 7.5rem;
                font-weight: 600;
                color: #ff4343 !important;
                line-height: 1;
            }

            .m-widget1 .m-widget1__item .m-widget1__title {
                font-size: 25px;
                font-weight: 600;
                margin-bottom: 0;
                color: #1b1c1e;
            }

            .m-widget1__title_bottom {
                font-size: 35px;
                color: #f69420;
                margin: 15px 0 0;
                font-weight: 800;
            }

            p.m-widget1__title_details {
                margin-top: 25px;
                color: #1b1b1b;
                font-weight: 400;
                font-size: 18px;
                line-height: 28px;
            }

            h3.m-widget1__title_main {
                margin-bottom: 25px;
                color: #1b1c1e;
                font-weight: 700;
                font-size: 18px;
                line-height: 28px;
            }

            .right_content {
                padding-left: 25px;
            }

            .m-body .m-content {
                padding: 20px 20px;
            }
            .m-widget14 {
                padding: 2.2rem 0;
                padding-bottom: 0;
            }
            .moneytree_logo {
                max-width: 200px;
                position: relative;
                margin-bottom: 15px;
                z-index: 9;
            }
            .footer_section:before {
                -webkit-clip-path: polygon(100% 48%, 0% 100%, 100% 100%);
                clip-path: polygon(100% 0%, 0% 100%, 100% 100%);
                content: '';
                background-image:linear-gradient(to right, #777575 0%, #e6e4e4);
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                right: 0;
                bottom: 0;
                z-index: 9;
            }
            .footer_section{ 
                min-height: 200px;
                display: flex;
                align-items: flex-end;
                justify-content: flex-end;
                position: relative;
                padding: 25px;
            }

            @media (max-width: 768px){
                .right_content {
                    padding-left: 0;
                    padding-top: 10px;
                }
            }

            @media (max-width: 500px){
                .moneytree_logo {
                    max-width: 155px;
                    position: relative;
                    margin-bottom: 0;
                    z-index: 9;
                }
            }

        </style>
    </head>
    <!-- end::Head -->
    <!-- end::Body -->

    <body class="dashboard m-page--wide m-aside--offcanvas-default background_gradient">
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">

            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body">
                <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver m-container m-container--responsive m-container--xxl">
                    <div class="m-grid__item m-grid__item--fluid m-wrapper">

                        <div class="m-content">
                            <div class="m-portlet m-portlet--full-height">
                                <div class="m-portlet__body">
                                    <div class="brand_logo_share">
                                        <img src="{{url('public/assets/demo/demo5/media/img/logo/FastIndexLogo.png')}}" />
                                    </div>
                                    <div class="row m-row--no-padding m-row--col-separator-md">
                                        <div class="col-md-4">
                                            <div class="m-card-profile">
                                                <div class="m-card-profile__pic">
                                                    <div class="m-card-profile__pic-wrapper">
                                                        @if($user_data->avatar!='')
                                                        <img src="{{asset('storage/app/profile/'.$user_data->avatar)}}" alt=""/>
                                                        @else
                                                        <img src="{{url('public/assets/app/media/img/users/user4.jpg')}}" alt="">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="m-card-profile__details">
                                                    <span class="m-card-profile__name">
                                                        {{$user_data->username}}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="m-widget1 m-widget1--paddingless">
                                                <div class="m-widget1__item">
                                                    <div class="row m-row--no-padding align-items-center">

                                                        <div class="m--align-center col-12">
                                                            <span class="m-widget1__number m--font-brand">
                                                                {{$user_data->fast_score}}
                                                            </span>
                                                        </div>
                                                        <div class="m--align-center col-12">
                                                            <h3 class="m-widget1__title">
                                                                Fast Score
                                                            </h3>
                                                            <h2 class="m-widget1__title_bottom">
                                                                @if($summary->summary)
                                                                {{$summary->summary}}
                                                                @endif
                                                            </h2>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-8">
                                            <div class="right_content">
                                                <h3 class="m-widget1__title_main">
                                                    Welcome to MoneyTree's FAST Index assessment- proudly brought to you by courtesy of UOB Malaysia , the Official Bank of the "Money Wise Street Smart Workshop for Children". 
                                                </h3>

                                                <p class="m-widget1__title_details">
                                                    FAST which stands for Financial Aptitude & Success Traits (MoneyTree’s proprietary financial profiling system) is one of the world’s first profiling systems that measures an Individual’s financial aptitude and behaviour towards money. The results will give you an indication of the remedial actions you need to look into and whether you have the propensity to manage your finances well in order to better achieve your financial goals.

                                                </p>
                                                <div class="m-widget25 mt-5 progress_row">
                                                    <div class="m-widget25--progress">
                                                        <div class="m-widget25__progress">
                                                            <span class="m-widget25__progress-number">
                                                                {{$user_data->fast_score}}%
                                                            </span>
                                                            <div class="m--space-10">
                                                            </div>
                                                            <div class="progress m-progress--sm">
                                                                <div class="progress-bar m--bg-success" role="progressbar" style="width: {{$user_data->fast_score}}% " aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                            <span class="m-widget25__progress-sub">Fast Score</span>
                                                        </div>
                                                        <!-- Start current score for knowledge, habits ans score if test not given -->
                                                        @if(!$testresult)
                                                        <div class="m-widget25__progress">
                                                            <span class="m-widget25__progress-number">
                                                                0%
                                                            </span>
                                                            <div class="m--space-10">
                                                            </div>

                                                            <div class="progress m-progress--sm">
                                                                <div class="progress-bar m--bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
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
                                                                <div class="progress-bar m--bg-accent" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
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
                                                                <div class="progress-bar m--bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                            <span class="m-widget25__progress-sub">Social Pressure Defence</span>
                                                        </div>
                                                        @else
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
                                                        @endforeach
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-row--no-padding">
                                        <!-- <div class="col-sm-12">
            @foreach($cat_result as $cat_results)
            <div class="user_progress_bar">
                <div class="m-widget14">
                    <div class="m-widget14__header  text-center">

                        <h3 class="m-widget14__title">
                            {{$cat_results['category_name']}}

                        </h3>
                        <span class="m-widget14__desc">
                            Check out each collumn for more details
                        </span>
                    </div>

                    <div class="m-widget14__bar m--margin-bottom-30 text-center">
                        <div class="bar">
                            <div class="left" style="width:{{100 - $cat_results['score']}}%">
                                <div class="count">{{100 - $cat_results['score']}}%
                                </div>
                                <span class="hidden-xs">Extraverted
                                </span>
                            </div>
                            <div class="right active" style="width: {{$cat_results['score']}}%">
                                <div class="count">{{$cat_results['score']}}%
                                </div>
                                <span class="hidden-xs">Introverted
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="m-widget14__footer text-center">
                        <p class="interpretation">
                            {{$cat_results['interpretation']}}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div> -->
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
                                                            <span class="m-widget1__desc">
                                                                Check out each column to more details
                                                            </span>
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
                                        @php $url = env('APP_URL'); @endphp
                                        <a style="color: #fff;" href="{{$url}}refer/{{$user_data->fast_key}}" class="btn m-btn--square btn-retake btn-primary btn-lg m-btn m-btn--custom mr-auto mt-5">
                                            JOIN TODAY
                                        </a>		
                                    </div>	
                                </div>						
                                <div class="row m-row--no-padding">
                                    <div class="col-sm-12">
                                        <div class="footer_section">
                                            <img src="{{url('public/assets/demo/demo5/media/img/Monytree.png')}}" class="moneytree_logo" >
                                        </div>
                                    </div>
                                </div>	
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- end::Body -->
        </div>
        <!-- end:: Page -->

    </body>
    <!-- end::Body -->

</html>