@extends('layouts.admin')
@section('page_title') 
Profile
@endsection 
@section('page_css')
@endsection
@section('content')
@section('page_css')
<style>
    .m-card-profile .m-card-profile__pic img {
        height: 130px;
    }
</style>
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <style>
        .profile_main .m-portlet{
            box-shadow: 0px 1px 15px 1px #dcdcdc !important;
        }
        .profile_main .m-tabs-line.m-tabs-line--primary.nav.nav-tabs .nav-link:hover, .m-tabs-line.m-tabs-line--primary.nav.nav-tabs .nav-link.active, .m-tabs-line.m-tabs-line--primary a.m-tabs__link:hover, .m-tabs-line.m-tabs-line--primary a.m-tabs__link.active {
            color: #f69420;
            border-bottom: 1px solid #f69420;
        }
    </style>
    <div class="m-content profile_main">
        <div class="row">
            <!-- user image section -->
            <div class="col-xl-3 col-lg-4 col-md-4">
                <div class="m-portlet m-portlet--full-height">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__title m--hide">
                                Your Profile
                            </div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    @if(empty($user->avatar))
                                    <img src="http://portal.bilardo.gov.tr/assets/pages/media/profile/profile_user.jpg" alt="">
                                    @else
                                    <img src="{{asset('storage/app/profile/'.$user->avatar)}}" alt="profileimage">
                                    @endif  
                                </div>
                            </div>
                            <div class="m-card-profile__details">
                                <span class="m-card-profile__name">
                                    {{$user->name}}
                                </span>
                                <a href="" class="m-card-profile__email m-link">
                                    {{$user->email}}
                                </a>
                            </div>
                        </div>
                        <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
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
                            <form id="updateuser" class="m-form m-form--fit m-form--label-align-right" action="{{route('adminProfileUpdate')}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="m-portlet__body">  
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-12 col-sm-2 col-form-label">
                                            Full Name
                                        </label>
                                        <div class="col-12 col-sm-10">
                                            <input class="form-control m-input" type="text" name="name" id="name" value="{{$user->name}}">
                                            <input class="form-control m-input" type="hidden" name="userid" id="userid" value="{{$user->id}}">
                                            <input class="form-control m-input" type="hidden" name="usertype" id="usertype" value="{{$user->user_type}}">
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
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-12 col-sm-2 col-form-label">
                                            Attach Image
                                        </label>
                                        <div class="col-12 col-sm-10">
                                            <input type="file" class="form-control m-input" name="attached_file" id="attached_file">
                                        </div>
                                    </div>
                                    <!-- end profile image -->
                                </div>

                                <div class="m-portlet__foot m-portlet__foot--fit">
                                    <div class="m-form__actions">
                                        <div class="row"> 
                                            <div class="col-12">
                                                <div class="text-right">
                                                    <a href="{{url('home')}}" class="btn pre_btn m-btn--square btn-retake btn-lg m-btn m-btn--custom">
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
            <form id="changepwd" action="{{route('changeadminprofilePassword')}}" method="POST">
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
@endsection
@section('page_script')
<script type="text/javascript">
    /*--- Start update profile ------------*/
    $('#updateBtn').on('click', function (e) {
        e.preventDefault();

        var userid = $('#userid').val();
        var usertype = $('#usertype').val();
        var name = $('#name').val();
        var email = $('#email').val();
        var contact = $('#contact').val();
        var school = $('#school').val();
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
            success: function (data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    swal("Success", "Your profile updated successfully", "success");
                    location.reload().delay(100000);
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });
    });
    /*--- End update profile ------------*/

    /*---- Start change password ----------*/
    $('#ChangePasswordBtn').on('click', function (e) {
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
            success: function (data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    $('#ChangePasswordModal').modal('hide');
                    swal("Success", "Password changes successfullly", "success");
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });
    });
    /*---- End change password ------------*/
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
        init: function ()
        {
            $("#contact").inputmask({mask: "9", repeat: 10, greedy: !1});
        }
    }
    jQuery(document).ready(function () {
        Inputmask.init()
    });
    /*-- end input masking for contact number --*/
</script>
@endsection