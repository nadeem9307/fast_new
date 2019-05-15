@extends('layouts.admin')
@section('page_title') 
Home 
@endsection 

@section('page_css')
@endsection
@section('content')
<style>
    .background_gradient {
        background-color: #eeedec;
    }
</style>
<div class="m-content">
    <div class="row m-row--full-height">
        <div class="col-sm-12 col-md-12 col-lg-4">
            <div class="m-portlet m-portlet--border-brand active background_gradient">
                <div class="m-portlet__body text-center">
                    <div class="m-widget26 display_flex">
                        <div class="m-widget26__icon">
                            <i class="flaticon-user"></i>
                        </div>
                        <div class="m-widget26__number total_users">
                           
                        </div>          
                    </div>
                    <small class="count_name">Total Users</small>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4">
            <div class="m-portlet m-portlet--border-brand background_gradient">
                <div class="m-portlet__body text-center">
                    <div class="m-widget26 display_flex">
                        <div class="m-widget26__icon">
                            <i class="flaticon-user"></i>
                        </div>
                        <div class="m-widget26__number total_parent">
                           
                        </div>          
                    </div>
                    <small class="count_name">Parents Users</small>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4">
            <div class="m-portlet m-portlet--border-brand background_gradient">
                <div class="m-portlet__body text-center">
                    <div class="m-widget26 display_flex">
                        <div class="m-widget26__icon">
                            <i class="flaticon-user"></i>
                        </div>

                        <div class="m-widget26__number total_child">
                              
                        </div>  

                    </div>
                    <small class="count_name">Child Users</small>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Subheader -->

@endsection
@section('page_script')
<script>
    /*var chart_data = "";
    $.ajax({
        method: 'GET',
        url: 'get_users_data',
        async: false,
        data: {

        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            var res = $.parseJSON(data);
            chart_data = res;
            console.log(chart_data);
            if (chart_data.total_users != '') {
                $(".total_users").html(chart_data.total_users);
                $(".total_parent").html(chart_data.parent_users);
                $(".total_child").html(chart_data.child_users);
            }else{
                $(".total_users").html(0);
                $(".total_parent").html(0);
                $(".total_child").html(0);
            }
        },
        error: function (data) {
        }
    });*/
</script>
@endsection