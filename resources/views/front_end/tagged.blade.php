@extends('layouts.app_new')
@section('page_title') 
Friends
@endsection 
@section('page_css')

@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
  <div class="m-content download_section">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl"> 
                <div class="col-xl-8 mr-auto">
                    <div class="congrats_block">
                        <div class="text-center col-xl-12" >
                        @if(Auth::user()->user_type == 2)
                        <h2>You don't have a child tagged to you</h2>
                        @elseif(Auth::user()->user_type == 3)
                        <h2>You don't have a friend tagged to you</h2>
                        @endif 
                        <div class="text-center next_prev_btn_group ">
                            @if(Auth::user()->user_type=='2')
                            <a href="{{url('manage_request/1')}}">
                                <button type="button" id="add_child"  class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom">
                                   My Children
                                </button>
                            </a>
                            @else
                            <a href="{{url('manage_request/2')}}">
                                <button type="button" id="add_child"  class="btn m-btn--square btn-retake btn-primary btn-sm m-btn m-btn--custom">
                                    My Friends
                                </button>
                            </a>
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