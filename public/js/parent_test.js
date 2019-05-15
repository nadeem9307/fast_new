

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the crurrent tab
var responseset = {};
var responses = [];


function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("tab");
    x[n].classList.add("display_block");
    x[n].classList.replace("display_none", "display_block");
    //... and fix the Previous/Next buttons:

    if (n == 0) {

        document.getElementById("prevBtn").classList.remove("display_block");
        document.getElementById("prevBtn").classList.remove("display_inline");
        document.getElementById("prevBtn").classList.add("display_none");
    } else {
        document.getElementById("prevBtn").classList.remove("display_block");
        document.getElementById("prevBtn").classList.remove("display_none");
        document.getElementById("prevBtn").classList.add("display_inline");
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit Test";
        
        // var anchor = document.getElementById("feedback_url"); 
        // var att = document.createAttribute("href");        
        // att.value = "https://www.quizme.com.my/#contact";            
        // anchor.setAttributeNode(att);       
        var width = (1 / x.length * 100);
        $('.progress-bar').css('width', width * n + "%");
        $('.progress-tick').html(Math.round(width * n) + '%');
        $('.progress-tick').css('left', width * n + "%");               
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
        var width = (1 / x.length * 100);
        $('.progress-bar').css('width', width * n + "%");
        $('.progress-tick').html(Math.round(width * n)+'%');
        $('.progress-tick').css('left', width * n + "%");
    }
    //... and run a function that will display the correct step indicator:
}

function nextPrev(n) {

    var question_id = {};
    var answers = {};
    // {'questionId':'12','answere':{'option':{'1','2','3'}}}
    if (n == -1) {
        responseset.pop();
        var tab_name = $('.display_block').attr('id');
        var tab_id = tab_name.split('_');
        if (tab_id[1] == 1){
            return false;
        }
    } else {

        var tab_name = $('.display_block').attr('id');
        var tab_id = tab_name.split('_');

        var tab_sid = tab_id[1];
//        question_id.push($("#" + tab_name + " #question_id_" + tab_sid).val());
        var question_type = $("#" + tab_name + " #question_type_" + tab_sid).val();
        var auth_id = $("#auth_id").val();
        var answer_arr = [];
        if (auth_id == '') {
            swal("Error", "Some Error Occured", "error");
        } else {
            /*-========Question type Fill Blanks==========*/
            if (question_type == 1) {
//question_id.push(answers);

                if ($("#" + tab_name).find("#AnswersDiv" + tab_sid + "  #answer" + tab_sid).val() == '') {
                    swal("Error", "Fill all input boxes", "error");
                    return false;
                } else {

                    var inputanswer = $("#" + tab_name).find("#AnswersDiv" + tab_sid + "  #answer" + tab_sid).val();
                    answers = inputanswer;
                    question_id.questionId = $("#" + tab_name + " #question_id_" + tab_sid).val();
                }

                /*-========End Question type Fill Blanks==========*/

                /*-========Question type Multi Choice==========*/
            } else if (question_type == 2) {

                var i = 1;
                var j = 0;
                $("#" + tab_name).find(".quesDiv" + tab_sid + " li ").each(function () {

                    if ($(this).find('input[type="checkbox"]').val() === '1') {
//                        console.log($(this).find('input[type="checkbox"]').val());
//                        var inputanswer = $('.multi_' + i).data('option');
//                        answer_arr[j++] = $("#" + tab_name + " .multi_" + i).data('option' + i);
                        answer_arr[j++] = $(this).find('input[type="checkbox"]').data('option' + i);
                    } else {

                    }

                    i++;
                });
                if (answer_arr != '') {
                    answers = answer_arr;
                    question_id.questionId = $("#" + tab_name + " #question_id_" + tab_sid).val();
                } else {
                    swal("Error", "Please select atleast one option", "error");
                    return false;
                }
                //answer_arr[question_id][tab_sid] = inputanswer;
                //answer_arr.push(answer_arr);

//                });
//                if ($("#" + tab_name).find(".quesDiv li val").length != answer_arr.length) {
//                    swal("Error", "Fill all input boxes", "error");
//                }

                /*-========End : Question type Multi Choice==========*/

                /*-========Question type Multi Choice==========*/
            } else if (question_type == 3) {
                var i = 0;
                $("#" + tab_name).find(".sort_order li").each(function () {
                    var inputanswer = $(this).text();
                    answer_arr[i++] = $.trim(inputanswer);
                });
                answers = answer_arr;
                //answer_arr.push(answer_arr);
                question_id.questionId = $("#" + tab_name + " #question_id_" + tab_sid).val();
            }

            /*-========End : Question type Multi Choice==========*/


            question_id.given_answer = answers;
            responses.push(question_id);
            responseset = responses;
            question_id = {};
            answers = {};
        }
    }
//    console.log(responses);
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    //if (n == 1 && !validateForm()) return false;
    // Hide the current tab:

    x[currentTab].classList.remove("display_block");
    x[currentTab].classList.remove("display_inline");
    x[currentTab].classList.add("display_none");
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
    if (currentTab >= x.length) {
        $('.btn-retake').hide();
        $("#test_submit_btn").css('display', 'none'); 
        $("#animation_stop").css('display', 'block'); 
        var test_duration = $("#timershow").html();
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: APP_URL + '/parent/test/calculate_score',
                data: {
                    quiz_duration: test_duration,
                    auth_id: auth_id,
                    responses: responseset,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var res = $.parseJSON(data);
                    if (res.status == 'success') {
                        $('#timershow').hide();
                        window.location.href = APP_URL + "/result?correct_ans=" + res.correct_answer + '/' + res.total_questions + '&score=' + res.score;

                    } else {
                        //return false;
                        //window.location.href = APP_URL + "/parent/overview";
                    }
                },
                error: function (data) {
                        //return false;
                    //window.location.href = APP_URL + "/parent/overview";
                }
            });
        }, 500);
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
}

var miliseconds = 0, seconds = 0, minutes = 0, hours = 0, t;
function add() {
    miliseconds++;
    if (miliseconds >= 100) {
        miliseconds = 0;
        seconds++;
        if (seconds >= 60) {
            seconds = 0;
            minutes++;
            if (minutes >= 60) {
                minutes = 0;
                hours++;
            }
        }
    }

    $('#timershow').text((hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds) + "." + (miliseconds > 9 ? miliseconds : "0" + miliseconds));
    timer();
}
function timer() {
    t = setTimeout(add, 10);
}
$(document).ready(function () {
    timer();
});






/*====disable f5=========*/
window.onload = function () {
    document.onkeydown = function (e) {
        return (e.which || e.keyCode) != 116;
    };
}


function showKeyCode(e) {
    // debugger;
    var keycode;
    if (window.event)
        keycode = window.event.keyCode;
    else if (e)
        keycode = e.which;
    // Mozilla firefox
    if ($.browser.mozilla) {
        if (keycode == 116 || (e.ctrlKey && keycode == 82)) {
            if (e.preventDefault) {
                e.preventDefault();
                e.stopPropagation();
            }
        }
    }
    // IE
    else if ($.browser.msie) {
        if (keycode == 116 || (window.event.ctrlKey && keycode == 82)) {
            window.event.returnValue = false;
            window.event.keyCode = 0;
            window.status = "Refresh is disabled";
        }
    } else {
        switch (e.keyCode) {

            case 116: // 'F5'
                event.returnValue = false;
                event.keyCode = 0;
                window.status = "Refresh is disabled";
                break;
        }
    }
}

/*===========disable back button===========*/
$(document).ready(function () {
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, "", window.location.href);
    };
});

/*======submit on quit =============*/
$("#GoHome").on('click', function () {
    submitQuiz();
})
