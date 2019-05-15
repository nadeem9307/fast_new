<!DOCTYPE html> 
<html lang="en" > 
<head>
<meta charset="utf-8" />
<title>
Fast Index
</title>
<meta name="description" content="Latest updates and statistic charts">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="{{url('public/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('public/assets/demo/demo5/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
<!--end::Base Styles -->
<link rel="shortcut icon" href="{{url('public/assets/demo/demo5/media/img/logo/favicon.png')}}" />
<style>
.mr-auto{
margin: auto;
}
.m-portlet.m-portlet--full-height {
box-shadow: 0px 1px 15px 1px rgba(140, 140, 140, 0.26);
margin-bottom: 0;
}
.m-body .m-content {
padding: 0;
}
.brand_logo{
max-width: 250px;
margin: auto;
}
.brand_logo img{
width: 100%;
margin: 20px 0; 
}
.m-card-profile__pic-wrapper {
margin: 0 !IMPORTANT;
}
.m-portlet .m-portlet__body {
padding: 2.2rem 2.2rem;
}
.user_info h2{
color: #373737;
font-size: 25px;
}
.user_info h2 span {
color: #f69420;
font-weight: bold;
}
</style>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--wide m-aside--offcanvas-default" >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">

<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body">
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver m-container m-container--responsive m-container--xxl">
<div class="m-grid__item m-grid__item--fluid m-wrapper">



<div class="m-content">
<div class="row m-row--no-padding">
<div class="col-xl-7 col-md-7 col-sm-9 col-12 mr-auto">
<div class="m-portlet m-portlet--full-height ">
<div class="m-portlet__body">
<div class="brand_logo">
<img src="{{url('public/assets/demo/demo5/media/img/logo/FastIndexLogo.png')}}" />
</div>
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
<a href="" class="m-card-profile__email m-link">
{{$user_data->email}}
</a>
</div>
</div> 
<div class="m-portlet__body-separator"></div>
<div class="m-widget1 m-widget1--paddingless">
<div class="m-widget1__item">
<div class="row m-row--no-padding align-items-center">
<div class="col">
<h3 class="m-widget1__title">
Current Fast Score
</h3>
<span class="m-widget1__desc">
@if($testresult)
{{$testresult->created_at}}
@endif
</span>
</div>
<div class="col m--align-right">
<span class="m-widget1__number m--font-brand">
@if($testresult)
{{$testresult->score}}
@else
0
@endif
</span>
</div>
</div>
</div> 
</div>
<div class="m-portlet__body-separator"></div>
@if($testresult->long_summary)
<div class="user_info">
<h2>You are the <span>{{$testresult->long_summary}}</span></h2>
</div>
<div class="m-portlet__body-separator"></div>
@endif
@if($testresult->overall_interpretation)
<div class="user_description">
<p>{{$testresult->overall_interpretation}}</p> 
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
<!-- end::Body --> 
</div>
<!-- end:: Page --> 

</body>
<!-- end::Body -->
</html>