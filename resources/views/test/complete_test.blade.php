@extends('layouts.app_new')
@section('page_title') 
Result
@endsection 
@section('page_css')
<style>
    .result_div{
        float: left;
    }
</style>
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content download_section">
        <div class="m-portlet__body  m-portlet__body--no-padding">

            <div class="row m-row--no-padding m-row--col-separator-xl"> 
                <div class="col-xl-8 mr-auto">

                    <div class="congrats_block res_block">
                        <div class="col-md-12">
                        <h2>CONGRATULATIONS!</h2>
                        <p>YOU HAVE COMPLETED YOUR FAST TEST, CLICK THE BUTTON BELOW
                            TO CHECK YOUR RESULTS</p>
                        </div>
                    </div>

                    <div class="result_div col-xl-6">
                        <div class="result_block box_shadow"> 
                            <div class="symobol"><i class="fa fa-check"></i></div> 
                            <div class="text">
                                <h5>Answered Correctly</h5>
                                <h3>{{ isset($correct_ans) ? $correct_ans : '' }}
                            </div> 
                        </div>       
                    </div> 
                    <div class="result_div col-xl-6">
                        <div class="result_block box_shadow"> 
                            <div class="symobol"><i class="fa fa-thumbs-up"></i></div> 
                            <div class="text">
                                <h5>Score</h5>
                                <h3>{{ isset($score) ? $score : '' }}%</h3>
                            </div> 

                        </div>
                    </div>
                    <div class="text-center next_prev_btn_group col-xl-12" > 
                        @if(Auth::user()->user_type==3)
                        <a href="{{route('overview')}}"> <button type="button" class="btn m-btn--square btn-retake btn-primary btn-lg m-btn m-btn--custom">
                        @else
                        <a href="{{route('parent_overview')}}"> <button type="button" class="btn m-btn--square btn-retake btn-primary btn-lg m-btn m-btn--custom">
                        @endif
                                View Result
                            </button>
                        </a>
                    </div>
                </div> 



            </div>
        </div>
    </div>
</div>
@endsection