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
    img.img-responsive.loader_image {
        width: 37px;
        height: 35px;
    }
    img.img-responsive.modal_box_avatar {
        max-width: 80px;
        margin-left: 10px;
        margin-bottom: 10px;
    }
    .single_image .close-btn {
        position: absolute;
        top: -6px;
        right: -6px;
        color: red;
        border: 2px solid red;
        background: #fff;
        border-radius: 100%;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 16px;
        font-size: 12px;
    }

    .single_image {
        position: relative;
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
                    <a href="{{ url('/home')}}" class="m-nav__link m-nav__link--icon">
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
                    <a href="{{ route('overall')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Set Ranges
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
            <div class="m-form m-form--label-align-right  m--margin-bottom-30">
                <div class="row align-items-center">
                    <div class="col-xl-8 order-2 order-xl-1">
                    </div>
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <a href="#" id="myclear" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air" data-toggle="modal" data-target="#addNew_Range">
                            <span>
                                <i class="la la-plus"></i>
                                <span>
                                    Add Ranges
                                </span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>

            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="range_datatable"></div>
            <!--end: Datatable -->
        </div>
    </div>
    <div class="modal fade" id="addNew_Range" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lgx" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        Add New Range
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="la la-remove"></span>
                    </button>
                </div>
                <form id="addnewrange" class="m-form m-form--fit m-form--label-align-right"  action="{{ route('saveRange')}}">
                    <input type="hidden" id="overall_id" name="overall_id" value="">
                    <div class="col-lg-12 m--margin-top-30">
                        <div class="form-group">
                            <label class="col-form-label">
                                Select Range
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div> 
                    </div>
                    <div class="form_inline">
                        <div class="form-group">
                            <input type="number" class="form-control border_bottom pl0" id="min_range" name="min_range" placeholder="Enter min range" maxlength="2">
                            <span>%</span>
                        </div>   
                        <div class="form-group">
                            <input type="number" class="form-control border_bottom pl0" id="max_range" name="max_range" placeholder="Enter max range" maxlength="3">
                            <span>%</span>
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-brand m-btn" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-brand m-btn" id="addRange">
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
<div class="modal fade" id="addNewtagline" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">
                    Manage Tagline
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-remove"></span>
                </button>
            </div>

            <form id="addsummary" class="m-form m-form--fit m-form--label-align-right"  action="{{ route('saveRangeSummary')}}">


                <input type="hidden" id="ranges_id" name="ranges_id" value="">

                <div class="col-lg-9 m--margin-top-30">
                    <label class="col-form-label">
                        Summary
                        <span class="required" aria-required="true"> * </span>
                    </label>
                    <div class="form-group">
                        <textarea rows="4" cols="50" class="form-control border_bottom pl0" id="summary" name="summary" placeholder="Enter long summary"></textarea>

                    </div> 
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-brand m-btn" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-brand m-btn" id="addRangesummary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Response model start -->
<div class="modal fade" id="model_upload_avtar" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">
                    Upload Avatars
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-remove"></span>
                </button>
            </div>

            <form class="m-form m-form--fit m-form--label-align-right" name="upload_avtars" id="upload_avtars" method="POST" action="{{ route('storeAvatar')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="mylevelid" id="mylevelid" value="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Parent Male :
                        </label>
                        <input type="file" class="form-control form-control-danger" name="upload_avtars_pmale[]" placeholder="Parent Male" onchange="FilesLengthValidation(this);" id="upload_avtars_pmale" multiple/>
                        <div class="upload_avtars_pmale_image">
                        </div>
                        <div class="validation form-control-danger" style="display:none;"> Upload Max 4 Files allowed </div>
                    </div>
                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Parent Female:
                        </label>
                        <input type="file" class="form-control form-control-danger" name="upload_avtars_pfemale[]" placeholder="Parent Female" onchange="FilesLengthValidation(this);" id="upload_avtars_pfemale" multiple/>
                        <div class="upload_avtars_pfemale_image">
                        </div>
                        <div class="validation" style="display:none;"> Upload Max 4 Files allowed </div>
                    </div>
                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Child Male:
                        </label>
                        <input type="file" class="form-control form-control-danger" name="upload_avtars_cmale[]" placeholder="Child Female" onchange="FilesLengthValidation(this);" id="upload_avtars_cmale" multiple/>
                        <div class="upload_avtars_cmale_image">
                        </div>
                        <div class="validation" style="display:none;"> Upload Max 4 Files allowed </div>
                    </div>
                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Child Female:
                        </label>
                        <input type="file" class="form-control form-control-danger" name="upload_avtars_cfemale[]" placeholder="Child Female"onchange="FilesLengthValidation(this);"  id="upload_avtars_cfemale" multiple/>
                        <div class="upload_avtars_cfemale_image">
                        </div>
                        <div class="validation" style="display:none;"> Upload Max 4 Files allowed </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <img src="{{url('public/assets/app/media/img/loader/lg.vortex-spiral-spinner.gif')}}" class="img-responsive loader_image" style="display:none;">
                    <button type="button" class="btn btn-danger m-btn" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-brand m-btn" id="add_avatar">
                        Submit
                    </button>
                </div>
            </form>



        </div>
    </div>
</div>

@endsection

@section('page_script')
<script src="{{url('/public/js/question-page.js')}}" type="text/javascript"></script>
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
                                            width: 90,
                                            title: 'Actions',
                                            sortable: false,
                                            overflow: 'visible',
                                            field: 'Actions',
                                            template: function (row) {
                                                return '\
                       <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details" onclick=editRange(' + row.id + ')>\
                       <i class="la la-edit"></i>\
                       </a>\
                       <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"  onclick=deleteRange(' + row.id + ')>\
                       <i class="la la-trash"></i>\
                       </a>\
                       ';
                                            },
                                        },
                                        {
                                            width: 120,
                                            title: 'Manage Tagline',
                                            sortable: false,
                                            overflow: 'visible',
                                            field: 'Tagline',
                                            template: function (row) {
                                                return '<a href="javascript:void(0);" class="btn btn-accent m-btn background_gradient btn-view" title="Manage Tagline" onclick=addTagline(' + row.id + ')>\
                   Manage Tagline\
                   </a>\
                 ';
                                            },
                                        },
                                        {
                                            width: 120,
                                            title: 'Manage Avatars',
                                            sortable: false,
                                            overflow: 'visible',
                                            field: 'Avatars',
                                            template: function (row) {
                                                /*-----for edit user----------*/
                                                if (row.status) {
                                                    return '\
                 <a href="javascipt:;" class="btn btn-accent m-btn " data-toggle="modal" data-target="#model_upload_avtar" onClick="setLevelid(' + row.id + ')">\
                   Upload Avtar\
                   </a>\
                         \
                         ';
                                                }
                                            }
                                        },
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
                            /*---------- Start add --------------------*/

                            $('#addRange').click(function (e) {
//e.preventDefault();
                                var id = $('#overall_id').val();
                                var min_range = $('#min_range').val();
                                var max_range = $('#max_range').val();
                                if (min_range == '') {
                                    swal("Error", "Min value  is required", "error");
                                    return false;
                                }
                                if (max_range == '') {
                                    swal("Error", "Max value  is required", "error");
                                    return false;
                                }

                                if (min_range == max_range) {
                                    swal("Error", "Max and Min value not be same or less than min value", "error");
                                    return false;
                                }

                                if (max_range >= 101) {
                                    swal("Error", " less than min value", "error");
                                    return false;
                                }

                                $.ajax({
                                    method: 'POST',
                                    url: $("#addnewrange").attr('action'),
                                    data: {
                                        id: id,
                                        min_range: min_range,
                                        max_range: max_range,
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
                                            $('#addNew_Range').modal('hide');
                                            datatable.reload();
                                        }

                                    },
                                    error: function (data) {
                                        swal('Error', data, 'error');


                                    }
                                });
                            });
                            /*---------- End add country code ------------------------------*/




                            function editRange(id) {
                                var path = APP_URL + "/overallRange/edit";
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
                                            $('#min_range').val('');
                                            $('#max_range').val('');
                                            $('#overall_id').val('');
                                            $('#overall_id').val(data.id);
                                            $('#addNew_Range').find('.modal-title').html('Update Ranges ');
                                            $('#min_range').val(data.min_range);
                                            $('#max_range').val(data.max_range);
                                            $('#addNew_Range').modal('show');
                                        }
                                    },
                                    error: function () {
                                        alert("Error");
                                    }
                                });
                            }

                            /*----------------Delete interprettation-------------------*/
                            function deleteRange(id) {
                                var path = APP_URL + "/overallRange/destroy";
                                var _this = $(this);
                                swal({
                                    title: "Are you sure to delete this Range?",
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
                                                    /*$("#ResponseSuccessModal").modal('show');
                                                     $("#ResponseSuccessModal #ResponseHeading").text(res.message);*/
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
                            /*---------- Start empty popup code  --------------------*/
                            $('#myclear').click(function (e) {
                                e.preventDefault();
                                $('#addNew_Range').find('.modal-title').html('Set Over All Score Range');
                                $('#min_range').val('');
                                $('#max_range').val('');
                                // $('.options_value').val('');
                                // $('#interpretation_id').val('');
                                // $('#country_code').val('');
                                $('#overall_id').val('');
                               
                            });
                            /*---------- End empty popup code --------------------*/

                            /*----- Start activate country code ----------------------*/
                            function activateCountry(id) {
                                var path = APP_URL + "/countries/activate";
                                var _this = $(this);
                                swal({
                                    title: "Are you sure to activate this Country?",
                                    text: "",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, Activate it!",
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
//           swal.close()
//          $("#ResponseSuccessModal").modal('show');
//          $("#ResponseSuccessModal #ResponseHeading").text(res.message);
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
// manage taglines//
                            function addTagline(id) {
                                $('#ranges_id').val(id);
                                var path = APP_URL + "/get_summary";
                                $.ajax({
                                    method: 'POST',
                                    url: path,
                                    data: {
                                        id: id,
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
                                            $('#ranges_id').val(data.id);
                                            $('#summary').val(data.summary);
                                            $('#addNewtagline').modal('show');
                                        }
                                    },
                                    error: function () {
                                        alert("Error");
                                    }
                                });

                            }
                            $('#addRangesummary').on('click', function () {
                                var range_id = $('#ranges_id').val();
                                var summary = $('#summary').val();
                                $.ajax({
                                    method: 'POST',
                                    url: $("#addsummary").attr('action'),
                                    data: {
                                        id: range_id,
                                        summary: summary,
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
                                            $('#addNew_Range').modal('hide');
                                            $('#addNewtagline').modal('hide');
                                            datatable.reload();
                                        }

                                    },
                                    error: function (data) {
                                        swal('Error', data, 'error');


                                    }
                                });
                            });
                            /*--------- Start store avatar for parent and child -------*/
                            $('#add_avatar').on('click', function (e) {

                                e.preventDefault();
                                var levelid = $('#mylevelid').val();
                                var upload_avtars_pmale = $('#upload_avtars_pmale').val();
                                var upload_avtars_pfemale = $('#upload_avtars_pfemale').val();
                                var upload_avtars_cmale = $('#upload_avtars_cmale').val();
                                var upload_avtars_cfemale = $('#upload_avtars_cfemale').val();
                                var form = $('#upload_avtars')[0];
                                var data = new FormData(form);
                                $('.loader_image').show();
//                                if (upload_avtars_pmale == '') {
//                                    swal("Error", "Please select avatar for parent male", "error");
//                                    return false;
//                                }
//                                if (upload_avtars_pfemale == '') {
//                                    swal("Error", "Please select avatar for parent female", "error");
//                                    return false;
//                                }
//                                if (upload_avtars_cmale == '') {
//                                    swal("Error", "Please select avatar for child male", "error");
//                                    return false;
//                                }
//                                if (upload_avtars_cfemale == '') {
//                                    swal("Error", "Please select avatar for child female", "error");
//                                    return false;
//                                }



                                $.ajax({
                                    method: 'POST',
                                    enctype: 'multipart/form-data',
                                    url: $("#upload_avtars").attr('action'),
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
                                            swal("Success", "Image uploaded successfully", "success");
                                            $('.loader_image').hide();
                                            window.location.reload();
                                        }
                                    },
                                    error: function (data) {
                                        swal('Error', data, 'error');
                                        $('.loader_image').hide();
                                    }
                                });
                            });
                            /*--------- End store avatar for parent and child ---------*/
                            function setLevelid(level_id) {
                                $('#mylevelid').val(level_id);
                                $('.upload_avtars_pmale_image').empty();
                                $('.upload_avtars_pfemale_image').empty();
                                $('.upload_avtars_cmale_image').empty();
                                $('.upload_avtars_cfemale_image').empty();

                                $.ajax({
                                    method: 'GET',
                                    url: APP_URL + '/overall/ranges/avtars',
                                    data: {id: level_id},
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function (data) {
                                        var res = JSON.parse(data);

                                        if (res.status == 'success') {
                                            if (res.message.parent_male_avatar != '') {
                                                $(JSON.parse(res.message.parent_male_avatar)).each(function (idx, pavtar) {
                                                 
                                                    $('.upload_avtars_pmale_image').append('<div class="single_image"><a href="' + APP_URL + '/storage/app/levelavatar/pmale/' + pavtar + '" target="_blank"><img src="' + APP_URL + '/storage/app/levelavatar/pmale/' + pavtar + '" class="img-responsive modal_box_avatar"></a><i class="fa fa-times close-btn" data-filepath="pmale" data-imagename="' + pavtar + '" onclick="removed_image(this)"></i></div>');
                                                });
                                            }
                                            if (res.message.parent_female_avatar != '') {
                                                $(JSON.parse(res.message.parent_female_avatar)).each(function (id, pfemale) {
                                                  
                                                    $('.upload_avtars_pfemale_image').append('<div class="single_image"><a href="' + APP_URL + '/storage/app/levelavatar/pfemale/' + pfemale + '" target="_blank"><img src="' + APP_URL + '/storage/app/levelavatar/pfemale/' + pfemale + '" class="img-responsive modal_box_avatar"></a><i class="fa fa-times close-btn" data-filepath="pfemale" data-imagename="' + pfemale + '" onclick="removed_image(this)"></i></div>');
                                                });
                                            }
                                            if (res.message.child_male_avatar != '') {
                                                $(JSON.parse(res.message.child_male_avatar)).each(function (ids, cmale) {
                                                    $('.upload_avtars_cmale_image').append('<div class="single_image"><a href="' + APP_URL + '/storage/app/levelavatar/cmale/' + cmale + '" target="_blank"><img src="' + APP_URL + '/storage/app/levelavatar/cmale/' + cmale + '" class="img-responsive modal_box_avatar"></a><i class="fa fa-times close-btn" data-filepath="cmale" data-imagename="' + cmale + '" onclick="removed_image(this)"></i></div>');
                                                });
                                            }
                                            if (res.message.child_female_avatar != '') {
                                                $(JSON.parse(res.message.child_female_avatar)).each(function (ida, cfemale) {
                                                    $('.upload_avtars_cfemale_image').append('<div class="single_image"><a href="' + APP_URL + '/storage/app/levelavatar/cfemale/' + cfemale + '" target="_blank"><img src="' + APP_URL + '/storage/app/levelavatar/cfemale/' + cfemale + '" class="img-responsive modal_box_avatar"></a><i class="fa fa-times close-btn" data-filepath="cfemale" data-imagename="' + cfemale + '" onclick="removed_image(this)"></i></div>');
                                                });
                                            }
                                        } else if (res.status == 'error') {
                                            swal('Error', res.message, 'error');
                                        }
                                    },
                                    error: function (data) {
                                        swal('Error', data, 'error');
                                    }
                                });
                            }

                            function FilesLengthValidation(e) {
                                //$('#upload_avtars_pmale').change(function(){
                                //get the input and the file list
//                                var exist_image = $(e).closest('div').nextAll().find('.single_image');
                                var exist_image =  $(e).next('div').find('.single_image');
                             
                                if (exist_image.length == 4 && e.files.length == 4 || exist_image.length == 4 && e.files.length == 3 || exist_image.length == 4 && e.files.length == 2 || exist_image.length == 4 && e.files.length == 1 || exist_image.length == 3 && e.files.length == 4 || exist_image.length == 3 && e.files.length == 3 || exist_image.length == 3 && e.files.length == 2 || exist_image.length == 2 && e.files.length == 4 || exist_image.length == 2 && e.files.length == 3 || exist_image.length == 1 && e.files.length == 4 ){
                                    swal("Error", "Upload Max 4 Files allowed", 'error');
                                    $(e).val('');
                                    return false;
                                }
                                if (e.files.length > 4) {
                                    // $('.validation').css('display','block');
                                    swal("Error", "Upload Max 4 Files allowed", 'error');
                                    $(e).val('');
                                    return false;
                                } else {
                                    $('.validation').css('display', 'none');
                                }
                            }
                            function removed_image(image) {
                                $(image).parent('.single_image').remove();
                                var filepath = $(image).data('filepath');
                                var img_name = $(image).data('imagename');
                                var level_id = $('#mylevelid').val();
                                $.ajax({
                                    method: 'POST',
                                    url: APP_URL + '/avtars/delete',
                                    data: {id: level_id, filepath: filepath, img_name: img_name},
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function (data) {
                                        var res = JSON.parse(data);
                                        swal('success', res.message, 'success');
                                    },
                                    error: function (data) {
                                        swal('Error', data, 'error');
                                    }
                                });
                            }
//});
</script>
@endsection