@extends('layouts.admin')
@section('page_title') 
SubLevels
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
                All Sub Levels
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
                                        <select class="form-control m-bootstrap-select" id="sublevel_status">
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
                            <!-- start sub level filter -->
                            <div class="col-md-4">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input m-input--solid" placeholder="Search Sub Level name" id="generalSearch">
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

                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="sublevel_datatable"></div>
            <!--end: Datatable -->
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
        datatable = $('.sublevel_datatable').mDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: APP_URL + '/getsublevels',
                        method: 'GET',
                        // custom headers
                        headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        params: {
                            // custom query params
                            query: {
                                status: '',
                                level_id: '',

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
                    field: "sublevel_name",
                    title: "Sub Level",
                    textAlign: 'center'

                },
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
                {
                    width: 90,
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    field: 'Actions',
                    template: function (row) {
                        /*-----for edit user----------*/
                        if (row.status == 1) {
                            return '<a href="' + APP_URL + '/semesters/' + row.id + '" class="btn btn-success background_gradient btn-view" title="View Semester">\
                   View Semester\
                   </a>\
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
        /*---------- Start searching code --------------------*/
        $('#generalSearch').on('keypress', function () {

            var value = $(this).val();
            var status = $('#sublevel_status').val();
            if (value != '')
            {
                datatable.setDataSourceQuery({sublevel_name: value, status: status});
                datatable.reload();
            } else
            {
                datatable.setDataSourceQuery({sublevel_name: ''});
                datatable.reload();
            }

        });
        /*---------- End searching code --------------------*/

        /*---------- Start country status ------------- */
        $('#sublevel_name').on('change', function () {
            var value = $(this).val();
            var status = $('#sublevel_status').val();
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
        $('#sublevel_status').on('change', function () {
            var value = $(this).val();
            var levelstatus = $('#sublevel_name').val();
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


</script>
@endsection