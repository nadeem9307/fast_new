@extends('layouts.app')
@section('page_title') 
Add Child
@endsection 
@section('page_css')
<style>
    .result_div{
        float: left;
    }
    .next_prev_btn_group a{
        text-decoration:none;
    }
    p.msg_check {
        float: left;
        margin-top: 0px;
        color: #ff0000d4;
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
                        <!-- Start add child form layout -->
                        <div class="m-login__signup">
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    Add Child
                                </h3>
                            </div>
                            <form id="registerchild" class="m-login__form m-form" action="{{route('saveChild')}}" method="POST">
                                @csrf
                                <input type="hidden" id="addchild_tagid" name="addchild_tagid" value="{{Auth::user()->id}}">
                                <div class="form-group m-form__group">
                                    @if(!empty($countries))
                                    <select class="form-control m-input" id="country" name="country">
                                        <option value="">Please select country name</option>
                                        @foreach($countries as $allcountry)
                                        <option value="{{$allcountry['id']}}">{{$allcountry['country_name']}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                <div class="form-group m-form__group" id="userschool" style="display: none;">
                                    <input name="school_name" class="form-control m-input" id="school_name" type="text" placeholder="School Name" value="">
                                </div>
                                <div class="form-group m-form__group">
                                    <input name="name" class="form-control m-input" id="name" type="text" placeholder=" Name" value="">
                                </div>
                                <div class="form-group m-form__group">
                                    <input name="username" class="form-control m-input" id="username" type="text" placeholder="Username" value="">
                                    <p class="msg_check"></p>
                                </div>
                                <div class="form-group m-form__group">
                                    <input name="useremail" class="form-control m-input" id="useremail" type="email" placeholder="Email" value="">
                                </div>
                                <div class="form-group m-form__group">
                                    <input name="contact" class="form-control m-input" id="contact" type="number" placeholder="Contact number" value="">
                                </div>
                                <div class="form-group m-form__group">
                                    <input name="userpassword" class="form-control m-input" id="userpassword" type="password" placeholder="Password" value="">
                                </div>

                                <div class="m-login__form-action next_prev_btn_group">
                                    <button type="button" id="addchild"  class="button_2 btn pre_btn m-btn--square btn-retake btn-lg m-btn m-btn--custom">
                                        Add
                                    </button>
                                    <a href="{{route('tagging')}}">
                                        <button type="button" id="cancel" class="button_1 btn m-btn--square btn-retake btn-primary btn-lg m-btn m-btn--custom">
                                            Cancel
                                        </button>
                                    </a>
                                </div>
                            </form>
                        </div>
                        <!-- End add child form layout -->
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script>


    $('#addchild').click(function (e) {
        e.preventDefault();

        var id = $('#addchild_tagid').val();
        var country = $('#country').val();
        var name = $('#name').val();
        var username = $('#username').val();
        var useremail = $('#useremail').val();
        var contact = $('#contact').val();
        var userpassword = $('#userpassword').val();



        if (country == '') {
            swal("Error", "Country name is required", "error");
            return false;
        }
        if (name == '') {
            swal("Error", "Name is required", "error");
            return false;
        }
        if (username == '') {
            swal("Error", "User name is required", "error");
            return false;
        }
      
        if (contact == '') {
            swal("Error", "Contact is required", "error");
            return false;

        }
        if (userpassword == '') {
            swal("Error", "Password is required", "error");
            return false;
        }

        $.ajax({
            method: 'POST',
            url: $("#registerchild").attr('action'),
            data: {
                id: id,
                country: country,
                contact: contact,
                name: name,
                username: username,
                useremail: useremail,
                userpassword: userpassword,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var res = $.parseJSON(data);
//                        console.log('----add new user data------------');
//                        console.log(res);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    $('#addchild_tagid').val('');
                    $('#country').val('');
                    $('#name').val('');
                    $('#username').val('');
                    $('#useremail').val('');
                    $('#contact').val('');
                    $('#userpassword').val('');
//                    swal("Success", "Child successfully saved", "success");
                    window.location = "{{route('tagging')}}";
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });
    });

    /*---- Check username availability -----------------------*/
    $('#username').keyup(function (e) {
        var path = APP_URL + "/registered/username";
        var id = $('#addchild_tagid').val();
        var username = $('#username').val();

        $.ajax({
            method: 'POST',
            url: path,
            data: {
                id: id,
                username: username,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var res = $.parseJSON(data);
//                console.log('----user availability data------------');
//                console.log(res);
                if (res.status == 'error') {
                    $myspan = '<span id="usravailability">' + res.message + '</span>';
                    $('.msg_check').html($myspan);
                } else {
                    if (username == '') {
                        $myspan = '<span id="usravailability">' + res.message + '</span>';
                        $('.msg_check').html('');
                    } else if (username != '') {
                        $myspan = '<span id="usravailability">' + res.message + '</span>';
                        $('.msg_check').html($myspan);
                    }
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });
    });
    /*---- End Check username availability -----------------------*/

</script>
@endsection