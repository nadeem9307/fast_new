@extends('layouts.app_new')
@section('page_title')
Parent
@endsection
@section('page_css')
<style>
    .m-card-profile .m-card-profile__pic img {
        height: 130px;
    }

    i.fa.fa-pencil.edit_icon {
        position: absolute;
        cursor: pointer;
        background: #f69420;
        padding: 8px;
        border-radius: 100%;
        color: #fff;
    }

    .block.text-center img {
        min-height: 150px;
    }

    .block.text-center {
        max-height: 150px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .block.text-center.active:before {
        content: '\2713';
        color: #ec9835;
        position: absolute;
        background: #000000a3;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        font-size: 40px;
    }

    #blocks .text-center {
        margin-bottom: 10px;
    }

    .block {
        cursor: pointer;
    }

    #blocks .col-xl-4.col-sm-4 {
        margin-bottom: 15px;
    }

    .block.text-center.active {
        position: relative;
    }

    button.close {
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <style>
        .profile_main .m-portlet {
            box-shadow: 0px 1px 15px 1px #dcdcdc !important;
        }

        .profile_main .m-tabs-line.m-tabs-line--primary.nav.nav-tabs .nav-link:hover,
        .m-tabs-line.m-tabs-line--primary.nav.nav-tabs .nav-link.active,
        .m-tabs-line.m-tabs-line--primary a.m-tabs__link:hover,
        .m-tabs-line.m-tabs-line--primary a.m-tabs__link.active {
            color: #f69420;
            border-bottom: 1px solid #f69420;
        }
    </style>
    <div class="m-content profile_main">
        <div class="row">
            <!-- user image section -->
            <div class="col-xl-3 col-lg-4 col-md-4">
                <div class="m-portlet m-portlet--full-height  ">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__title m--hide">
                                Your Profile
                            </div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    <a href="#" id="avtars" class="" data-toggle="modal" data-target="#change_avtars">
                                        <i class="fa fa-pencil edit_icon"></i></a>
                                @if(isset($user->instructor_avatar) && $user->instructor_avatar !='')
                                <img src="{{asset('storage/'.$user->instructor_avatar)}}" class="img-responsive user_img">
                                @elseif(isset($images['images']) && !empty($images['images']))
                                <img src="{{asset('storage/app/levelavatar/'.$images['dir']['subdir'].'/'.$images['images'][0])}}" class="img-responsive user_img">
                                @else
                                <img src="{{url('public/assets/demo/demo5/media/img/user.svg')}}" class="img-responsive user_img">
                                @endif
                                </div>
                            </div>
                            <div class="m-card-profile__details">
                                <span class="m-card-profile__name">
                                    {{$user->username}}
                                </span>
                                <a href="" class="m-card-profile__email m-link">
                                    {{$user->email}}
                                </a>
                            </div>
                        </div>
                        <ul class="m-nav m-nav--hover-bg">
                            <li class="m-nav__separator m-nav__separator--fit"></li>
                            <li class="m-nav__section m--hide">
                                <span class="m-nav__section-text">
                                    Section
                                </span>
                            </li>
                            <li class="m-nav__item">
                                <a href="javascript:(0);" class="m-nav__link" data-toggle="modal" data-target="#ChangePasswordModal">
                                    <i class="m-nav__link-icon flaticon-lock"></i>
                                    <span class="m-nav__link-text">
                                        Change Password
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end user image section -->
            <!-- user profile section -->
            <div class="col-xl-9 col-lg-8 col-md-8">
                <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active">
                                        <i class="flaticon-share m--hide"></i>
                                        My Profile
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <form id="updateuser" class="m-form m-form--fit m-form--label-align-right" action="{{route('profileUpdate')}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-12 col-sm-2 col-form-label">
                                            Full Name
                                        </label>
                                        <div class="col-12 col-sm-10">
                                            <input class="form-control m-input" type="text" name="name" id="name" value="{{$user->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-12 col-sm-2 col-form-label">
                                            Email
                                        </label>
                                        <div class="col-12 col-sm-10">
                                            <input class="form-control m-input" type="email" name="email" id="email" value="{{$user->email}}">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-12 col-sm-2 col-form-label">
                                            Contact
                                        </label>
                                        <div class="col-12 col-sm-10">
                                            <input class="form-control m-input" type="text" name="contact" id="contact" value="{{$user->contact}}">
                                            <span class="m-form__help text-success">
                                                If you want to forgets password in future please update this.
                                            </span>
                                        </div>
                                    </div>
                                    @if(!empty($countries))
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-12 col-sm-2 col-form-label">
                                            Select Country
                                        </label>
                                        <div class="col-12 col-sm-10">
                                            <select class="form-control mx-auto" name="country_id" id="country_id">
                                                <option value="">Select Country</option>
                                                @foreach($countries as $item)
                                                @if($user->country_id ==$item->id)
                                                <option value="{{$item->id}}" selected="">{{$item->country_name}}</option>
                                                @else
                                                <option value="{{$item->id}}">{{$item->country_name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- add school only for child -->
                                    @if($user->user_type == 3)
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-12 col-sm-2 col-form-label">
                                            School
                                        </label>
                                        <div class="col-12 col-sm-10">
                                            <input class="form-control m-input" type="text" name="school" id="school" value="{{$user->school_name}}">
                                        </div>
                                    </div>
                                    @endif
                                    <!-- end school only for child -->
                                    <!-- start profile image -->
                                    <!-- <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-12 col-sm-2 col-form-label">
                                            Attach Image
                                        </label>
                                        <div class="col-12 col-sm-10">
                                            <input type="file" class="form-control m-input" name="attached_file" id="attached_file">
                                        </div>
                                    </div> -->
                                    <!-- end profile image -->
                                    @if($user->user_type == 3)
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-12 col-sm-2 col-form-label">
                                            Level
                                        </label>
                                        <div class="col-12 col-sm-10">
                                            @if(!empty($level))
                                            <select class="form-control m-input" id="level" name="level">
                                                <option value="">Please select your level</option>
                                                @foreach($level as $levels)
                                                @if($user->level_id == $levels->id)
                                                <option value="{{$levels->id}}" selected>{{$levels->level_name}}</option>
                                                @else
                                                <option value="{{$levels->id}}">{{$levels->level_name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                    </div>
                                    @else
                                    <input type="hidden" id="level" name="level" value="{{Auth::user()->level_id}}">
                                    @endif
                                </div>

                                <div class="m-portlet__foot m-portlet__foot--fit">
                                    <div class="m-form__actions">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="text-right">
                                                    @if($user->user_type == 3)
                                                    <a href="{{url('overview')}}" class="btn pre_btn m-btn--square btn-retake btn-lg m-btn m-btn--custom">
                                                        @else
                                                        <a href="{{url('parent/overview')}}" class="btn pre_btn m-btn--square btn-retake btn-lg m-btn m-btn--custom">
                                                            @endif
                                                            Cancel
                                                        </a>
                                                        <button type="button" class="btn m-btn--square btn-retake btn-primary btn-lg m-btn m-btn--custom" id="updateBtn">
                                                            Update
                                                        </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end user profile section -->
        </div>
    </div>
</div>
<div class="modal fade" id="ChangePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Change Password
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <form id="changepwd" action="{{route('changeprofilePassword')}}" method="POST">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">
                            Old Password:
                        </label>
                        <input type="password" required class="form-control" name="old_password" id="old-password">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">
                            New Password:
                        </label>
                        <input type="password" class="form-control" name="new_password" id="new-password">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">
                            Confirm New Password:
                        </label>
                        <input type="password" class="form-control" name="confirm_passoword" id="confirm-passoword">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="ChangePasswordBtn" class="btn m-btn--square btn-retake btn-primary btn-md m-btn m-btn--custom">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- start avatar image model for the profile -->
<div class="modal fade" id="change_avtars" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">
                    Choose Your Avatar
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-remove"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="blocks">
                    @if(!empty($images['images']))
                    @foreach($images['images'] as $image)
                    <div class="col-xl-4 col-sm-4" onclick="ChangeOverviewImage(this);">
                        <div class="block text-center">
                            <img class="img-responsive" src="{{asset('storage/app/levelavatar/'.$images['dir']['subdir'].'/'.$image)}}" title="select Images">
                        </div>
                    </div>
                    @endforeach
                    @else
                    <span>No Instructor Image Found</span>
                    @endif
                </div>
                <input type="hidden" name="checked_image" id="checked_image">
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-danger m-btn" data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary m-btn" id="image_upload">
                    Set
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end avatar image model for the profile -->
@endsection
@section('page_script')
<script type="text/javascript">
    /*--- Start update profile ------------*/

    $('#updateBtn').on('click', function(e) {
        e.preventDefault();
        var usertype = "{{Auth::user()-> user_type}}";
        var name = $('#name').val();
        var email = $('#email').val();
        var contact = $('#contact').val();
        var school = $('#school').val();
        var level = $('#level').val();
        var profileimage = $('#attached_file').val();
        var form = $('#updateuser')[0];
        var data = new FormData(form);


        if (name == '') {
            swal("Error", "Name is required", "error");
            return false;
        }
        if (usertype == 2) {
            if (contact == '') {
                swal("Error", "Contact number is required", "error");
                return false;

            }
        }
        if (email != '') {
            if (!validateEmail(email)) {
                swal("Error", "Invalid email address", "error");
                return false;
            }
        }
        if (level == '') {
            swal("Error", "Please select your level", "error");
            return false;
        }



        $.ajax({
            method: 'POST',
            enctype: 'multipart/form-data',
            url: $("#updateuser").attr('action'),
            data: data,
            processData: false,
            contentType: false,
            cache: false,

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    swal("Success", "Your profile updated successfully", "success");
                    window.location.reload();
                }
            },
            error: function(data) {
                swal('Error', data, 'error');
            }
        });
    });
    /*--- End update profile ------------*/

    /*---- Start change password ----------*/
    $('#ChangePasswordBtn').on('click', function(e) {
        e.preventDefault();
        var oldpassword = $('#old-password').val();
        var newpassword = $('#new-password').val();
        var cpassoword = $('#confirm-passoword').val();

        if (oldpassword == '') {
            swal("Error", "Please enter your password", "error");
            return false;
        }
        if (newpassword == '') {
            swal("Error", "Please enter your new password", "error");
            return false;
        }
        if (cpassoword == '') {
            swal("Error", "Please enter your confirm password", "error");
            return false;
        }
        if (newpassword != cpassoword) {
            swal("Error", "New password and Confirm password are not matches", "error");
            return false;
        }

        $.ajax({
            method: 'POST',
            url: $("#changepwd").attr('action'),
            data: {
                oldpassword: oldpassword,
                newpassword: newpassword,
                cpassoword: cpassoword,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    $('#ChangePasswordModal').modal('hide');
                    swal("Success", "Password changes successfullly", "success");
                }
            },
            error: function(data) {
                swal('Error', data, 'error');
            }
        });
    });
    /*---- End change password ------------*/

    /*---- Start js for change profile image --*/
    function ChangeOverviewImage(e) {
        var user_id = "{{Auth::user()->id}}";
        var instrutor_file = $(e).find('img').attr('src');
        $('.block').removeClass('active');
        $(e).find('.block').addClass('active');
        $('#checked_image').val(instrutor_file);
    }
    $('#image_upload').on('click', function() {
        var user_type = "{{Auth::user()->user_type}}";
        var instrutor_files = $('#checked_image').val();
        if(user_type == 2){
            var path = APP_URL + "/parent/instructor/imageUpdate"; 
        }
        else{
            var path = APP_URL + "/instructor/imageUpdate";
        }
        

        $.ajax({
            method: 'POST',
            url: path,
            data: {
                image: instrutor_files
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    swal("Success", "Change avatars successfully", "success");
                    window.location.reload();
                }
            },
            error: function(data) {
                swal('Error', data, 'error');
            }
        });
    });
    /*----- End js for change profile image --*/
    
    /*---- Start  validation for email address -----------*/
    function validateEmail(email) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(email)) {
            return true;
        } else {
            return false;
        }
    }
    /*---- End validation for email address --------------*/
    /*-- input masking for contact number --*/
    var Inputmask = {
        init: function() {
            $("#contact").inputmask({
                mask: "9",
                repeat: 10,
                greedy: !1
            });
        }
    }
    jQuery(document).ready(function() {
        Inputmask.init()
    });
    /*-- end input masking for contact number --*/
</script>
@endsection