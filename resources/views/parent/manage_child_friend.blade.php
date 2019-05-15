@extends('layouts.app_new')
@section('page_title') 
Manage Users
@endsection 
@section('page_css')

@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="align-items-center">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="m-subheader__title">
                        My @if($type=='1' && $user->user_type=='2') Children @elseif($type=='1' && $user->user_type=='3') Parents @elseif($type=='2') Friends @endif
                    </h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="#" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a class="m-nav__link">
                                <span class="m-nav__link-text">
                                    {{$user->username}}
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="{{url('child')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    My @if($type=='1' && $user->user_type=='2') Children @elseif($type=='1' && $user->user_type=='3') Parents @elseif($type=='2') Friends @endif
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 text-right">
                    <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                            @if($type=='1' && $user->user_type=='2')
                            <button class="btn btn-primary m-btn m-btn--icon" id="addChild">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Child
                                    </span>
                                </span>
                            </button>
                            <button class="btn btn-primary m-btn m-btn--icon" id="tagChild">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Tag Child
                                    </span>
                                </span>
                            </button>
                            @endif
                            @if($type=='1' && $user->user_type=='3')
                            <button class="btn btn-primary m-btn m-btn--icon" id="tagParent">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Tag Parent
                                    </span>
                                </span>
                            </button>
                            @endif
                            @if($type=='2')
                            <button class="btn btn-primary m-btn m-btn--icon" id="tagFriend">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Tag Friends
                                    </span>
                                </span>
                            </button>
                            @endif

                        </div>
                    </div>
                </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__body no_padding">
                <!--begin: Datatable -->
                <div class="child_datatable"></div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="taggingModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Tag @if($type=='1' && $user->user_type=='2') Child @elseif($type=='1' && $user->user_type=='3') Parent @elseif($type=='2') Friend @endif
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-remove"></span>
                </button>

            </div>
            <form id="tagfriendform" class="m-form m-form--fit" method="POST" action="{{route('refer_friends')}}">
                <input type="hidden" id="search_type" name="search_type">
                <input type="hidden" id="user_type" name="user_type" value="{{Auth::user()->user_type}}">
<!--                <input type="hidden" id="auth_id" name="auth_id" value="{{Auth::user()->id}}">
                <input type="hidden" id="auth_name" name="auth_name" value="{{Auth::user()->name}}">-->

                <div class="modal-body">
                    <div class="form-group" >
                        <label class="col-form-label col-sm-12">
                            Search Username
                            <span class="required" aria-required="true"> * </span>
                        </label>

                        <div class="col-sm-12" id="namefield">
                            <div class="m-typeahead">
                                <input name="searchfriend" class="form-control m-input" id="searchfriend" type="text" maxlength="30" placeholder="Enter Username">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-black m-btn" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary m-btn" id="findfriend">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@if($type=='1' && $user->user_type=='2')
<div class="modal fade" id="AddChildModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add Child
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <form name="registerchild" id="registerchild" action="{{route('saveChild')}}" method="POST">
                <div class="modal-body">
                    {{ csrf_field() }}
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
                    <div class="form-group m-form__group" id="userschool">
                        <input name="school_name" class="form-control m-input" id="school_name" type="text" placeholder="School Name">
                    </div>
                    <div class="form-group m-form__group">
                        <input name="name" class="form-control m-input" id="name" type="text" placeholder="Enter Child Name">
                    </div>
                    <div class="form-group m-form__group">
                        <input name="username" class="form-control m-input" id="username" type="text" placeholder="Username">
                        <p class="msg_check"></p>
                    </div>
                    <div class="form-group m-form__group">
                        <input name="useremail" class="form-control m-input" id="useremail" type="email" placeholder="Enter child email">
                    </div>
                    <div class="form-group m-form__group">
                        <input name="contact" class="form-control m-input" id="contact" type="number" placeholder="Enter child contact">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-black m-btn" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" id="addChildBtn">
                        Add Child
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
@section('page_script')

<script type="text/javascript">
    var user_type = $('#user_type').val();
    @if ($type == '1' && $user-> user_type == '2')
            $('#addChild').click(function(e){
    e.preventDefault();
    $('#AddChildModal').modal('show');
    $('#country').val('');
    $('#name').val('');
    $('#username').val('');
    $('#useremail').val('');
    $('#contact').val('');
    });
    @endif
            $('#tagFriend').click(function(e){
    e.preventDefault();
    $('#findfriend').attr('disabled', false);
    $('#taggingModal').find('.modal-title').html('Tag Friend');
    $('#taggingModal').modal('show');
    $('#searchfriends').val('');
    $('#searchfriends').attr('disabled', false);
    if (user_type == '2')
    {
    $('#search_type').val('2');
    }
    else
    {
    $('#search_type').val('3');
    }
    });
    @if ($type == '1' && $user-> user_type == '2')
            $('#tagChild').click(function(e){
    e.preventDefault();
    $('#findfriend').attr('disabled', false);
    $('#taggingModal').find('.modal-title').html('Tag Child');
    $('#taggingModal').modal('show');
    $('#searchfriends').val('');
    $('#searchfriends').attr('disabled', false);
    //Tagging will be for child
    $('#search_type').val('3');
    });
    @endif
            @if ($type == '1' && $user-> user_type == '3')
            $('#tagParent').click(function(e){
    e.preventDefault();
    $('#findfriend').attr('disabled', false);
    $('#taggingModal').find('.modal-title').html('Tag Parent');
    $('#taggingModal').modal('show');
    $('#searchfriends').val('');
    $('#searchfriends').attr('disabled', false);
    //Tagging will be for child
    $('#search_type').val('2');
    });
    @endif
            /*---- Check username availability -----------------------*/
            $('#username').keyup(function (e) {
    var path = APP_URL + "/registered/username";
    var username = $('#username').val();
    $.ajax({
    method: 'POST',
            url: path,
            data: {
            username: username,
            },
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
            var res = $.parseJSON(data);
            if (res.status == 'error') {
            $myspan = '<span id="usravailability" class="text-warning">' + res.message + '</span>';
            $('.msg_check').html($myspan);
            $('#addchild').attr("disabled", "disabled");
            } else {
            if (username == '') {
            $myspan = '<span id="usravailability" class="text-warning">' + res.message + '</span>';
            $('.msg_check').html('');
            } else if (username != '') {
            $myspan = '<span id="usravailability" class="text-success">' + res.message + '</span>';
            $('.msg_check').html($myspan);
            $('#addchild').removeAttr("disabled");
            }
            }
            },
            error: function (data) {
//            swal('Error', data, 'error');
            }
    });
    });
    @if ($type == '1' && $user-> user_type == '2')
            $('#addChildBtn').click(function (e) {
    e.preventDefault();
    var country = $('#country').val();
    var name = $('#name').val();
    var username = $('#username').val();
    var useremail = $('#useremail').val();
    var contact = $('#contact').val();
//        var userpassword = $('#userpassword').val();

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
    $.ajax({
    method: 'POST',
            url: $("#registerchild").attr('action'),
            data: {
            country: country,
                    contact: contact,
                    name: name,
                    username: username,
                    useremail: useremail,
            },
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
            var res = $.parseJSON(data);
            if (res.status == 'error') {
            swal('Error', res.message, 'error');
            } else {
            $('#country').val('');
            $('#name').val('');
            $('#username').val('');
            $('#useremail').val('');
            $('#contact').val('');
            $('#AddChildModal').modal('hide');
            swal('Success', 'Child Added Successfully', 'success');
            }
            },
            error: function (data) {
            swal('Error', data, 'error');
            }
    });
    });
    @endif
            $('#searchfriend').click(function () {
    $('#searchfriends').val('');
    });
    $('#findfriend').click(function (e) {
    e.preventDefault();
    $('#findfriend').attr('disabled', true);
    var id = $('#auth_id').val();
    var search_type = $('#search_type').val();
    var searchname = $('#searchfriend').val();
    var auth_name = $('#auth_name').val();
    if (searchname == '') {
    swal("Error", "Please enter Username", "error");
    return false;
    }

    $.ajax({
    method: 'POST',
            url: $("#tagfriendform").attr('action'),
            data: {
            id: id,
                    search_type: search_type,
                    searchname: searchname,
                    auth_name: auth_name,
            },
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
            var res = $.parseJSON(data);
            if (res.status == 'error') {
            $('#findfriend').attr('disabled', false);
            swal('Error', res.message, 'error');
            } else {
            var total = res.data;
            var searchname = '';
            searchname += '<div class="col-lg-12 col-md-12 col-sm-12" id="namefield" style="padding-top: 5px;">'
                    + '<div class="row"><div class="col-lg-9 col-md-9 col-sm-12" style="padding-left: 0px;">'
                    + '<input name="searchfriends" class="form-control m-input" id="searchfriends" type="text" value="' + (total.username) + '" disabled></div>'
                    + '<div class="col-lg-3 col-md-3 col-sm-12"><button type="button" class="btn btn-primary m-btn" data-id="' + total.id + '" id="Addfriend" onclick="addfriend()">Tag</button></div>'
                    + '</div></div>';
            $('#namefield').html(searchname);
            }
            },
            error: function (data) {
            $('#findfriend').attr('disabled', false);
            swal('Error', data, 'error');
            }
    });
    });
    /*----- Start Ajax for Dynamic tag friend --------------- */
    function addfriend(id) {
    var path = APP_URL + "/child/addfreind";
    var friend_id = $('#Addfriend').attr('data-id');
    var auth_id = $('#auth_id').val();
    var user_type = $('#search_type').val();
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
    /*----------------- Display listing of users through datatable using ajax request----------------*/
    var datatable;
    var type = "{{$type}}";
    //var user_id = "{{Auth::user()->id}}";
    (function () {
    datatable = $('.child_datatable').mDatatable({
    // datasource definition
    data: {
    type: 'remote',
            source: {
            read: {
            url: APP_URL + "/user/request/" + type,
                    method: 'GET',
                    // custom headers
                    headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                    params: {
                    // custom query params
                    query: {
                    }
                    },
                    map: function (raw) {
//                           
                    var dataSet = raw;
                    if (typeof raw.data !== 'undefined') {
                    dataSet = raw.data;
                    }

                    return dataSet;
                    },
            }
            },
            pageSize: 10,
            saveState: {
            cookie: false,
                    webstorage: false
            },
            serverPaging: true,
            serverFiltering: false,
            serverSorting: false
    },
            // layout definition
            layout: {
            theme: 'default', // datatable theme
                    class: '', // custom wrapper class
                    scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                    // height: 450, // datatable's body's fixed height
                    footer: false // display/hide footer
            },
            // column sorting
            sortable: true,
            pagination: true,
            /* search: {
             input: $('#generalSearch')
             },*/

            // inline and bactch editing(cooming soon)
            // editable: false,

            // columns definition
            columns: [{
            field: "S_No",
                    title: "S.No",
                    width: 40
            },
            {
            field: "from_name",
                    title: "From",
                    textAlign: 'center'
            },
            {
            field: "to_name",
                    title: "To",
                    textAlign: 'center'
            },
            {
            field: "request_status",
                    title: "Status",
                    template: function (row) {
                    if (row.request_status == '1')
                    {
                    return '\
                        <span class="m-badge m-badge--brand m-badge--wide">Pending\
                        </span>\
                        ';
                    }
                    else if (row.request_status == '2')
                    {
                    return '\
                        <span class="m-badge m-badge--success m-badge--wide">Accepted\
                        </span>\
                        ';
                    }
                    else if (row.request_status == '3')
                    {
                    return '\
                        <span class="m-badge m-badge--danger m-badge--wide">Declined\
                        </span>\
                        ';
                    }
                    }
            },
            {
            width: 110,
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    field: 'Actions',
                    template: function (row) {
                    var view_path = APP_URL + '/child/';
                    if (row.from_status == '2' && row.request_status == '1')
                    {
                    return '\
                            <a href="javascript:;" class="theme-text" title="Decline"  onclick=userResponse(' + row.from_id + ',3)>\
                            <i class="fa fa-remove"></i>\
                            </a> &nbsp;\
                            <a href="javascript:;" class="theme-text" title="Accept">\
                            <i class="fa fa-check" onclick=userResponse(' + row.from_id + ',2)></i>\
                            </a> &nbsp;\
                            \
                            ';
                    }
                    else
                    {
                    if (row.from_status == '1' && row.request_status == '2')
                    {
                            @if ($type == '1' && $user-> user_type == '2' || $type == '2' && $user-> user_type == '3')
                    
                    return '\
                                <a href="' + view_path + row.to_id + '" class="theme-text" title="view child">\
                               <i class="flaticon-visible"></i>\
                               </a> &nbsp;<a href="javascript:;" class="theme-text" title="Untag">\
                                <i class="fa fa-user-times" onclick=untagUser(' + row.id + ',"' + row.to_name + '")></i> \
                                </a> &nbsp;\
                                ';
                     @else
                    return '\
                                <a href="javascript:;" class="theme-text" title="Untag">\
                                <i class="fa fa-user-times" onclick=untagUser(' + row.id + ',"' + row.to_name + '")></i>\
                                </a>\
                            ';
                    @endif
                    }
                    if (row.from_status == '2' && row.request_status == '2')
                    {
                            @if ($type == '1' && $user-> user_type == '2' || $type == '2' && $user-> user_type == '3')
                    
                                return '\  <a href="' + view_path + row.to_id + '" class="theme-text" title="view child">\
                               <i class="flaticon-visible"></i> &nbsp;\
                               </a>\
                                <a href="javascript:;" class="theme-text" title="Untag">\
                                <i class="fa fa-user-times" onclick=untagUser(' + row.id + ',"' + row.to_name + '")></i> \
                                </a> &nbsp;\
                                ';
                     @else
                    return '\
                                <a href="javascript:;" class="theme-text" title="Untag">\
                                <i class="fa fa-user-times" onclick=untagUser(' + row.id + ',"' + row.to_name + '")></i>\
                                </a>\
                            ';
                    @endif
                    
                    }
                    /*if (row.from_status == '1' && row.request_status == '3')
                    {
                    return '\
                                <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Resend">\
                                <i class="fa fa-share" onclick=resendRequest(' + row.id + ')></i>\
                                </a>\
                                ';
                    }*/
                    }
            },
            }
            ]
    });
    })();
    function userResponse(id, status)
    {
    var _this = $(this);
    if (status == '2')
    {
    var title = "Are you sure to Accept this request?";
    var confirmButtonText = "Yes, Accept it!";
    }
    if (status == '3')
    {
    var title = "Are you sure to Decline this request?";
    var confirmButtonText = "Yes, Decline it!";
    }
    swal({
    title: title,
            /*text: "You will not be able to recover this.",*/
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            confirmButtonText: confirmButtonText,
            closeOnConfirm: false
    },
            function (isConfirm) {
            if (isConfirm) {
            var path = APP_URL + "/request_response";
            var from_id = id;
            var type = status;
            //alert(from_id);
            $.ajax({
            method: "POST",
                    url: path,
                    data : {from_id, type},
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                    var res = $.parseJSON(data);
                    if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                    }
                    else
                    {
                    swal('success', res.message, 'success');
                    datatable.reload();
                    }
                    },
                    error: function () {
                    //alert("Error");
                    }
            });
            } else {

            }
            });
    }
    /*-------------- untag friend/child ---------------*/
    function untagUser(user_id, untagname){

    var path = APP_URL + "/untag/friend";
    var _this = $(this);
    swal({
    title: "Are you sure to Untag " + untagname + "?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Yes, Untag it!",
            closeOnConfirm: false
    },
            function (isConfirm) {
            if (isConfirm) {
            var data = user_id;
            $.ajax({
            method: 'POST',
                    url: path,
                    data: {
                    id: data,
                    },
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                    var res = $.parseJSON(data);
                    if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                    } else {
                    $('.sweet-overlay').remove();
                    $('.showSweetAlert ').remove();
                    swal("Success", res.message, "success");
                    datatable.reload();
                    }
                    },
                    error: function (data) {
                    swal('Error', data, 'error');
                    }
            });
            } else {

            }
            });
    }
    /*------------- resend request--------------*/
    function resendRequest(id){
        
    }
</script>
@endsection