@extends('layouts.admin')

@section('page_title') 
System Settings
@endsection 

@section('page_css')
@endsection
@section('content')
<div class="m-subheader "> 
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
               Settings
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
                    <a class="m-nav__link">
                        <span class="m-nav__link-text">
                           Setting
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div>
 
    </div>
</div>

<div class="m-content">
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="false">
                        <i class="la la-cog"></i>
                        Test Limit Settings
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab" aria-selected="false">
                        <i class="la la-briefcase"></i>
                        Test Questions Settings
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="m-portlet__body col-sm-6">
        <form class="m-form m-form--fit m-form--label-align-right" id="setting_form" enctype="multipart/form-data">
            <div class="tab-content">
                
                <input type="hidden" name="id" value="{{$setting['id']}}">
                <div class="tab-pane active show" id="m_tabs_6_1" role="tabpanel">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group">
                            <label for="number_of_time">
                                Retake Test Limit 
                            </label>
                            @if(isset($default_setting['retake_test_limit']))
                            <input type="text" class="form-control m-input m-input--square number" name="number_of_time" id="number_of_time" aria-describedby="" placeholder="Set limit of test attempt" value="{{$default_setting['retake_test_limit']}}">
                            @else
                              <input type="text" class="form-control m-input m-input--square number" name="number_of_time" id="number_of_time" aria-describedby="" placeholder="Set limit of test attempt" value="">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group">
                            <label for="number_of_question">
                                Per Category Question
                            </label>
                            @if(isset($default_setting['category_wise_question_limit']))
                            <input type="text" class="form-control m-input m-input--square number" name="number_of_question" id="number_of_question" aria-describedby="" placeholder="Enter Number of question in a set" value="{{$default_setting['category_wise_question_limit']}}">
                            @else
                             <input type="text" class="form-control m-input m-input--square number" name="number_of_question" id="number_of_question" aria-describedby="" placeholder="Enter Number of question in a set" value="">
                            @endif
                        </div>

                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <button type="button" class="btn  btn-accent" id="test_limit">
                            Save
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </form>	
    </div>
</div>
    </div>
@endsection
@section('page_script')
<script>
    $('#test_limit').on('click', function () {
        var number_of_time = $('#number_of_time').val();
        var question_limit = $('#number_of_question').val();
        if(number_of_time=='' || number_of_time =='0')
        {
            swal('Error','Please enter test limit value greater than 0','error');
            return false;
        }
        else if(question_limit=='' || question_limit =='0')
        {
            swal('Error','Please enter question limit value greater than 0','error');
            return false;
        }
        var form = $('#setting_form')[0];
        var data = new FormData(form);
        var path = "settings_test";
        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url: path,
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

                    $('.sweet-overlay').remove();
                    $('.showSweetAlert ').remove();
                    swal('Success', 'Setting saved successfully.', 'success');
                    setTimeout(function () {
                        //location.reload();
                    }, 2000);
                }
            },
            error: function (data) {
                swal('Error', data, 'error');
            }
        });
    });
</script>
@endsection