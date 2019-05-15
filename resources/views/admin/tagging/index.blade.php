@extends('layouts.app')
@section('page_title') 
Tag 
@endsection 
@section('page_css')
<style>
    .result_div{
        float: left;
    }
    .next_prev_btn_group a:hover {
        text-decoration: none;
    }
    #tagging .close {
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content download_section">
        <div class="m-portlet__body  m-portlet__body--no-padding">

            <div class="row m-row--no-padding m-row--col-separator-xl"> 
                <div class="col-xl-8 mr-auto">

                    <div class="congrats_block">
                        @if(Auth::user()->user_type == 2)
                        <h2>There is no child tagged for you.</h2>
                        @elseif(Auth::user()->user_type == 3)
                        <h2>There is no friend tagged to you.</h2>
                        @endif
                    </div>

                    <div class="text-center col-xl-12" > 
                        <div class="text-center next_prev_btn_group ">
                            <!-- @if(Auth::user()->user_type == 2)
                            <a href="{{route('addchild')}}">
                                <button type="button" id="add_child"  class="button_2 btn pre_btn m-btn--square btn-retake btn-lg m-btn m-btn--custom">
                                    Add Child
                                </button>
                            </a>
                            @endif
                            @if(Auth::user()->user_type == 2)
                            <a href="{{route('tagchild')}}" data-toggle="modal" data-target="#tagging">
                                <button type="button" id="tag_child" class="button_1 btn m-btn--square btn-retake btn-primary btn-lg m-btn m-btn--custom">
                                    Tag Friend
                                </button>
                            </a>
                            @elseif(Auth::user()->user_type == 3)
                            <a href="#" data-toggle="modal" data-target="#tagging">
                                <button type="button" id="tag_child" class="button_1 btn m-btn--square btn-retake btn-primary btn-lg m-btn m-btn--custom">
                                    Tag Friend
                                </button>
                            </a>
                            @endif -->
                            @if(Auth::user()->user_type=='2')
                            <a href="{{url('manage_request/1')}}">
                                <button type="button" id="add_child"  class="button_2 btn pre_btn m-btn--square btn-retake btn-lg m-btn m-btn--custom">
                                    My Children
                                </button>
                            </a>
                            @else
                            <a href="{{url('manage_request/2')}}">
                                <button type="button" id="add_child"  class="button_2 btn pre_btn m-btn--square btn-retake btn-lg m-btn m-btn--custom">
                                    My Friends
                                </button>
                            </a>
                            @endif
                        </div>
                    </div>
                </div> 
            </div>
            <!-- Start model popup for tagging --->
           <!--  <div class="modal fade" id="tagging" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            @if(Auth::user()->user_type == 3)
                            <h5 class="modal-title">
                                Tag Your Friend
                            </h5>
                            @elseif(Auth::user()->user_type == 2)
                            <h5 class="modal-title">
                                Tag Your Friend
                            </h5>
                            @endif

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="la la-remove"></span>
                            </button>

                        </div>
                        <form id="tagfriend" class="m-form m-form--fit m-form--label-align-right" method="POST" action="{{route('refer_friends')}}">
                            <input type="hidden" id="user_type" name="user_type" value="{{Auth::user()->user_type}}">
                            <input type="hidden" id="auth_id" name="auth_id" value="{{Auth::user()->id}}">
                            <input type="hidden" id="auth_name" name="auth_name" value="{{Auth::user()->name}}">

                            <div class="modal-body">
                                <div class="form-group m-form__group row m--margin-top-20" >
                                    <label class="col-form-label col-lg-3 col-sm-12">
                                        Search Friend
                                        <span class="required" aria-required="true"> * </span>
                                    </label>

                                    <div class="col-lg-9 col-md-9 col-sm-12" id="namefield">
                                        <div class="m-typeahead">
                                            <input name="searchfriend" class="form-control m-input" id="searchfriend" type="text" maxlength="30" placeholder="Search your friend">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-brand m-btn" data-dismiss="modal">
                                    Close
                                </button>
                                <button type="button" class="btn btn-brand m-btn" id="findfriend">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
            <!-- End model popup for tagging ----->
            <!-- Response model start -->
            <div class="modal fade" id="ResponseSuccessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <form name="fm-student">
                            <div class="modal-body">
                                <h5 id="ResponseHeading"></h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-accent  background_gradient btn-view no_border_field" data-dismiss="modal" id="LoadURMDatatable">
                                    OK
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Reponse model end -->
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script>

    $('#tag_child').click(function () {
        $('#searchfriend').val('');
    });
    $('#searchfriend').click(function () {
        $('#searchfriends').val('');

    });

    $('#findfriend').click(function (e) {
        e.preventDefault();
        var id = $('#auth_id').val();
        var user_type = $('#user_type').val();
        var searchname = $('#searchfriend').val();
        var auth_name = $('#auth_name').val();

        if (searchname == '') {
            swal("Error", "Please enter your friend name", "error");
            return false;
        }

        $.ajax({
            method: 'POST',
            url: $("#tagfriend").attr('action'),
            data: {
                id: id,
                user_type: user_type,
                searchname: searchname,
                auth_name: auth_name,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    var total = res.data;
//                    $('#tagging').modal('hide');
//                    $("#ResponseSuccessModal").modal('show');
//                    $("#ResponseSuccessModal #ResponseHeading").text(res.message);
                    var searchname = '';
                    searchname += '<div class="col-lg-12 col-md-12 col-sm-12" id="namefield" style="padding-top: 5px;">'
                            + '<div class="row"><div class="col-lg-9 col-md-9 col-sm-12" style="padding-left: 0px;">'
                            + '<input name="searchfriends" class="form-control m-input" id="searchfriends" type="text" value="' +(total.username)+' ('+total.name+')' + '" disabled></div>'
                            + '<div class="col-lg-3 col-md-3 col-sm-12"><button type="button" class="btn btn-brand m-btn" data-id="' + total.id + '" id="Addfriend" onclick="addfriend()">Add Friend</button></div>'
                            + '</div></div>';

                    $('#namefield').html(searchname);


                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });

    });

    /*----- Start Ajax for Dynamic tag friend --------------- */
    function addfriend(id) {
        var path = APP_URL + "/child/addfreind";
        var friend_id = $('#Addfriend').attr('data-id');
        var auth_id = $('#auth_id').val();
        var user_type = $('#user_type').val();
        var searchname = $('#searchfriends').val();

        if (searchname == '') {
            swal("Error", "Please search your friend username and click on submit button", "error");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: path,
            data: {
                friend_id: friend_id,
                auth_id: auth_id,
                user_type: user_type,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    $('#tagging').modal('hide');
                    $("#ResponseSuccessModal").modal('show');
//                    $("#ResponseSuccessModal #ResponseHeading").text(res.message);
                    window.location.reload();
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
                return false;
            }
        });
    }

    /*----- End Ajax for Dynamic tag friend --------------- */


</script>
@endsection