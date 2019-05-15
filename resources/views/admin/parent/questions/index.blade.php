@extends('layouts.admin')

@section('page_title')
Questions
@endsection

@section('page_css')
@endsection
@section('content')
<style>
    select.m-bootstrap-select {
        opacity: 1;
    }

    .col-form-label .required {
        color: #e02222;
        font-size: 12px;
        padding-left: 2px;
    }

    audio.player {
        width: 100px;
    }

    #fill_attached_file_show audio.player {
        width: 300px;
    }

    #multi_attached_file_show audio.player {
        width: 300px;
    }

    #arrange_attached_file_show audio.player {
        width: 300px;
    }
</style>
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Parent All Questions
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{url('/home')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="{{url('/parent/questions')}}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Parent All Questions
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div>
        </div>
    </div>
    <div class="row">
        <!-- upload question csv start -->
        <div class="col-xl-12 col-md-12  col-sm-12">
            <button class="btn btn-primary m-btn m-btn--icon" id="upload_questions">
                <span>
                    <i class="fa fa-upload"></i>
                    <span>
                        Upload Questions
                    </span>
                </span>
            </button>

            <!-- upload question csv end ---->
            <!-- add question start -->
            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow" m-dropdown-toggle="click" aria-expanded="true" style="margin-top: 15px; ">
                <a href="#" class="m-dropdown__toggle btn btn-primary dropdown-toggle">
                    <span>
                        Add Question
                    </span>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__content">
                                <ul class="m-nav">
                                    <li class="m-nav__section m-nav__section--first">
                                        <span class="m-nav__section-text">
                                            Select Question Type
                                        </span>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="javascript:;" id="FillBlankQuestionType" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-share"></i>
                                            <span class="m-nav__link-text">
                                                Fill in the Blank question
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="javascript:;" class="m-nav__link" id="MultiChoiceQuestionType">
                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                            <span class="m-nav__link-text">
                                                Multi Choice Question
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="javascript:;" id="ArrangeOrderQuestionType" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-info"></i>
                                            <span class="m-nav__link-text">
                                                Arrange Order
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End add question -->
    </div>
</div>
<!-- END: Subheader -->
<div class="m-content">
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile col-xl-12">
                <div class="m-portlet__head col-xl-12">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title float-left col-xl-2">
                            <h3 class="m-portlet__head-text">Questions</h3>
                        </div>
                        <div class="float-left col-xl-3">
                            <select class="form-control mx-auto" id="categorylist" style="margin-top: 15px; ">
                                <option value="">Select Category</option>
                                @foreach($categories as $item)
                                <option value="{{$item->id}}">{{$item->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="float-left col-xl-3">
                            <select class="form-control mx-auto" id="countrylist" style="margin-top: 15px; ">
                                <option value="">Select Country</option>
                                @foreach($countries as $item)
                                <option value="{{$item->id}}">{{$item->country_name}}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>



                </div>
                <div class="m-portlet__body col-xl-12">
                    <div class="tasks_datatable col-xl-12" id="local_data">
                    </div>
                </div>
            </div>
            <!-- <div class="m-portlet m-portlet--mobile col-xl-12">

            </div> -->
        </div>
    </div>
    <!--End::Main Portlet-->
    <!--Begin::Main Portlet-->

    <!--End::Main Portlet-->
</div>
<!-- Modal for short question type -->
<div class="modal fade" id="FillBlankTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Fill in the blank(s).
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <form name="fm-student" id="fill-blanks-form" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Category Name *:
                        </label>
                        <select class="form-control " id="fill_category_id" name="fill_category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $item)
                            <option value="{{$item->id}}">{{$item->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Country Name *:
                        </label>
                        <select class="form-control js-example-basic-multiple" id="fill_country_id" name="fill_country_id[]" multiple="multiple" style="width:448px;">
                            <!--<option>Select Country</option>-->
                            @foreach($countries as $item)
                            <option value="{{$item->id}}">{{$item->country_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Attach File :
                        </label>
                        <input type="file" class="form-control form-control-danger" name="fill_attached_file" placeholder="Points of Question" id="fill_attached_file">
                    </div>

                    <div class="form-group" id="fill_attached_file_show" style="display:none;">
                    </div>

                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Question *:
                        </label>
                        <textarea type="text" name="fill_question_input" id="fill_question_input" class="form-control"></textarea>
                        <input type="hidden" name="fill_question_id" id="fill_question_id">
                    </div>
                    <input type="hidden" name="answer[]" id="answers">
                    <div id="FillInTheBlanksAnswers">
                        <div class="form-group  m-form__group row">
                            <label for="fillblank-input" class="form-control-label">
                                Answer for blank(s) :
                            </label>
                            <div data-repeater-list="" id="FillAnswerResponse" class="col-lg-12 ">
                                <div data-repeater-item class="row m--margin-bottom-10 clonedInputsForBlank">
                                    <div class="col-lg-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-danger ans_input" name="fill_answer_input" placeholder="Answer" id="">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
                                            <i class="la la-remove"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col">
                                <div data-repeater-create="" class="btn btn btn-primary m-btn m-btn--icon">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="FillBlankTypeBtn">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for multi choice question type -->
<div class="modal fade" id="MultiChoiceQuestionTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Multi Choice Question/Answer
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <form name="fm-student" id="multi-choice-form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Category Name:
                        </label>
                        <select class="form-control" id="multi_category_id" name="multi_category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $item)
                            <option value="{{$item->id}}">{{$item->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Country Name:
                        </label>
                        <select class="form-control js-example-basic-multiple" id="multi_country_id" name="multi_country_id[]" multiple="multiple" style="width:448px;">

                            @foreach($countries as $item)
                            <option value="{{$item->id}}">{{$item->country_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Attach File :
                        </label>
                        <input type="file" class="form-control form-control-danger" name="multi_attached_file" placeholder="Points of Question" id="multi_attached_file">
                    </div>

                    <!--<div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                          Share Url :
                        </label>
                        <input type="text" class="form-control form-control-danger" name="multi_shared_url" placeholder="Enter link of shared url" id="multi_shared_url">
                    </div>-->
                    <div class="form-group" id="multi_attached_file_show" style="display:none;">
                    </div>

                    <input type="hidden" name="options[]" id="options">
                    <input type="hidden" name="correct_answer[]" id="correct_answer">
                    <input type="hidden" name="multi_question_id" id="multi_question_id">
                    <div class="form-group">
                        <label for="shortQuestion-input" class="form-control-label">
                            Question :
                        </label>
                        <textarea name="multi_question_input" id="multi_question_input" class="form-control"></textarea>
                    </div>


                    <div id="MultiChoiceOptionDiv">
                        <div class="form-group  m-form__group">
                            <label for="multiQuestion-option" class="form-control-label">
                                Option(s) :
                            </label>
                            <div data-repeater-list="" id="MultiAnswerResponse">
                                <div data-repeater-item class="form-group m-form__group row align-items-center clonedOptionsForMultiChoice">
                                    <div class="col-md-9">
                                        <div class="input-group m-form__group">
                                            <span class="input-group-addon">

                                                <input type="checkbox" class="check_answer">


                                            </span>
                                            <input type="text" class="form-control options_value" aria-label="Enter Option">
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
                        </div>
                        <div class="m-form__group form-group row">
                            <label class="col-lg-2 col-form-label"></label>
                            <div class="col-lg-4">
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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="MultiChoiceQuestionTypeBtn">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal for multi choice question type -->
<div class="modal fade" id="ArrangeOrderQuestionTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Arrange Order Question/Answer
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <form name="fm-student" id="arrange-order-form" enctype="multipart/form-data">
                <div class="modal-body">

                    <div id="ArrangeOrderParts">
                        <div class="form-group">
                            <label for="fillblank-input" class="form-control-label">
                                Category Name:
                            </label>
                            <select class="form-control" id="arrange_category_id" name="arrange_category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $item)
                                <option value="{{$item->id}}">{{$item->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fillblank-input" class="form-control-label">
                                Country Name:
                            </label>
                            <select class="form-control js-example-basic-multiple" id="arrange_country_id" name="arrange_country_id[]" multiple="multiple" style="width:448px;">

                                @foreach($countries as $item)
                                <option value="{{$item->id}}">{{$item->country_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="fillblank-input" class="form-control-label">
                                Attach File :
                            </label>
                            <input type="file" class="form-control form-control-danger" name="arrange_attached_file" placeholder="Points of Question" id="arrange_attached_file">
                        </div>
                        <!--<div class="form-group">
                            <label for="fillblank-input" class="form-control-label">
                              Share Url :
                            </label>
                            <input type="text" class="form-control form-control-danger" name="arrange_shared_url" placeholder="Enter link of shared url" id="arrange_shared_url">
                        </div>-->

                        <div class="form-group" id="arrange_attached_file_show" style="display:none;">

                        </div>

                        <input type="hidden" name="correct_order[]" id="correct_order">
                        <input type="hidden" name="incorrect_order[]" id="incorrect_order">

                        <div class="form-group">
                            <label for="arrangeQuestion-input" class="form-control-label">
                                Question :
                            </label>
                            <textarea name="arrange_question_input" id="arrange_question_input" class="form-control"></textarea>
                        </div>
                        <input type="hidden" name="arrange_question_id" id="arrange_question_id">

                        <div class="form-group  m-form__group row" id="DoClone">
                            <label class="col-lg-2 col-form-label">
                                Parts:
                            </label>
                            <div data-repeater-list="" class="col-lg-10 " id="ArrangeOrderPartsDiv">
                                <div data-repeater-item class="m--margin-bottom-10 clone_number" id="clone0">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-check"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-danger incorrect_order" placeholder="Enter Question Part">
                                        <span class="input-group-btn" data-repeater-delete="">
                                            <a href="javascript:;" class="btn btn-danger m-btn m-btn--icon">
                                                <i class="la la-close"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col">
                                <div data-repeater-create="" class="btn btn btn-warning m-btn m-btn--icon">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>
                                            Add
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-info" id="ArrangeOrderBtn">Arrange Correct Order</button>
                            </div>

                        </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                        <ul id="ArrangeOrderDiv" type="none">
                        </ul>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="ArrangeOrderQuestionTypeBtn">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="UploadQuestionCSVmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="UploadLabel">
                    Upload CSV
                </h5>
                <form id="csv_form">
                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Category Name:
                        </label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $item)
                            <option value="{{$item->id}}">{{$item->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fillblank-input" class="form-control-label">
                            Country Name:
                        </label>
                        <select class="form-control js-example-basic-multiple" id="upload_country_id" name="upload_country_id[]" multiple="multiple" style="width:448px;">
                            <option></option>
                            @foreach($countries as $item)
                            <option value="{{$item->id}}">{{$item->country_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image" class="form-control-label">
                            Question CSV*:
                        </label>
                        <input type="file" class="form-control" id="questionCSV" name="file" accept=".csv">
                    </div>
                    <div>
                        <a target="_blank" href="{{url('storage/app/question_csv/1548844728.csv')}}">Download Sample CSV</a>
                    </div>
                </form>
                <div class="bulkUpload">
                    <div class="moda_footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" id="uploadquestions">
                            Save
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal for success response -->
<div class="modal fade" id="ResponseSuccessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form name="fm-student" id="arrange-order-form1">
                <div class="modal-body">
                    <h5 id="ResponseHeading"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" id="LoadTaskDatatable">
                        OK
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('page_script')
<script type="text/javascript" src="{{url('/public/js/parent-question.js')}}"></script>
<script src="{{url('/public/js/question-page.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script>
    $("#FillBlankQuestionType").on('click', function() {
        $("#FillBlankTypeModal").modal('show');
    })

    $("#MultiChoiceQuestionType").on('click', function() {
        $("#MultiChoiceQuestionTypeModal").modal('show');
    })

    $("#ArrangeOrderQuestionType").on('click', function() {
        $("#ArrangeOrderQuestionTypeModal")
            .find("input,textarea,select")
            .val('');
        $("#ArrangeOrderQuestionTypeModal #ArrangeOrderDiv").html('');
        $(this).data('id', '');

        $("#ArrangeOrderQuestionTypeModal").modal('show');
    })

    $("#ArrangeOrderQuestionTypeModal #DoSortable").sortable({
        stop: function(event, ui) {}
    });
    $('#fill_task_points').on('blur', function() {
        $('#fill_attempt_1').val($(this).val());
    });
    $('#multi_task_points').on('blur', function() {
        $('#multi_attempt_1').val($(this).val());
    });
    $('#arrange_task_points').on('blur', function() {
        $('#arrange_attempt_1').val($(this).val());
    });

    $("#ArrangeOrderQuestionTypeModal #ArrangeOrderBtn").on('click', function() {
        var list_number = 1;
        $("#ArrangeOrderQuestionTypeModal #ArrangeOrderDiv").html('');
        $("#ArrangeOrderPartsDiv .clone_number").each(function() {
            var order_text = $(this).find('input').val();
            var OrderList = "<li id=" + list_number + ">" + order_text + "</li>";
            $("#ArrangeOrderQuestionTypeModal #ArrangeOrderDiv").append(OrderList);
            list_number++;
        });

        $("#ArrangeOrderDiv").sortable({
            stop: function(event, ui) {}
        });

    })


    /*========Fill in the blanks===========*/
    $(function() {
        $("#FillBlankTypeBtn").on('click', function(event) {
            event.preventDefault();
            // var category_id = $(this).find('#fill_category_id').val();
            var category_id = $('#fill_category_id').val();
            var country_id = $('#fill_country_id').val();
            // alert(category_id);
            // return false;

            if (category_id == '') {
                swal('Error', 'Please select your category', 'error');
                return false;
            }
            if (country_id == '') {
                swal('Error', 'Please select your country', 'error');
                return false;
            }
            var answers = [];
            i = 0;
            $('.ans_input').each(function() {
                let val = $(this).val().trim();
                if (val != '') {
                    answers[i++] = val;
                }

            });
            if (answers.length == 0) {
                swal('Error', 'Please fill the correct answer', 'error');
                return false;
            }
            $('#answers').val(answers);
            var form = $('#fill-blanks-form')[0];
            var data = new FormData(form);
            var question = $("#fill_question_input").val().trim();
            var questionid = $('#FillBlankTypeModal').data('id');

            //alert(questionid);

            if (question != '') {
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: APP_URL + '/parent/store_question_fill_blanks',
                    /*data: {
                     answers : answers,
                     category_id:category_id,
                     question: question,
                     question_id:questionid,
                     },*/
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(res) {
                        $('#FillBlankTypeBtn').prop('disabled', true);
                        //$('#loader').show();
                        //$(body).css('@zindex-modal-background','1040')
                    },
                    success: function(data) {
                        $('#FillBlankTypeBtn').prop('disabled', false);
                        var res = $.parseJSON(data);
                        if (res.status == 'error') {
                            swal('Error', res.message, 'error');
                        } else {
                            $("#FillBlankTypeModal").modal('hide');
                            $("#ResponseSuccessModal").modal('show');
                            $("#ResponseSuccessModal #ResponseHeading").text(res.message);
                        }
                    },
                    error: function(data) {
                        $('#FillBlankTypeBtn').prop('disabled', false);
                        swal('Error', data, 'error');
                    }
                });
            } else {
                swal('Error', 'Please fill out input boxes', 'error');

            }

        });
    });

    /*========Multi Choice==================*/

    $(function() {
        $("#MultiChoiceQuestionTypeBtn").click(function(event) {
            event.preventDefault();
            var category_id = $('#multi_category_id').val();
            var country_id = $('#multi_country_id').val();


            if (category_id == '') {
                swal('Error', 'Please select your category', 'error');
                return false;
            }
            if (country_id == '') {
                swal('Error', 'Please select your country', 'error');
                return false;
            }
            var options = [];
            var correct_answer = [];
            i = 0;
            $('.options_value').each(function() {
                let val = $(this).val().trim();
                if (val != '') {
                    correct_answer[i] = $(this).siblings().children().val();
                    options[i++] = val;
                }

            });
            // if (options.length == 0) {
            //     swal('Error', 'Please fill the correct answer', 'error');
            //     return false;
            // }
            $('#options').val(options.join('`^`'));
            $('#correct_answer').val(correct_answer);
            var form = $('#multi-choice-form')[0];
            var data = new FormData(form);
            var question = $("#multi_question_input").val();
            var questionid = $('#MultiChoiceQuestionTypeModal').data('id');

            if (question != '') {
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: APP_URL + '/parent/store_question_multi_choice',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    /*data: {
                     options : options,
                     question: question,
                     category_id:category_id,
                     correct_answer : correct_answer,
                     question_id:questionid,
                     task_points:task_points,
                     attempt_1:attempt_1,
                     attempt_2:attempt_2,
                     attempt_3:attempt_3,
                     attempt_above:attempt_above,
                     },*/
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(res) {
                        $('#MultiChoiceQuestionTypeBtn').prop('disabled', true);
                    },
                    success: function(data) {
                        $('#MultiChoiceQuestionTypeBtn').prop('disabled', false);
                        var res = $.parseJSON(data);
                        if (res.status == 'error') {
                            swal('Error', res.message, 'error');
                        } else {
                            $("#MultiChoiceQuestionTypeModal").modal('hide');
                            $("#ResponseSuccessModal").modal('show');
                            $("#ResponseSuccessModal #ResponseHeading").text(res.message);
                        }
                    },
                    error: function(data) {
                        $('#MultiChoiceQuestionTypeBtn').prop('disabled', false);
                        swal('Error', data, 'error');
                    }
                });
            } else {
                swal('Error', 'Please fill out input boxes', 'error');

            }

        });
    });


    $(document).on("change", "input[class='check_answer']", function() {
        if (this.checked) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
    });

    /*======Arrange Order==============*/

    $(function() {
        $("#DoClone").on('focusout', 'input.incorrect_order', function() {
            $("#ArrangeOrderDiv li").remove();
        });
        $("#ArrangeOrderQuestionTypeBtn").click(function(event) {
            event.preventDefault();
            var category_id = $('#arrange_category_id').val();
            var country_id = $('#arrange_country_id').val();

            if (category_id == '') {
                swal('Error', 'Please select your category', 'error');
                return false;
            }
            if (country_id == '') {
                swal('Error', 'Please select your country', 'error');
                return false;
            }


            var incorrect_order = [];
            var correct_order = [];
            i = 0;
            $('.incorrect_order').each(function() {
                let val = $(this).val().trim();
                if (val != '') {
                    incorrect_order[i++] = val;
                }

            });
            $('#ArrangeOrderDiv li').each(function(index) {
                let val = $(this).text().trim();
                if (val != '') {
                    correct_order.push(val);
                }
            });
            // if (incorrect_order.length == 0) {
            //     swal('Error', 'Please fill the correct answer', 'error');
            //     return false;
            // }

            // if (correct_order.length == 0) {
            //     swal('Error', 'Please fill the correct answer', 'error');
            //     return false;
            // }
            $('#correct_order').val(correct_order.join('`^`'));
            $('#incorrect_order').val(incorrect_order.join('`^`'));
            var form = $('#arrange-order-form')[0];
            var data = new FormData(form);
            var question = $("#arrange_question_input").val();
            var questionid = $('#ArrangeOrderQuestionTypeModal').data('id');

            if (question != '') {
                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: APP_URL + '/parent/store_question_arrange_order',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    /*data: {
                     incorrect_order : incorrect_order,
                     correct_order : correct_order,
                     question: question,
                     category_id:category_id,
                     question_id:questionid,
                     },*/
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(res) {
                        $('#ArrangeOrderQuestionTypeBtn').prop('disabled', true);
                    },
                    success: function(data) {
                        $('#ArrangeOrderQuestionTypeBtn').prop('disabled', false);
                        var res = $.parseJSON(data);
                        if (res.status == 'error') {
                            swal('Error', res.message, 'error');
                        } else {
                            $("#ArrangeOrderQuestionTypeModal").modal('hide');
                            $("#ResponseSuccessModal").modal('show');
                            $("#ResponseSuccessModal #ResponseHeading").text(res.message);
                            $("#ArrangeOrderDiv").sortable({
                                stop: function(event, ui) {}
                            });
                        }
                    },
                    error: function(data) {
                        $('#ArrangeOrderQuestionTypeBtn').prop('disabled', false);
                        swal('Error', data, 'error');
                    }
                });
            } else {
                swal('Error', 'Please fill out input boxes', 'error');

            }

        });
    });


    $('#FillBlankTypeModal').on('hidden.bs.modal', function(e) {
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
        $(this).data('id', '');
        $("#fill_attached_file_show").css("display", "none");
        $('.select2-selection__rendered li').remove();

    })


    $('#MultiChoiceQuestionTypeModal').on('hidden.bs.modal', function(e) {
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
        $(this).data('id', '');
        $('.select2-selection__rendered li').remove();
        $("#multi_attached_file_show").css("display", "none");
        $('.clonedOptionsForMultiChoice:not(:first)').remove();
    })


    $('#ArrangeOrderQuestionTypeModal').on('hidden.bs.modal', function(e) {
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
        $("#ArrangeOrderDiv").html('');
        $("#arrange_attached_file_show").css("display", "none");
        $('.select2-selection__rendered li').remove();
        $('.clone_number:not(:first)').remove();
    })
    $('#UploadQuestionCSVmodal').on('hidden.bs.modal', function(e) {
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
        $("#questionCSV").css("display", "none");
        $('.select2-selection__rendered li').remove();
        $('#uploadquestions').show();
    })

    function getquestionDetail(id) {
        // alert(id);
        // return false;
        var path = APP_URL + "/parent/getquestionDetail";
        $.ajax({
            type: "POST",
            url: path,
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                var res = $.parseJSON(result);
                if (res.status == 'error') {

                } else {
                    var data = $.parseJSON(JSON.stringify(res.message));
                    var answer = $.parseJSON(JSON.stringify(res.answers));
                    var ansHtml = '';
                    var i = 0;
                    if (data.question_type == 1) {
                        $("#FillBlankTypeModal #fill_question_input").val(data.question_name);
                        $("#FillBlankTypeModal #fill_category_id").val(data.category_id);
                        var country = data.country_id;
                        $('#fill_country_id').val(country.split(','));
                        $('.js-example-basic-multiple').trigger('change');
                        $('#fill_question_id').val(data.id);
                     

                        var html_data = '';
                        if (data.file_attached == '' || data.file_attached == null) {
                            html_data = '';
                        } else {
                            var str = data.file_attached;
                            var file_ext = str.split(".");
                            if (file_ext[1] == 'mp3') {

                                var html_data = '<audio controls class="player" src="../storage/app/parent_questions/' + data.file_attached + '"></audio>';

                            } else if (file_ext[1] == 'mp4') {
                                html_data = '<video width="300" id="video" controls><source src="../storage/app/parent_questions/' + data.file_attached + '" type="video/mp4"></video>';
                            } else if (file_ext[1] == 'jpg' || file_ext[1] == 'png' || file_ext[1] == 'jpeg') {
                                html_data = '<img src="../storage/app/parent_questions/' + data.file_attached + '" width="100" height="100">';
                            }
                        }

                        $('#fill_attached_file_show').html('<div>' + html_data + '</div>');
                        $('#fill_attached_file_show').css('display', 'block');

                        $.each(answer, function(idx, values) {

                            ansHtml += '<div data-repeater-item="" class="row m--margin-bottom-10 clonedInputsForBlank" style=""><div class="col-lg-9"><div class="input-group"><input type="text" class="form-control form-control-danger ans_input" name="[' + i + '][fill_answer_input]" placeholder="Answer" id="" value="' + values.correct_options + '"></div></div><div class="col-lg-3"><a href="javascript:;" data-repeater-delete="" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only"><i class="la la-remove"></i></a></div></div>';

                            i++;
                        });
                        $("#FillBlankTypeModal #FillAnswerResponse").html(ansHtml);
                        $('#FillBlankTypeModal').modal('show');

                    } else if (data.question_type == 2) {
                        $("#MultiChoiceQuestionTypeModal #multi_question_input").val(data.question_name);
                        $("#MultiChoiceQuestionTypeModal #multi_category_id").val(data.category_id);
                        //                    $("#MultiChoiceQuestionTypeModal #multi_country_id").val(data.country_id);
                        $('#multi_question_id').val(data.id);

                        var country = data.country_id;
                        $('#multi_country_id').val(country.split(','));
                        $('.js-example-basic-multiple').trigger('change');
                        var html_data = '';
                        if (data.file_attached == '' || data.file_attached == null) {
                            html_data = '';
                        } else {
                            var str = data.file_attached;
                            var file_ext = str.split(".");

                            if (file_ext[1] == 'mp3') {

                                var html_data = '<audio controls class="player" src="../storage/app/parent_questions/' + data.file_attached + '"></audio>';

                            } else if (file_ext[1] == 'mp4') {
                                html_data = '<video width="300" id="video" controls><source src="../storage/app/parent_questions/' + data.file_attached + '" type="video/mp4"></video>';
                            } else if (file_ext[1] == 'jpg' || file_ext[1] == 'png' || file_ext[1] == 'jpeg') {
                                html_data = '<img src="../storage/app/parent_questions/' + data.file_attached + '" width="100" height="100">';
                            }
                        }
                        $('#multi_attached_file_show').html('<div>' + html_data + '</div>');
                        $('#multi_attached_file_show').css('display', 'block');
                        $.each(answer, function(idx, values) {
                            if (values.correct_options == 1) {
                                var checked = 'checked';
                                var chk_val = 1;
                            } else {
                                var checked = '';
                                var chk_val = 0;
                            }
                            ansHtml += '<div data-repeater-item="" class="form-group m-form__group row align-items-center clonedOptionsForMultiChoice" style=""><div class="col-md-9"><div class="input-group m-form__group"><span class="input-group-addon"><input type="checkbox" class="check_answer" value="' + chk_val + '" ' + checked + '></span><input type="text" class="form-control options_value" aria-label="Enter Option" value="' + values.options + '"></div><div class="d-md-none m--margin-bottom-10"></div></div><div class="col-md-3"><div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill"><span><i class="la la-trash-o"></i><span>Delete</span></span></div></div></div>';


                        });
                        $("#MultiChoiceQuestionTypeModal #MultiAnswerResponse").html(ansHtml);

                        $('#MultiChoiceQuestionTypeModal').modal('show');

                    } else {
                        $("#ArrangeOrderQuestionTypeModal #arrange_question_input").val(data.question_name);
                        $("#ArrangeOrderQuestionTypeModal #arrange_category_id").val(data.category_id);
                        // $("#ArrangeOrderQuestionTypeModal #arrange_country_id").val(data.country_id);
                        var country = data.country_id;
                        $('#arrange_country_id').val(country.split(','));
                        $('.js-example-basic-multiple').trigger('change');
                        $('#arrange_question_id').val(data.id);
                        var html_data = '';
                        if (data.file_attached == '' || data.file_attached == null) {
                            html_data = '';
                        } else {
                            var str = data.file_attached;
                            var file_ext = str.split(".");
                            if (file_ext[1] == 'mp3') {

                                var html_data = '<audio controls class="player" src="../storage/app/parent_questions/' + data.file_attached + '"></audio>';

                            } else if (file_ext[1] == 'mp4') {
                                html_data = '<video width="300" id="video" controls><source src="../storage/app/parent_questions/' + data.file_attached + '" type="video/mp4"></video>';
                            } else if (file_ext[1] == 'jpg' || file_ext[1] == 'png' || file_ext[1] == 'jpeg') {
                                html_data = '<img src="../storage/app/parent_questions/' + data.file_attached + '" width="100" height="100">';
                            }
                        }
                        $('#arrange_attached_file_show').html('<div>' + html_data + '</div>');
                        $('#arrange_attached_file_show').css('display', 'block');
                        var j = 1;
                        resultres = '';
                        $.each(answer, function(idx, values) {
                            ansHtml += '<div data-repeater-item="" class="m--margin-bottom-10 clone_number" id="clone' + j + '" style=""><div class="input-group"><span class="input-group-addon"><i class="la la-check"></i></span><input type="text" class="form-control form-control-danger incorrect_order" placeholder="Enter Question Part" value="' + values.options + '"><span class="input-group-btn" data-repeater-delete=""><a href="javascript:;" class="btn btn-danger m-btn m-btn--icon"><i class="la la-close"></i></a></span></div></div>';

                            resultres += '<li id="' + j + '">' + values.correct_options + '</li>';

                            j++;

                        });
                        $("#ArrangeOrderQuestionTypeModal #ArrangeOrderPartsDiv").html(ansHtml);
                        $("#ArrangeOrderQuestionTypeModal #ArrangeOrderDiv").html(resultres);


                        $('#ArrangeOrderQuestionTypeModal').modal('show');
                        $("#ArrangeOrderDiv").sortable({
                            stop: function(event, ui) {}
                        });

                    }

                    if (data.status == 0) {
                        $("#ArrangeOrderQuestionTypeBtn").css('display', 'none');
                        $("#FillBlankTypeBtn").css('display', 'none');
                        $("#MultiChoiceQuestionTypeBtn").css('display', 'none');
                    } else {
                        $("#ArrangeOrderQuestionTypeBtn").css('display', 'block');
                        $("#FillBlankTypeBtn").css('display', 'block');
                        $("#MultiChoiceQuestionTypeBtn").css('display', 'block');
                    }

                }


            },
            error: function() {
                alert("Error");
            }
        });
    }
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            placeholder: "Select Country"
        });
    });

    $('#upload_questions').click(function(e) {
        e.preventDefault();
        $('#category_id').val('');
        $('#questionCSV').val('');
        $('#UploadQuestionCSVmodal').modal('show');
    });

    /*$('#questionCSV').change(function(){
     uploadCsvFile.append('file', this.files[0]); // since this is your file input
     console.log(this.files[0]);
     });*/
    $('#uploadquestions').click(function() {
        $(this).hide();
        let questionCSV = $('#questionCSV').val();
        var category_id = $('#category_id').val();
        if (questionCSV == "") {
            swal("Error", "Browse CSV File", "error");
            //$('#addVoucherModal').modal('hide');
            return false;
        } else if (category_id == "") {
            swal("Error", "Please select Category", "error");
            //$('#addVoucherModal').modal('hide');
            return false;
        }
        var form = $('#csv_form')[0];
        var uploadCsvFile = new FormData(form);
        $.ajax({
            url: APP_URL + '/parent/question/bulkupload/' + category_id,
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            processData: false, // important
            contentType: false, // important
            data: uploadCsvFile,
            success: function(data) {
                if (data.status == 'error') {
                    swal('Error', data.error, 'error');
                    return false;
                }
                if (data.status == 'succes') {
                    $('#UploadQuestionCSVmodal').modal('hide');
                    $('#questionCSV').val('')
                    $("#ResponseSuccessModal").modal('show');
                    $("#ResponseSuccessModal #ResponseHeading").text(data.message);
                    $('#uploadquestions').show();
                    window.location.reload();
                }
            },
            error: function() {
                alert("An error occured, please try again.");
                $('#uploadquestions').show();
            }
        });
    });
</script>
<style>
    ul#ArrangeOrderDiv li {
        background: #8bc34a;
        padding: 10px 15px;
        margin: 3px;
        color: #fff;
        border-radius: 4px;
    }

    ul#ArrangeOrderDiv li {
        position: relative;
        left: -21px;
    }

    #ResponseHeading {
        color: #4CAF50;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
        color: #ffffff;
        background: #716aca;
        border: 1px solid #716aca;
        font-weight: normal;
        font-family: sans-serif, Arial;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice .select2-selection__choice__remove {
        color: #ffffff;
    }
</style>
@endsection