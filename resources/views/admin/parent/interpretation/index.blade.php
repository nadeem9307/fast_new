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
                All Interpretation Range
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
                    <a href="{{ url('/parent/categories')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                           Parent Category
                        </span>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="#" class="m-nav__link">
                        <span class="m-nav__link-text">
                           Parent Interpretation
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

                            <div class="col-md-4">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input m-input--solid" placeholder="Search Category Name" id="generalSearch">
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
                        <a href="#" id="myclear" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air" data-toggle="modal" data-target="#addNew_Interpretation">
                            <span>
                                <i class="la la-plus"></i>
                                <span>
                                    Add Range
                                </span>
                            </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="cat_id" name="cat_id" value="{{$category_id}}">
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="interpretation_datatable"></div>
            <!--end: Datatable -->
        </div>
    </div>
    <div class="modal fade" id="addNew_Interpretation" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lgx" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        Add New Interpretation Category wise
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="la la-remove"></span>
                    </button>
                </div>

                <form id="addinterpretation" class="m-form m-form--fit m-form--label-align-right"  action="{{ route('saveInterpetation')}}">

                    <input type="hidden" id="category_id" name="category_id" value="{{$category_id}}">
                    <input type="hidden" id="interpretation_id" name="interpretation_id" value="">

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
                            <input type="text" class="form-control border_bottom pl0" id="min_range" name="min_range" placeholder="Enter min range" maxlength="2">
                            <span>%</span>
                        </div>   
                        <div class="form-group">
                            <input type="text" class="form-control border_bottom pl0" id="max_range" name="max_range" placeholder="Enter max range" maxlength="3">
                            <span>%</span>
                        </div>
                    </div>  
                    <div id="MultiChoiceOptionDiv">
                        <div class="col-lg-12 m--margin-top-30">
                            <label class="col-form-label">
                                <input type="hidden" name="options[]" id="options">
                                Interpretation
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>

                        <div  data-repeater-list="" id="MultiAnswerResponse">
                            <div data-repeater-item class="d-flex align-items-center clonedOptionsForMultiChoice m--margin-bottom-10">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control options_value " aria-label="Enter Option">
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                                <div class="col-md-3">
                                    <div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
                                        <span>
                                            <i class="la la-trash-o"></i>
                                            <span>
                                                Delete
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"> 
                            <div class="col-lg-12 text-left">
                                <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>
                                            Add
                                        </span>
                                    </span>
                                </div>
                            </div>
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
    datatable = $('.interpretation_datatable').mDatatable({
// datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: APP_URL + '/interpretation/show/' + cat_id,
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
                field: "category_name",
                title: "Category Name",
                textAlign: 'center'

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
            {
                field: "interpretation",
                title: "Interpretation",
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
                       <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details" onclick=editInterpretation(' + row.id + ')>\
                       <i class="la la-edit"></i>\
                       </a>\
                       <a href="javascript:void(0);" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"  onclick=deleteInterprettation(' + row.id + ')>\
                       <i class="la la-trash"></i>\
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
    /*---------- Start searching code --------------------*/
    $('#generalSearch').on('change', function () {
        var value = $(this).val();
        if (value != '')
        {
            datatable.setDataSourceQuery({category_name: value});
            datatable.reload();
        } else
        {
            datatable.setDataSourceQuery({category_name: ''});
            datatable.reload();
        }

    });
    /*---------- End searching code --------------------*/

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
/*---------- Start add country code --------------------*/

$('#addRange').click(function (e) {
//e.preventDefault();
    var min_range = $('#min_range').val();
    var max_range = $('#max_range').val();
    var category_id = $('#category_id').val();
    var id = $('#interpretation_id').val();
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
    if (category_id == '') {
        swal("Error", "Category code is required", "error");
        return false;
    }
    var options = [];
    var i = 0;
    $('.options_value').each(function ()
    {
        if ($(this).val() != '') {
            options[i++] = $(this).val();
        }

    });
    var option = $('#options').val(options);
    $.ajax({
        method: 'POST',
        url: $("#addinterpretation").attr('action'),
        data: {
            id: id,
            category_id: category_id,
            interpretation: options,
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
                $('#addNew_Interpretation').modal('hide');
                datatable.reload();
            }

        },
        error: function (data) {
            swal('Error', data, 'error');


        }
    });
});
/*---------- End add country code ------------------------------*/




function editInterpretation(id) {
    var path = APP_URL + "/interpretation/edit";
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
                $('#category_id').val('');
                $('#interpretation_id').val('');
                $('#interpretation_id').val(data.id);
                $('#addNew_Interpretation').find('.modal-title').html('Update Interpretation ');
                $('#min_range').val(data.min_range);
                $('#max_range').val(data.max_range);
                $('#category_id').val(data.category_id);
                var j = 1;

                var interpre = $.parseJSON(data.interpretation);
                var ansHtml = '';
                $.each(interpre, function (idx, values) {
                    ansHtml += '<div data-repeater-item class="d-flex align-items-center clonedOptionsForMultiChoice m--margin-bottom-10"><div class="col-md-9"><div class="input-group"><input type="text" class="form-control options_value " aria-label="Enter Option" value="' + values + '"></div><div class="d-md-none m--margin-bottom-10"></div></div><div class="col-md-3"><div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill"><span><i class="la la-trash-o"></i><span>Delete</span></span></div></div></div>';
                    j++;

                });
                $("#MultiAnswerResponse").html(ansHtml);
                $('#addNew_Interpretation').modal('show');
            }
        },
        error: function () {
            alert("Error");
        }
    });
}

/*----------------Delete interprettation-------------------*/
function deleteInterprettation(id) {

    var path = APP_URL + "/interpretation/destroy";
    var _this = $(this);

    swal({

        title: "Are you sure to delete this Interpretation?",
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
    $('#addNew_Interpretation').find('.modal-title').html('Add New Interpretation Category wise');
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


</script>
@endsection