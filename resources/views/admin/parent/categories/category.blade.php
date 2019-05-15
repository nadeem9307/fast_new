@extends('layouts.admin')

@section('page_title') 
Parent Categories
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
                Parent Categories List
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
                    <a href="{{ route('parent_category')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Parent Category
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
                                        <select class="form-control m-bootstrap-select" id="m_form_status">
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
                                    <input type="text" class="form-control m-input m-input--solid" placeholder="Search Category name" id="generalSearch">
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
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                            <a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                <i class="la la-plus m--hide"></i>
                                <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="m-dropdown__wrapper" style="z-index: 101;">
                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 21.5px;"></span>
                                <div class="m-dropdown__inner">
                                    <div class="m-dropdown__body">
                                        <div class="m-dropdown__content">
                                            <ul class="m-nav">
                                                <li class="m-nav__section m-nav__section--first m--hide">
                                                    <span class="m-nav__section-text">Quick Actions</span>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class=" m-nav__link" id="user_data" data-toggle="modal" data-target="#model_add_category">
                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                        <span class="m-nav__link-text"> Add Category</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="{{ route('ParentOverallRange')}}" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-layers"></i>
                                                        <span class="m-nav__link-text">Manage Overall Interpretation</span>
                                                    </a>
                                                </li>

                                                <li class="m-nav__separator m-nav__separator--fit">

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                                <a href="{{ route('overallRange')}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                    <span>
                                                        <i class="la la-plus"></i>
                                                        <span>
                                                            Manage Overall </span> 
                                                        <span>Interpretation</span>
                                                    </span>
                                                </a> 
                        
                                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                                                <a href="#" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air" id="user_data" data-toggle="modal" data-target="#model_add_category">
                                                    <span>
                                                        <i class="la la-plus"></i>
                                                        <span>
                                                            Add Category
                                                        </span>
                                                    </span>
                                                </a> 
                        
                                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                                            </div>-->
                    </div>

                </div>
            </div>
            <!--end: Search Form -->
            <!--begin: Datatable -->
            <div class="m_datatable" id="local_data"></div>
            <!--end: Datatable -->
        </div>
    </div>
    <!-------------- user registration Model ---------------->
    <div class="modal fade" id="model_add_category" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lgs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        Add Category
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="la la-remove"></span>
                    </button>
                </div>

                <form class="m-form m-form--fit m-form--label-align-right" name="add_category" id="add_category" method="POST" action="{{ route('parent_addcategory')}}">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="form-group m-form__group row m--margin-top-20">
                            <input name="category_id" class="form-control m-input" id="category_id" type="hidden" value="">

                            <label class="col-form-label col-lg-3 col-sm-12">
                                Category Name
                                <span class="required" aria-required="true"> * </span>
                            </label>

                            <div class="col-lg-9 col-md-9 col-sm-12" >
                                <div class="m-typeahead">
                                    <input name="name"class="form-control m-input" id="category" type="text" placeholder="Category Name" value="{{ old('category') }}">

                                </div>

                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger m-btn" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-brand m-btn" id="add_cate">
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
                        url: APP_URL + "/parent/category/show",
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
                /*{
                 field: "status",
                 title: "Status",
                 textAlign: 'center',
                 template: function (row) {
                 if (row.status == '2') {
                 return '\
                 <a href="javascript:;" class="btn btn-success background_gradient btn-view" title="Deactivate" onclick=activate_deactivateCategory(' + row.id + ')>\
                 Deactivate\
                 </a>\
                 ';
                 } else
                 {
                 return '\
                 <a href="javascript:;" class="btn btn-success background_gradient btn-view" title="Activate" onclick=activate_deactivateCategory(' + row.id + ')>\
                 Activate\
                 </a>\
                 ';
                 }
                 
                 }
                 },*/
                {
                    width: 110,
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    field: 'Actions',
                    template: function (row) {
                        return '\
                 <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\
                   <i class="la la-edit" onclick=getCategoryDetail(' + row.id + ')></i>\
                   </a>\
                 <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"  onclick=deleteCategory(' + row.id + ')>\
                   <i class="la la-trash"></i>\
                   </a>\
                   \
                 ';
                    },
                },
                {
                    width: 110,
                    title: 'Manage Interpretation',
                    sortable: false,
                    overflow: 'visible',
                    field: 'interpretattion',
                    template: function (row) {
                        return '<a href="' + APP_URL + '/parent/interpretation/id/' + row.id + '" class="btn btn-success background_gradient btn-view" title="Manage">\
                   Manage\
                   </a>\
                 ';
                    },
                }
            ]
        });
        /*----------------- End Display listing of users through datatable using ajax request here----------------*/


        $('#add_cate').on('click', function () {
            datatable.reload();
        });
        /*----------------------filter data according to category_name  ----------------------------*/

        $('#generalSearch').on('keyup', function () {

            var value = $(this).val();
            var status = $('#m_form_status').val();
            if (value != '')
            {
                datatable.setDataSourceQuery({category_name: value, status: status});
                datatable.reload();
            } else
            {
                datatable.setDataSourceQuery({category_name: ''});
                datatable.reload();
            }

        });
        /*-----------------------Role wise  filter data   ----------------------------*/
//        $('#m_form_type').on('change', function () {
//            var value = $(this).val();
//
//            if (value != '')
//            {
//                datatable.setDataSourceQuery({category_name: value});
//                datatable.reload();
//            } else
//            {
//                datatable.setDataSourceQuery({category_name: ''});
//                datatable.reload();
//            }
//
//        });
        /*----------------------Status wise  filter data  ----------------------------*/
        $('#m_form_status').on('change', function () {
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


    })();
    /*--------------For blank model fields--------------*/
    $('#user_data').click(function (e) {
        $('#category_id').val('');
        $('#category').val('');


    });

    $('#add_cate').click(function (e) {
        e.preventDefault();
        var id = $('#category_id').val();
        var category = $('#category').val();
        var status = $('#status').val();


        if (category == '') {
            swal("Error", "Category Name  is required", "error");
            return false;
        }

        $.ajax({
            method: 'POST',
            url: $("#add_category").attr('action'),
            data: {
                id: id,
                category: category,
                status: status,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var res = $.parseJSON(data);
                if (res.status == 'error') {
                    swal('Error', res.message, 'error');
                } else {
                    $('#model_add_category').modal('hide');
                    swal("Success", res.message, "success");
                    datatable.reload();
//                    $("#ResponseSuccessModal #ResponseHeading").text(res.message);
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });
    });
    /*------------ Activate Category Status here--------------*/
    function activate_deactivateCategory(id) {
        var path = APP_URL + "/parent/category/status";

        $.ajax({
            method: "POST",
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
                    swal("Success", res.message, "success");
                    datatable.reload();
                }
            },
            error: function () {
                swal("Error");
            }
        });
    }
    /*------------ End Activatation Category Status here--------------*/
    function getCategoryDetail(id) {
        var path = APP_URL + "/parent/category/edit";
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
                    $('#model_add_category').find('.modal-title').html('Update Category');

                    var id = $('#user_id').val('');
                    var name = $('#category').val('');
                    var id = $('#category_id').val(data.id);
                    var name = $('#category').val(data.category_name);
                    //loadTLData(data.country,data.tl_id);
                    $('#model_add_category').modal('show');
                }
            },
            error: function () {
                swal("Error");
            }
        });
    }
    /*--------------------------delete category ------------------------------*/
    function deleteCategory(id) {
        var path = APP_URL + "/parent/category/destroy";
        var _this = $(this);
        swal({
            title: "Are you sure to delete this category?",
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
    /*---------------------------delete category data----------------------------*/
</script>
@endsection