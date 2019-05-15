@extends('layouts.admin')
@section('page_title') 
Semesters
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
                All Countries
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
                    <a href="{{ route('sublevels_view')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Sub Levels
                        </span>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">
                            {{$sublevel_data->sublevel_name}} (Semester)
                        </span>
                    </a>
                </li>
            </ul>
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
                    <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                            <div class="col-md-4">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label">
                                        <label>
                                            Status:
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <select class="form-control m-bootstrap-select" id="semester_status">
                                            <option value="1">
                                                Active
                                            </option>
                                            <option value="2">
                                                Archive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- start level filter -->
                            <div class="col-md-4">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input m-input--solid" placeholder="Search Semester" id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span>
                                            <i class="la la-search"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <!-- end sub level filter -->
                        </div>
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <a href="#" id="myclear" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air" data-toggle="modal" data-target="#addNew_Semester">
                            <span>
                                <i class="la la-plus"></i>
                                <span>
                                    Add Semester
                                </span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="semester_datatable"></div>
            <!--end: Datatable -->
        </div>
    </div>
    <div class="modal fade" id="addNew_Semester" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        Add New Semester
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="la la-remove"></span>
                    </button>
                </div>
                <form id="addsemesterstore" class="m-form m-form--fit m-form--label-align-right" method="POST" action="{{route('storeSemester')}}">
                    <input type="hidden" id="sublevel_id" name="sublevel_id" value="{{$sublevel_data->id}}">
                    <input type="hidden" id="semester_tag_id" name="semester_tag_id" value="">
                    <div class="modal-body">
                        <div class="form-group m-form__group row m--margin-top-20">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Semester Name
                                <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="m-typeahead">
                                    <input type="text" class="form-control border_bottom pl0" id="semester_name" name="semester_name" placeholder="Enter semester name" maxlength="30">
                                </div>
                            </div>
                        </div>
                        <!-- add priority ------>
                        <div class="form-group m-form__group row m--margin-top-20">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Priority
                                <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="m-typeahead">
                                    <!--<input type="number" class="form-control border_bottom pl0" id="priority_order" name="priority_order" placeholder="Please set your semester priority" maxlength="30">-->
                                    <input type="text" class="form-control border_bottom pl0" id="priority_order" name="priority_order" placeholder="Please set your semester priority" maxlength="30">
                                </div>
                            </div>
                        </div>
                        <!-- end priority ------>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-brand m-btn" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-brand m-btn" id="addsemester">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

@endsection

@section('page_script')
<script>

    var datatable;
    (function () {
        datatable = $('.semester_datatable').mDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: APP_URL + '/getsemesters/{{$sublevel_data->id}}',
                        method: 'GET',
                        // custom headers
                        headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        params: {
                            // custom query params
                            query: {
                                sem_name: '',
                                status: '',
                                sublevel_id: '',
                            }
                        },
                        map: function (raw) {
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

            columns: [{
                    field: "S_No",
                    title: "S.No",
                    width: 40

                },

                /*{
                    field: "sublevel_name",
                    title: "Sub Level",
                    textAlign: 'center'

                },*/
                {
                    field: "sem_name",
                    title: "Semester Name",
                    textAlign: 'center'

                },
                {
                    width: 90,
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    field: 'Actions',
                    template: function (row) {
                        /*-----for edit user----------*/
                        if (row.status) {
                            return '\
                 <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\
                   <i class="la la-edit" onclick=editSemester(' + row.id + ')></i>\
                   </a>\
                    <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Archive" onclick=ArchivetoActiveUser(' + row.id + ')>\
                    <i class="la la-trash"></i>\
                    </a>\
                         \
                         ';
                        } else {
                            return '\
                   <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\
                   <i class="la la-edit" onclick=editSemester(' + row.id + ')></i>\
                   </a>\
                   <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Archive"  onclick=deleteUser(' + row.id + ')>\
                   <i class="la la-trash"></i>\
                   </a>\
                         \
                         ';
                        }
                    }
                }

            ]
        });

        $('#addsemester').on('click', function () {
            datatable.reload();
        });

        $('#LoadURMDatatable').on('click', function () {
            datatable.reload();
        });

        /*---------- Start searching code --------------------*/
        $('#generalSearch').on('keypress', function () {
            var value = $(this).val();
            var status = $('#semester_status').val();
            if (value != '')
            {
                datatable.setDataSourceQuery({sem_name: value, status: status});
                datatable.reload();
            } else
            {
                datatable.setDataSourceQuery({sem_name: ''});
                datatable.reload();
            }

        });
        /*---------- End searching code --------------------*/

        /*------ Start active or achive status -----------*/
        $('#semester_status').on('change', function () {
            var value = $(this).val();
            if (value != '')
            {
                datatable.setDataSourceQuery({status: value});
                datatable.reload();
            } else
            {
                datatable.setDataSourceQuery({status: ''});
                datatable.reload();
            }

        });
        /*------ End active or archive status ------------*/
    })();


    /*---------- Start add country code --------------------*/

    $('#addsemester').click(function (e) {
        e.preventDefault();
        var id = $('#semester_tag_id').val();
        var sublevels = $('#sublevel_id').val();
        var semester_name = $('#semester_name').val();
        var priority_order = $('#priority_order').val();

        if (sublevels == '') {
            swal("Error", "Please select sublevel", "error");
            return false;
        }
        if (semester_name == '') {
            swal("Error", "Please enter your semester name", "error");
            return false;
        }
        if (priority_order == '') {
            swal("Error", "Please set your semester priority", "error");
            return false;
        }

        $.ajax({
            method: 'POST',
            url: $("#addsemesterstore").attr('action'),
            data: {
                id: id,
                sublevels: sublevels,
                semester_name: semester_name,
                priority_order: priority_order,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    $('#addNew_Semester').modal('hide');
                    $("#ResponseSuccessModal").modal('show');
                    $("#ResponseSuccessModal #ResponseHeading").text(res.message);
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });
    });

    /*---------- End add country code ------------------------------*/

    /*--------- Validation start for country name short code and country code -----------------------*/
    $('#semester_name').keypress(function (e) {
        var regex = new RegExp("[a-zA-Z0-9\ s]+");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else
        {
            e.preventDefault();
            return false;
        }
    });
    /*--------- Validation End for country name short code and country code ------------------------*/

    /*---------- Start edit country code --------------------*/

    function editSemester(id) {
        var path = APP_URL + "/get_semesters/edit";
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
                    swal('Error', res.message, 'error');
                } else {
                    var data = $.parseJSON(JSON.stringify(res.message));
                    $('#semester_name').val('');
                    $('#priority_order').val('');
                    $('#addNew_Semester').find('.modal-title').html('Update Semester ' + data.sem_name);
                    $('#semester_tag_id').val(data.id);
                    $('#semester_name').val(data.sem_name);
                    $('#priority_order').val(data.priority);
                    $('#addNew_Semester').modal('show');

                }
            },
            error: function () {
                alert("Error");
            }
        });
    }
    /*---------- Start empty popup code  --------------------*/
    $('#myclear').click(function (e) {
        e.preventDefault();
        $('#addNew_Semester').find('.modal-title').html('Add New Semester');
        $('#semester_tag_id').val('');
        $('#semester_name').val('');
        $('#priority_order').val('');

    });
    /*---------- End empty popup code --------------------*/


    /* --------- Delete semester --------------------*/
    /*--------------------------delete user data ------------------------------*/
    function deleteUser(id) {
        var path = APP_URL + "/semesters/destroy";
        var _this = $(this);
        swal({
            title: "Are you sure to delete this Semester?",
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
    /*---------- End delete semester ----------------*/
    /*--------- Activate semester archive to active----------*/
    function ArchivetoActiveUser(id) {
        var path = APP_URL + "/semesters/destroy";
        var _this = $(this);
        swal({
            title: "Are you sure you want to Activate/Archive this Semester?",
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
    /*--------- End Activate semester archive to active----------*/
     /*-- input masking for age --*/
            var Inputmask = {
                init: function ()
                {
                    $("#priority_order").inputmask({mask: "9", repeat: 5, greedy: !1});
                }
            }
            jQuery(document).ready(function () {
                Inputmask.init()
            });
            /*-- end input masking for age --*/

</script>
@endsection