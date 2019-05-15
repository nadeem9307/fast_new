@extends('layouts.admin')
@section('page_title') 
Countries
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
                        <a href="{{ route('allcountry')}}" class="m-nav__link">
                            <span class="m-nav__link-text">
                              Countries
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
                                            <select class="form-control m-bootstrap-select" id="country_status">
                                                <option value="1">
                                                    Active
                                                </option>
                                                <option value="2">
                                                    Deactive
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input m-input--solid" placeholder="Search country name" id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="#" id="myclear" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air" data-toggle="modal" data-target="#addNew_Country">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add Country
                                    </span>
                                </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>
                <!--end: Search Form -->
                <!--begin: Datatable -->
                 <div class="countries_datatable"></div>
                <!--end: Datatable -->
            </div>
        </div>
        <div class="modal fade" id="addNew_Country" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">
                            Add New Country
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="la la-remove"></span>
                        </button>
                    </div>
                    <form id="addcountrystore" class="m-form m-form--fit m-form--label-align-right" method="POST" action="{{route('saveCountry')}}">
                        <input type="hidden" id="country_tag_id" name="country_tag_id" value="">

                        <div class="modal-body">
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-3 col-sm-12">
                                   Country Name
                                    <span class="required" aria-required="true"> * </span>
                                </label>

                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <div class="m-typeahead">
                                        <input name="country_name" class="form-control m-input" id="country_name" type="text" maxlength="30" placeholder="Please enter your country name">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-3 col-sm-12">
                                    Short Code
                                    <span class="required" aria-required="true"> * </span>
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <div class="m-typeahead">
                                        <input type="text" class="form-control border_bottom pl0" id="short_code" name="short_code" placeholder="Enter short code of your country" maxlength="2">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-3 col-sm-12">
                                  Mobile Code
                                    <span class="required" aria-required="true"> * </span>
                                </label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <div class="m-typeahead">
                                     <input type="text" class="form-control border_bottom pl0" id="country_code" name="country_code" placeholder="Enter Mobile code of your country" maxlength="6">
                                    </div>
                                </div>
                            </div>
                             
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-brand m-btn" data-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-brand m-btn" id="addcountry">
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
        datatable = $('.countries_datatable').mDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: APP_URL + '/countries/show',
                        method: 'GET',
                        // custom headers
                        headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        params: {
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
                serverFiltering: true,
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

            columns: [{
                    field: "S_No",
                    title: "S.No",
                    width: 40

                },
                {
                    field: "country_name",
                    title: "Name",
                    textAlign: 'center'

                },
                {
                    field: "short_code",
                    title: "Short Code",
                    textAlign: 'center'

                },
                {
                    field: "country_code",
                    title: "Mobile Code",
                    textAlign: 'center'

                },

                {
                    field: "status",
                    title: "Status",
                    textAlign: 'center',

                    template: function (row) {
                        if (row.status == 2) {
                            return '\
                 <a href="javascript:;" class="btn btn-danger background_gradient btn-view" title="Active" onclick=activateCountry(' + row.id + ')>\
                    Active\
                    </a>\
                 ';
                        } else
                        {
                            return '\
                 <a href="javascript:;" class="btn btn-success background_gradient btn-view" title="Deactivate" onclick=deactivateCountry(' + row.id + ')>\
                   Active\
                   </a>\
                 ';
                        }

                    }
                },
                {
                    width: 90,
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    field: 'Actions',
                    template: function (row) {
                        return '\
                 <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\
                   <i class="la la-edit" onclick=editCountry(' + row.id + ')></i>\
                   </a>\
                   \
                 ';
                    },
                }
            ]
        });

        $('#addcountry').on('click', function () {
            datatable.reload();
        });

        $('#LoadURMDatatable').on('click', function () {
            datatable.reload();
        });

        /*---------- Start searching code --------------------*/
        $('#generalSearch').on('change', function () {
            var value = $(this).val();
            var country_status = $('#country_status').val();
            if (value != '')
            {
                datatable.setDataSourceQuery({status: country_status, country_name: value});
                datatable.reload();
            } else
            {
                datatable.setDataSourceQuery({status: country_status, country_name: value});
                datatable.reload();
            }

        });
        /*---------- End searching code --------------------*/

        /*---------- Start country status ------------- */
        $('#country_status').on('change', function () {
            var value = $(this).val();
            var country_name = $('#generalSearch').val();
            if (value != '')
            {
                datatable.setDataSourceQuery({status: value, country_name: country_name});
                datatable.reload();
            } else
            {
                datatable.setDataSourceQuery({status: value, country_name: country_name});
                datatable.reload();
            }

        });
        / ----------- End country status ------------ /

    })();


    /*---------- Start add country code --------------------*/

    $('#addcountry').click(function (e) {
        e.preventDefault();
        var id = $('#country_tag_id').val();
        var country_name = $('#country_name').val();
        var short_code = $('#short_code').val();
        var country_code = $('#country_code').val();

        if (country_name == '') {
            swal("Error", "Country name is required", "error");
            return false;
        }
        if (short_code == '') {
            swal("Error", "Country short code is required", "error");
            return false;
        }
        if (country_code == '') {
            swal("Error", "Mobile Code is required", "error");
            return false;
        }

        $.ajax({
            method: 'POST',
            url: $("#addcountrystore").attr('action'),
            data: {
                id: id,
                country_name: country_name,
                short_code: short_code,
                country_code: country_code,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    $('#addNew_Country').modal('hide');
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
    $('#country_name').keypress(function (e) {
        var regex = new RegExp("[a-zA-Z\ s]+");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else
        {
            e.preventDefault();
            return false;
        }
    });
    $('#short_code').keypress(function (e) {
        var regex = new RegExp("[a-zA-Z\s]+");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else
        {
            e.preventDefault();
            return false;
        }
    });
    $('#country_code').keypress(function (e) {
        var regex = new RegExp("[0-9-]");
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

    function editCountry(id) {
        var path = APP_URL + "/countries/edit";
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
                    $('#country_name').val('');
                    $('#short_code').val('');
                    $('#country_code').val('');
                    $('#country_tag_id').val('');
                    $('#country_tag_id').val(data.id);
                    $('#addNew_Country').find('.modal-title').html('Update Country ' + data.country_name);
                    $('#country_name').val(data.country_name);
                    $('#short_code').val(data.short_code);
                    $('#country_code').val(data.country_code);
                    $('#addNew_Country').modal('show');

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
        $('#addNew_Country').find('.modal-title').html('Add New Country');
        $('#country_tag_id').val('');
        $('#country_name').val('');
        $('#short_code').val('');
        $('#country_code').val('');

    });
    /*---------- End empty popup code --------------------*/
    /*----- Start activate country code ----------------------*/
    function activateCountry(id) {
        var path = APP_URL + "/countries/activate";
        var _this = $(this);
        swal({
            title: "Are you sure to Active this Country?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-info",
            confirmButtonText: "Yes, Active it!",
            closeOnConfirm: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        var data = id;
                        $.ajax({
                            type: 'POST',
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
                                    swal("Success", res.message, "success");
                                    $('.sweet-overlay').remove();
                                    $('.showSweetAlert ').remove();
                                    swal("Success", res.message, "success");
                                    datatable.reload();
                                    return true;
                                }
                            },
                            error: function (data) {
                                swal('Error', data, 'error');
                                return false;
                            }
                        });
                    }
                });
    }

    /*---- End activate country code ------------------------*/

    /*----- Start deactive country code ---------------------- */
    function deactivateCountry(id) {
        var path = APP_URL + "/countries/deactivate";
        var _this = $(this);
        swal({
            title: "Are you sure to deactivate this Country?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-info",
            confirmButtonText: "Yes, Deactivate it!",
            closeOnConfirm: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        var data = id;
                        $.ajax({
                            type: 'POST',
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
                                    swal("Success", res.message, "success");
                                    $('.sweet-overlay').remove();
                                    $('.showSweetAlert ').remove();
                                    swal("Success", res.message, "success");
                                    datatable.reload();
                                    return true;
                                }
                            },
                            error: function (data) {
                                swal('Error', data, 'error');
                                return false;
                            }
                        });
                    }
                });
    }
    / ------ End deactive country code -------------------- /


</script>
@endsection