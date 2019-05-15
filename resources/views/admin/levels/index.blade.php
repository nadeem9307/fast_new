@extends('layouts.admin')
@section('page_title') 
Levels
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
                All Levels
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
                    <a href="{{ route('levels_view')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Levels
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
                                        <select class="form-control m-bootstrap-select" id="levelstatus">
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
                                    <input type="text" class="form-control m-input m-input--solid" placeholder="Search Level name" id="generalSearch">
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
                    <!--                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                            <a href="#" id="myclear" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air" data-toggle="modal" data-target="#addNew_Semester">
                                                <span>
                                                    <i class="la la-plus"></i>
                                                    <span>
                                                        Add Semester
                                                    </span>
                                                </span>
                                            </a>
                                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                                        </div>-->
                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="semester_datatable"></div>
            <!--end: Datatable -->
        </div>
    </div>

    <!-- Model start for the manage age range -->
    <div class="modal fade" id="model_age_range" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lgx" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        Manage Age Range
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="la la-remove"></span>
                    </button>
                </div>
                <form id="addnewagerange" class="m-form m-form--fit m-form--label-align-right"  action="{{ route('saveage_range')}}">
                    <input type="hidden" id="level_id" name="level_id" value="">
                    <div class="col-lg-12 m--margin-top-30">
                        <div class="form-group">
                            <label class="col-form-label">
                                Select Age
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div> 
                        <div class="m-ion-range-slider">
                            <input type="hidden" id="age_range"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-brand m-btn" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-brand m-btn" id="addageRange">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Model end for the manage age range -->

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
                        url: APP_URL + '/getlevels',
                        method: 'GET',
                        // custom headers
                        headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        params: {
                            // custom query params
                            query: {
                                status: '',
                                id: '',
                                level_name: '',

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

                {
                    field: "level_name",
                    title: "Level",
                    textAlign: 'center'


                },
                {
                    field: "min_age",
                    title: "Min Age",
                    textAlign: 'center'

                },
                {
                    field: "max_age",
                    title: "Max Age",
                    textAlign: 'center'

                },
                {
                   
                    title: 'Manage Age Range',
                    sortable: false,
                    overflow: 'visible',
                    field: 'Tagline',
                    template: function (row) {
                        /*-----for edit user----------*/
                        return '\
                 <a id="get_levels" href="javascipt:;" class="btn btn-accent m-btn " data-toggle="modal" data-target="#model_age_range" onClick="setLevelid(' + row.id + ')">\
                   Manage Age Range\
                   </a>\
                         \
                         ';
                    }
                }
                /*{
                 field: "status",
                 title: "Status",
                 textAlign: 'center',
                 
                 template: function (row) {
                 if (row.status == 2) {
                 return '\
                 <span class="m-badge m-badge--success m-badge--wide">Activate</span>\
                 \
                 ';
                 } else
                 {
                 return '\
                 <span class="m-badge m-badge--danger m-badge--wide">Deactivate</span>\
                 \
                 ';
                 }
                 
                 }
                 },*/

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
            var status = $('#levelstatus').val();
            if (value != '')
            {
                datatable.setDataSourceQuery({level_name: value, status: status});
                datatable.reload();
            } else
            {
                datatable.setDataSourceQuery({level_name: ''});
                datatable.reload();
            }

        });
        /*---------- End searching code --------------------*/

        /*---------- Start country status ------------- */
        $('#level_name').on('change', function () {
            var value = $(this).val();
            var status = $('#levelstatus').val();
            if (value != '')
            {
                datatable.setDataSourceQuery({status: status, id: value});
                datatable.reload();
            } else
            {
                datatable.setDataSourceQuery({status: '', id: ''});
                datatable.reload();
            }

        });

        /*---------- Start sub level status ------------- */
        $('#levelstatus').on('change', function () {
            var value = $(this).val();
            var levelstatus = $('#level_name').val();
            if (value != '')
            {
                datatable.setDataSourceQuery({status: value, id: levelstatus});
                datatable.reload();
            } else
            {
                datatable.setDataSourceQuery({status: '', id: ''});
                datatable.reload();
            }
        });
        /* ----------- End level status ------------ */
    })();


    function setLevelid(level_id) {
        $('#level_id').val(level_id);
        var path = APP_URL + "/levels/getage_range";
        var levelid = $('#level_id').val();


        $.ajax({
            method: 'POST',
            url: path,
            data: {
                id: levelid,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (levels) {
                var res = $.parseJSON(levels);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else if (res.status == 'success') {
                    var data_value = res.message;
                    setrangeslider(data_value);
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });
    }

    function setrangeslider(data_value) {
//        if (Array.isArray(data_value)) {
            var minage = parseInt(data_value.min_age);
            var maxage = parseInt(data_value.max_age);
            var $d5 = $(".m-ion-range-slider");
            $d5.ionRangeSlider({
                type: "double",
                grid: true,
                min: 0,
                max: 100,
                from: 0,
                to: 10,
            });

            var d5_instance = $d5.data("ionRangeSlider");
            d5_instance.update({
                min: 0,
                max: 100,
                from: minage,
                to: maxage,
            });
            $d5.on("change", function () {
                var $inp = $(this);
                var v = $inp.prop("value");     // input value in format FROM;TO
                var from = $inp.data("from");   // input data-from attribute
                var to = $inp.data("to");       // input data-to attribute
                $('#age_range').val(v);
 
            });

//        }
    }

    var IONRangeSlider = function () {
        //== Private functions
        var demos = function () {

            // custom prefix
            $('#age_range').ionRangeSlider({
                type: "double",
                grid: true,
                min: 0,
                max: 100,
                from: 0,
                to: 10,
            });

        }

        return {
            // public functions
            init: function () {
                demos();
            }
        };
    }();

    jQuery(document).ready(function () {
        IONRangeSlider.init();
    });
    /*--- End age range level selector ----*/

    /*---------- Start manage age range  --------------------*/

    $('#addageRange').click(function (e) {
        e.preventDefault();
        var age_range = $('#age_range').val().split(';');
        var level_id = $('#level_id').val();
        var min_age = age_range[0];
        var max_age = age_range[1];

        if (min_age == '') {
            swal("Error", "Min age  is required", "error");
            return false;
        }
        if (max_age == '') {
            swal("Error", "Max age  is required", "error");
            return false;
        }
        if (min_age == max_age) {
            swal("Error", "Max and Min age not be same or less than min age", "error");
            return false;
        }

//        if (max_age >= 101) {
//            swal("Error", "Please enter correct max age", "error");
//            return false;
//        }
//        if (min_age >= max_age) {
//            swal("Error", "Please enter correct min and max age", "error");
//            return false;
//        }

        $.ajax({
            method: 'POST',
            url: $("#addnewagerange").attr('action'),
            data: {
                id: level_id,
                min_age: min_age,
                max_age: max_age,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else if (res.status == 'success') {
                    swal("Success", res.message, "success");
                    $('#model_age_range').modal('hide');
                    datatable.reload();
                }

            },
            error: function (data) {
                swal('Error', data, 'error');


            }
        });
    });
    /*---------- End manage age range ------------------------------*/
</script>
@endsection