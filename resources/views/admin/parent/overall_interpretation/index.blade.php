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
    $('.options_value').val('');
    $('#interpretation_id').val('');
    $('#country_code').val('');
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
</script>
@endsection