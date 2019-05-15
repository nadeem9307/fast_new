@extends('layouts.admin')

@section('page_title') 
Users 
@endsection 

@section('page_css')
@endsection
@section('content')
<style>
    select.m-bootstrap-select {
        opacity: 1;
    }
    .col-form-label .required{
        color: #e02222;
        font-size: 12px;
        padding-left: 2px;
    }
</style>

<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Users List
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{ url('/home')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="{{ route('getusers')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Users
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div>

        </div>
    </div>
</div>
<!-- END: Subheader -->
<div class="m-content">

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <!--begin: Search Form -->
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-12 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-3">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                            Status:
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" id="m_form_status">
                                            <option value="1">
                                                Active
                                            </option>
                                            <option value="2">
                                                Archive
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                            Type:
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" id="m_form_type">
                                            <option value="">
                                                Select User Type
                                            </option>
                                            <option value="2">
                                                Parent
                                            </option>
                                            <option value="3">
                                                Child
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                            Country:
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" id="country_id" name="country_id">
                                            <option value="">Select Country</option>
                                            @foreach($country as $item)
                                            <option value="{{$item->id}}">{{$item->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="d-md-none m--margin-bottom-10"></div>
                            </div>

                            <div class="col-md-3">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input m-input--solid" placeholder="Search Username" id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span>
                                            <i class="la la-search"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                            <a href="#" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air" id="user_data" data-toggle="modal" data-target="#model_add_user">
                                                <span>
                                                    <i class="la la-plus"></i>
                                                    <span>
                                                        Add User
                                                    </span>
                                                </span>
                                            </a> 
                    
                                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                                        </div>-->
                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="m_datatable" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    </div>
    <!-------------- user registration Model ---------------->
    <div class="modal fade" id="model_add_user" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        Add User
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="la la-remove"></span>
                    </button>
                </div>

                <form class="m-form m-form--fit m-form--label-align-right" name="add_users_form" id="add_users_form" method="POST" action="{{ route('adduser')}}">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group m-form__group row m--margin-top-20">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Country Name
                                <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <!--<div class="m-select2 m-select2--pill">-->
                                <select class="form-control" id="country"  name="country" data-placeholder="Pill style">
                                    <option value="">Please Select Country Name</option>
                                    @if(!empty($country))

                                    @foreach ($country as $country_name)
                                    <option value="{{$country_name->id}}">{{ $country_name->country_name }}</option>
                                    @endforeach
                                    @endif
                                </select>

                            </div>
                        </div>
                        <div class="form-group m-form__group row m--margin-top-20">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                User Type
                                <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-lg-6 col-md-9 col-sm-12" >
                                <select class="form-control" id="user_type"  name="user_type" data-placeholder="Pill style">
                                    <option value="">Please Select User Type</option>
                                    <option value="2">Parent</option>
                                    <option value="3">Child</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row m--margin-top-20">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Contact No.
                                <span class="required" aria-required="true">  </span>
                            </label>
                            <div class="col-lg-6 col-md-9 col-sm-12" >
                                <div class="m-typeahead">
                                    <input name="contact" class="form-control m-input" id="contact" type="number" placeholder="Contact no." value="{{ old('contact')}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row m--margin-top-20">
                            <input name="user_id" class="form-control m-input" id="user_id" type="hidden" value="">

                            <label class="col-form-label col-lg-3 col-sm-12">
                                Name
                                <span class="required" aria-required="true"> * </span>
                            </label>

                            <div class="col-lg-6 col-md-9 col-sm-12" >
                                <div class="m-typeahead">
                                    <input name="name"class="form-control m-input" id="name" type="text" placeholder=" Name" value="{{ old('name') }}">

                                </div>

                            </div>
                        </div>
                        <div class="form-group m-form__group row m--margin-top-20">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Username
                                <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-lg-6 col-md-9 col-sm-12" >
                                <div class="m-typeahead">
                                    <input name="username" class="form-control m-input" id="username" type="text" placeholder="Username" value="{{ old('username')}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row m--margin-top-20">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Email
                                <span class="required" aria-required="true"> </span>
                            </label>
                            <div class="col-lg-6 col-md-9 col-sm-12" >
                                <div class="m-typeahead">
                                    <input name="email" class="form-control m-input" id="email" type="email" placeholder="Email" value="{{ old('email')}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row m--margin-top-20">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Password
                                <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-lg-6 col-md-9 col-sm-12" >
                                <div class="m-typeahead">
                                    <input name="password" class="form-control m-input" id="password" type="password" placeholder="Password" value="{{ old('password')}}">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-danger m-btn" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-brand m-btn" id="add_user">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--------- End User Registration Model -------------->
</div>

@endsection
@section('page_script')
<script>
    /*----------------- Display listing of users through datatable using ajax request----------------*/
    var datatable;
    (function () {
        datatable = $('.m_datatable').mDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: APP_URL + "/users/show",
                        method: 'GET',
                        // custom headers
                        headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        params: {
                            // custom query params
                            query: {
                                username: '',
                                status: '',
                                user_type: '',
                                country_name: '',
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
                serverSorting: true
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
                /*{
                 field: "name",
                 title: "Name",
                 textAlign: 'center'
                 },*/
                {
                    field: "username",
                    title: "Username",
                    textAlign: 'center'
                },
                {
                    field: "fast_score",
                    title: "Fast Score",
                    textAlign: 'center'
                },
                {
                    field: "email",
                    title: "Email",
                    textAlign: 'center'
                },
                {
                    field: "contact",
                    title: "Contact No.",
                    textAlign: 'center'
                },
                {
                    field: "country_name",
                    title: "Country Name",
                    textAlign: 'center'
                },
                {
                    width: 110,
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    field: 'Actions',
                    template: function (row) {
                        /*-----for edit user----------*/
                        /* return '\
                         <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\
                         <i class="la la-edit" onclick=getUserDetail(' + row.id + ')></i>\
                         </a>\
                         \
                         ';*/
                        /*-----for edit user----------*/
                        if (row.user_type == 3) {
                            if (row.status) {
                                return '\
                 <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Archive" onclick=ArchivetoActiveUser(' + row.userId + ')>\
                    <i class="la la-trash"></i>\
                    </a>\
                    <a href="' + APP_URL + '/user/report/' + row.userId + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View Reports">\
                         <i class="flaticon-line-graph"></i>\
                         </a>\
                         \
                         ';
                            } else {
                                return '\
                   <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Archive"  onclick=deleteUser(' + row.userId + ')>\
                   <i class="la la-trash"></i>\
                   </a>\
                   <a href="' + APP_URL + '/user/report/' + row.userId + '" class="m - portlet__nav - link btn m - btn m - btn--hover - accent m - btn--icon m - btn--icon - only m - btn--pill" title="View Reports">\
                         <i class="flaticon-line-graph"></i>\
                         </a>\
                         \
                         ';
                            }

                        }
                        else if (row.user_type == 2) {
                            if (row.status) {
                                return '\
                 <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Archive" onclick=ArchivetoActiveUser(' + row.userId + ')>\
                    <i class="la la-trash"></i>\
                    </a>\
                    <a href="' + APP_URL + '/parent/user/report/' + row.userId + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="View Reports">\
                         <i class="flaticon-line-graph"></i>\
                         </a>\
                         \
                         ';
                            } else {
                                return '\
                   <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Archive"  onclick=deleteUser(' + row.userId + ')>\
                   <i class="la la-trash"></i>\
                   </a>\
                   <a href="' + APP_URL + '/parent/user/report/' + row.userId + '" class="m - portlet__nav - link btn m - btn m - btn--hover - accent m - btn--icon m - btn--icon - only m - btn--pill" title="View Reports">\
                         <i class="flaticon-line-graph"></i>\
                         </a>\
                         \
                         ';
                            }
                        }
                    }
                }
            ]
        });
        /*----------------- End Display listing of users through datatable using ajax request here----------------*/


        $('#add_cate').on('click', function () {
            datatable.reload();
        });
        /*----------------------filter data according to Username  ----------------------------*/

        $('#generalSearch').on('keypress', function () {

            var value = $(this).val();
            var status = $('#m_form_status').val();
            var user_type = $('#m_form_type').val();
            var country_id = $('#country_id').val();
            datatable.setDataSourceQuery({username: value, status: status, user_type: user_type, country_id: country_id});
            datatable.reload();
        });
        /*-----------------------Role wise  filter data   ----------------------------*/
        $('#m_form_type').on('change', function () {
            var value = $(this).val();
            var status = $('#m_form_status').val();
            var username = $('#generalSearch').val();
            var country_id = $('#country_id').val();
            datatable.setDataSourceQuery({username: username, status: status, user_type: value, country_id: country_id});
            datatable.reload();

        });
        /*----------------------Status wise  filter data  ----------------------------*/
        $('#m_form_status').on('change', function () {
            var value = $(this).val();
            var username = $('#generalSearch').val();
            var user_type = $('#m_form_type').val();
            var country_id = $('#country_id').val();
            datatable.setDataSourceQuery({username: username, status: value, user_type: user_type, country_id: country_id});
            datatable.reload();
        });
        $('#country_id').on('change', function () {
            var value = $(this).val();
            var username = $('#generalSearch').val();
            var user_type = $('#m_form_type').val();
            var status = $('#m_form_status').val();
            datatable.setDataSourceQuery({username: username, status: status, user_type: user_type, country_id: value});
            datatable.reload();
        });
    })();
    /*--------------For blank model fields--------------*/
    $('#user_data').click(function (e) {
        $('#country').val('');
        $('#user_type').val('');
        $('#user_id').val('');
        $('#name').val('');
        $('#username').val('');
        $('#email').val('');
        $('#contact').val('');
        $('#password').val('');
    });
    $('#add_user').click(function (e) {
        e.preventDefault();
        var id = $('#user_id').val();
        var country_id = $('#country').val();
        var user_type = $('#user_type').val();
        var name = $('#name').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var contact = $('#contact').val();
        var password = $('#password').val();
        if (country_id == '') {
            swal("Error", "Country Name  is required", "error");
            return false;
        }
        if (user_type == '') {
            swal("Error", "User Type  is required", "error");
            return false;
        }
        if (user_type == '2') {
            if (contact == '') {
                swal("Error", "Contact  is required", "error");
                return false;
            }
        }
        if (name == '') {
            swal("Error", "User Name  is required", "error");
            return false;
        }
        if (username == '') {
            swal("Error", "Username  is required", "error");
            return false;
        }

        if (password == '') {
            swal("Error", "Password  is required", "error");
            return false;
        }

        $.ajax({
            method: 'POST',
            url: $("#add_users_form").attr('action'),
            data: {
                id: id,
                country_id: country_id,
                user_type: user_type,
                name: name,
                username: username,
                email: email,
                password: password,
                contact: contact,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    $('#model_add_user').modal('hide');
                    swal("Success", res.message, "success");
                    datatable.reload();
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });
    });
    /*------- Get user reports------*/
    function getUserReport() {

    }
    /*------- end user reports------*/

    function getUserDetail(id) {
        var path = APP_URL + "/user/edit";
        $.ajax({
            method: "GET",
            url: path,
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
        
                var res = $.parseJSON(result);
                if (res.status == 'error') {

                } else {
                    var data = $.parseJSON(JSON.stringify(res.message));
                   
                    $('#model_add_user').find('.modal-title').html('Update User');
                    $('#country').val('');
                    $('#user_type').val('');
                    $('#user_id').val('');
                    $('#name').val('');
                    $('#username').val('');
                    $('#email').val('');
                    $('#contact').val('');
                    $('#password').val('');
                    var country = $('#country').val(data.country_id);
                    var user_type = $('#user_type').val(data.user_type);
                    var id = $('#user_id').val(data.id);
                    var name = $('#name').val(data.name);
                    var username = $('#username').val(data.username);
                    var email = $('#email').val(data.email);
                    var contact = $('#contact').val(data.contact);
                    var password = $('#password').val(data.password);
                    //loadTLData(data.country,data.tl_id);
                    $('#model_add_user').modal('show');
                }
            },
            error: function () {
                swal("Error");
            }
        });
    }
    /*--------------------------delete user data ------------------------------*/
    function deleteUser(id) {
        var path = APP_URL + "/user/destroy";
        var _this = $(this);
        swal({
            title: "Are you sure to delete this User?",
            text: "You will not be able to recover this.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
        function (isConfirm) {
            if (isConfirm) {
                var data = id;
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
    /*--------- Activate user archive to active----------*/
    function ArchivetoActiveUser(id) {
        var path = APP_URL + "/user/destroy";
        var _this = $(this);
        swal({
            title: "Are you sure you want to Activate/Archive this User?",
            text: "You will not be able to recover this.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Yes, Active/Archive it!",
            closeOnConfirm: false
        },
        function (isConfirm) {
            if (isConfirm) {
                var data = id;
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


    /*---------------------------delete user data----------------------------*/
</script>
@endsection