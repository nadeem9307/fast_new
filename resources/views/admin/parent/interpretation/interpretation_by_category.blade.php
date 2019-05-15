@extends('layouts.admin')
@section('page_title') 
Interpreation
@endsection 
@section('page_css')
@endsection
@section('content')
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
                            Parent Categories
                        </span> 
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="#" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Set Interpretation
                        </span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- END: Subheader -->
<style>
    .score_range .score_range_block{
        padding: 15px;
        margin-bottom: 30px;
        cursor: pointer;
    }
</style>
<div class="m-content">
    <div class="m-portlet m-portlet--mobile score_range"> 
        <!--begin: Search Form -->
        <div class="row">
            @foreach($data as $range)
            @if(in_array($range['id'],array_column($cate_data,'range_id')))
            <div class="col-xl-2 col-sm-3" onclick="getInterpretation({{$range['id']}},{{$category_id}})">  
                <div class="score_range_block text-center bg-success">
                    <input type="hidden" name="range_id" value="{{$range['id']}}">
                    <div class="align-items-center"><h5 class="text-white">Range</h5>	
                        <span class="align-items-center text-white">{{$range['min_range']}}-{{$range['max_range']}}</span></div>	
                </div>

            </div>
            @else
            <div class="col-xl-2 col-sm-3" onclick="setInterpretation({{$range['id']}},{{$category_id}})">  
                <div class="score_range_block text-center bg-danger">
                    <input type="hidden" name="range_id" value="{{$range['id']}}">
                    <div class="align-items-center"><h5 class="text-white">Range</h5>	
                        <span class="align-items-center text-white">{{$range['min_range']}}-{{$range['max_range']}}</span></div>	
                </div>

            </div>
            @endif
            @endforeach

        </div> 
         <input type="hidden" id="category_id" name="category_id" value="{{$category_id}}">
        <div class="modal fade" id="addNew_Interpretation" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="manage_int">
                            Manage Interpretations of @if(isset($cat->category_name)){{$cat->category_name}}@endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="la la-remove"></span>
                        </button>
                    </div>

                    <form id="addinterpretation" class="m-form m-form--fit m-form--label-align-right">
                        <input type="hidden" id="ranges_id" name="ranges_id" value="">
                        <input type="hidden" id="id" name="id" value="">
                        <!--
                        
                                                <div class="col-lg-12 m--margin-top-30">
                                                    <div class="form-group">
                                                        <label class="col-form-label">
                                                            Select Range
                                                            <span class="required" aria-required="true"> * </span>
                                                        </label>
                                                    </div> 
                                                </div>-->
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
                                            <textarea class="form-control options_value " aria-label="Enter Option"></textarea>
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
                            <button type="button" class="btn btn-brand m-btn" id="addCatInterpretation">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('page_script')
<script src="{{url('/public/js/question-page.js')}}" type="text/javascript"></script>

<script>

                        $('#addCatInterpretation').click(function (e) {

                var range_id = $('#ranges_id').val();
                        var id = $('#id').val();
                        var category_id = $('#category_id').val();
                        var i = 0;
                        var options = [];
                        $('.options_value').each(function (){
                if ($(this).val() != '') {
                options[i++] = $(this).val();
                }
                });
                        $.ajax({
                        method: 'POST',
                                url: APP_URL + '/parent/category/interpretation',
                                data: {
                                id: id,
                                        range_id: range_id,
                                        category_id:category_id,
                                        interpretation:options,
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
                                        window.location.reload();
                                }

                                },
                                error: function (data) {
                                swal('Error', data, 'error');
                                }
                        });
                });
                 $('#addNew_Interpretation').on('hidden.bs.modal', function (e) {
                        $(this)
                                .find("input,textarea,select")
                                .val('')
                                .end()
                                .find("input[type=checkbox], input[type=radio]")
                                .prop("checked", "")
                                .end();
                        $('.clonedOptionsForMultiChoice:not(:first)').remove();
                                });
                                
                        function setInterpretation(range_id, category_id    ){
                       
                                $('#ranges_id').val(range_id);
                                $('#addNew_Interpretation').modal('show');
                        }


                function getInterpretation(range_id, category_id){

                $('#ranges_id').val();
                        $.ajax({
                        method: 'GET',
                                url: APP_URL + "/parent/interpretation/edit",
                                data: {
                                range_id: range_id,
                                        category_id: category_id,
                                },
                                headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (data) {
                                var res = JSON.parse(data);
                                        if (res.status == 'error') {
                                swal('Error', res.message, 'error');
                                } else if (res.status == 'success') {
                                        if (res.message.id != '') {
                                $('#id').val(res.message.id);
                                        $('#ranges_id').val(res.message.range_id);
                                        $('#category_id').val(res.message.category_id);
                                        var j = 1;
                                        var ansHtml = '';
                                        $(JSON.parse(res.message.interpretation)).each(function(idx, val) {
                                        ansHtml += '<div data-repeater-item class="d-flex align-items-center clonedOptionsForMultiChoice m--margin-bottom-10"><div class="col-md-9"><div class="input-group"><textarea class="form-control options_value " aria-label="Enter Option">' + val + '</textarea></div><div class="d-md-none m--margin-bottom-10"></div></div><div class="col-md-3"><div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill"><span><i class="la la-trash-o"></i><span>Delete</span></span></div></div></div>';
                                        j++;
                                });
                                        $("#MultiAnswerResponse").html(ansHtml);
                                } else {
                                $("#MultiAnswerResponse").html('');
                                        var ansHtml = '';
                                        ansHtml += '<div data-repeater-item class="d-flex align-items-center clonedOptionsForMultiChoice m--margin-bottom-10"><div class="col-md-9"><div class="input-group"><textarea class="form-control options_value " aria-label="Enter Option"></textarea></div><div class="d-md-none m--margin-bottom-10"></div></div><div class="col-md-3"><div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill"><span><i class="la la-trash-o"></i><span>Delete</span></span></div></div></div>';
                                        $("#MultiAnswerResponse").html(ansHtml);
                                }
                                $('#addNew_Interpretation').modal('show');
                                }

                                },
                                error: function (data) {
                                swal('Error', data, 'error');
                                }
                        });
                }




</script>
@endsection 