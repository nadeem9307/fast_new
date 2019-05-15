@extends('layouts.admin')
@section('page_title') 
Interpreation
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


    .form_inline {
        display: flex;
        align-items: center;
        padding: 0 15px;
    }
    .form_inline .form-group{
        width:50%;
    }
    .form_inline .form-group .form-control{
        width:90%;
        display: inline-block;
    }

</style>
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Set Over All Score Range
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <!--                <li class="m-nav__item">
                                    <a href="{{ url('/home')}}" class="m-nav__link">
                                        <span class="m-nav__link-text">
                                            Dashboard
                                        </span>
                                    </a>
                                </li>-->
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="{{ url('parent/categories')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                          Parent Set Interpretation
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
                                        <select class="form-control m-bootstrap-select" id="interpretation_status">
                                            <option value="">
                                                All
                                            </option>
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

                            <!--                            <div class="col-md-4">
                                                            <div class="m-input-icon m-input-icon--left">
                                                                <input type="text" class="form-control m-input m-input--solid" placeholder="Search Category Name" id="generalSearch">
                                                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                                                    <span>
                                                                        <i class="la la-search"></i>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>-->
                        </div>
                    </div>

                </div>
            </div>

            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="range_datatable"></div>
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
    var cat_id = $('#cat_id').val();
    datatable = $('.range_datatable').mDatatable({
// datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: APP_URL + '/overall/ranges/show',
                    method: 'GET',
                    // custom headers
                    headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                    params: {
                        // custom query params
                        query: {
                            name: '',
                            status: '',
                        }
                    },
                    map: function (raw) {
                        // sample data mapping
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
                field: "min_range",
                title: "Min Range",
                textAlign: 'center'

            },
            {
                field: "max_range",
                title: "Max Range",
                textAlign: 'center'

            },

            /*{
             field: "status",
             title: "Status",
             textAlign: 'center',
             /* template: function (row) {
             if (row.status == 2) {
             return '\
             <a href="javascript:;" class="btn btn-success background_gradient btn-view" title="Deactivate" onclick=activateCountry(' + row.id + ')>\
             Deactivate\
             </a>\
             ';
             } else
             {
             return '\
             <a href="javascript:;" class="btn btn-success background_gradient btn-view" title="Activate" onclick=deactivateCountry(' + row.id + ')>\
             Activate\
             </a>\
             ';
             }
             
             }
             },*/
           
            {
                width: 110,
                title: 'Manage Interpretation',
                sortable: false,
                overflow: 'visible',
                field: 'interpretattion',
                template: function (row) {
                    return '<a href="' + APP_URL + '/parent/interpretation/range/'+ row.id+ '" class="btn btn-success background_gradient btn-view" title="Manage">\
                   Manage\
                   </a>\
                 ';
                },
            }
        ]
    });
    $('#addRange').on('click', function () {
        datatable.reload();
    });
    $('#LoadURMDatatable').on('click', function () {
        datatable.reload();
    });


    /*---------- Start country status ------------- */
    $('#interpretation_status').on('change', function () {
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
    /* ----------- End country status ------------ */

})();

</script>
@endsection