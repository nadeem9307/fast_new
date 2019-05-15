//== Class definition
var QuestionFormsRepeater = function() {

    //== Private functions
    var MultiChoiceOption = function() {
        $('#MultiChoiceOptionDiv').repeater({            
            initEmpty: false,
           
            defaultValues: {
                'text-input': 'foo'
            },
           
            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                if($(".clonedOptionsForMultiChoice").length==1){
                  swal('Warning','Atleast one option is compulsory','warning');
                }else{
                  $(this).slideUp(deleteElement);  
                }              
                               
            }   
        });
    }



    var ArrangeOrder = function() {
       

        $('#ArrangeOrderParts').repeater({            
            initEmpty: false,
           
            defaultValues: {
                'text-input': 'foo'
            },
             
            show: function() {
                 $("#ArrangeOrderQuestionTypeModal #ArrangeOrderDiv").html('');
                var divcounter=1;
                 $("#ArrangeOrderPartsDiv .clone_number").each(function(){
                    $(this).attr('id','clone'+divcounter);
                    divcounter++;
                   });
                $(this).slideDown(); 
                       
            },

            hide: function(deleteElement) {
                
                if($('.clone_number').length==1){
                  swal('Warning','Atleast one part of question is compulsory','warning');
                }else{
                  $(this).remove();
                   var divcounters=1;
                   $("#ArrangeOrderPartsDiv .clone_number").each(function(){
                    $(this).attr('id','clone'+divcounters);
                    divcounters++;
                   });

                   var list_number = 1;
                   $("#ArrangeOrderQuestionTypeModal #ArrangeOrderDiv").html('');
                  $("#ArrangeOrderPartsDiv .clone_number").each(function(){
                    var order_text = $(this).find('input').val();
                    var OrderList = "<li id="+list_number+">"+order_text+"</li>";
                    $("#ArrangeOrderQuestionTypeModal #ArrangeOrderDiv").append(OrderList);
                    list_number++;
                   }); 

                   $("#ArrangeOrderDiv").sortable({
                    stop : function(event, ui){
                     }
                   });

                }                               
            }      
        });
        
    }


    var FillInTheBlanks = function() {
        $('#FillInTheBlanksAnswers').repeater({            
            initEmpty: false,
           
            defaultValues: {
                'text-input': 'foo'
            },
             
            show: function() {
                $(this).slideDown();                               
            },

            hide: function(deleteElement) { 
                if($(".clonedInputsForBlank").length==1){
                  swal('Warning','Atleast one answer is compulsory','warning');
                }else{
                  $(this).slideUp(deleteElement);
                }                
                                                
            }      
        });
    }

    return {
        // public functions
        init: function() {
            MultiChoiceOption();
            FillInTheBlanks();
            ArrangeOrder();
        }
    };
}();

jQuery(document).ready(function() {
    QuestionFormsRepeater.init();
});

    