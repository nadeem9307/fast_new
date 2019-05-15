$(document).ready(function() {
    var datatable;
    var tasksdata;
      datatable = $('.tasks_datatable').mDatatable({
        // datasource definition
      data: {
      type: 'remote',
      source: {
          read: {
              url: 'getAllQuestions',
              method: 'GET',
              // custom headers
              headers: { 'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
              params: {
                  // custom query params
                  query: {
                      generalSearch: '',
                      category_id: '',
                      country_id: ''
                  }
              },
              map: function(raw) {
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

    // search: {
    //   input: $('#generalSearch')
    // },

    // inline and bactch editing(cooming soon)
    // editable: false,

    // columns definition
    columns: [
    /*{
      field: "id",
      title: "#",
      width: 50,
      selector: {class: 'm-checkbox--solid m-checkbox--brand'}
    },*/
    {
      field: "S_No",
      title: "S.No",
      textAlign: 'center',
      width: 40
    },
    {
      field: "category_name",
      title: "Category Name",
        width: 90
    },
    {
      field: "question_name",
      title: "Question"      
    },
    {
      field: "country_name",
      title: "Country Name"      
    },
    {
      field: "file_attached",
      title: "Attached File",
      width:100,
      template: function (row) {
        if(row.file_attached=='' || row.file_attached==null)
        {
            return '\
            <div></div>\
            '; 
        }
        var str = row.file_attached;
        var base_url = window.location.hostname;
        var host = window.location.pathname.split('/');
        var file_ext = str.split(".");
        if(file_ext[1]=='mp3')
        {
            return '\
            <div><audio controls class="player" src="../storage/app/parent_questions/'+row.file_attached+'"></audio></div>\
            ';
        }
        else if(file_ext[1]=='mp4')
        {
            return '\
            <div><video width="100" id="video">\
              <source src="../storage/app/parent_questions/'+row.file_attached+'" type="video/mp4">\
            </video></div>\
                        ';
        }
        else if(file_ext[1]=='jpg' || file_ext[1]=='png' || file_ext[1]=='jpeg')
        {
          return '\
          <div><img src="../storage/app/parent_questions/'+row.file_attached+'" width="100" height="100"></div>\
          ';
        }
        else
        {
           return '\
          <div></div>\
          '; 
        }
        
      }
    },
    {
      field: "question_type",
      title: "Type",
      template: function (row) {
        if(row.question_type=='1')
        {
            return '\
            <div>Fill In the blanks</div>\
            ';
        }
        else if(row.question_type=='2')
        {
            return '\
            <div>Multiple Choice</div>\
            ';
        }
        else
        {
          return '\
          <div>Arrange Order</div>\
          ';
        }
        
      }     
    },
    {
      field: 'Actions',
      width: 110,
      title: 'Actions',
      sortable: false,
      overflow: 'visible',
      template: function(row) {
//      var dropup = (row.getDatatable().getPageSize() - row.getIndex()) <= 4 ? 'dropup' : '';
 
        return '\
        <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete Question" onclick=deleteQuestion('+row.id+')>\
          <i class="la la-trash"></i>\
        </a>\
        \
        <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Edit Question" onclick=getquestionDetail('+row.id+')>\
          <i class="la la-eye"></i>\
        </a>\
      '; 
      },
    }]
    });
    $('#categorylist').on('change',function(){
      var value = $(this).val();
      var coutid = $('#countrylist').val();
      datatable.setDataSourceQuery({category_id:value,country_id:coutid});
      datatable.reload();
    });
    $('#countrylist').on('change',function(){
      var value = $(this).val();
      var catid = $('#categorylist').val();
      datatable.setDataSourceQuery({country_id:value,category_id:catid});
      datatable.reload();
    });
   ;
    $('#LoadTaskDatatable').on('click',function(){
      datatable.reload();
    });
    $('.tasks_datatable').on('m-datatable--on-check', function (e, args) 
    {
      var count = datatable.getSelectedRecords().length;
      tasksdata = $.map(datatable.getSelectedRecords(), function (item) {
      return $(item).find("td").eq(0).find("input").val();
      });
      $('#m_datatable_selected_number').html(count);
      if (count > 0) {
        $('#addPoints').show();
      }
    })
    .on('m-datatable--on-uncheck m-datatable--on-layout-updated', function (e, args) {
        var count = datatable.getSelectedRecords().length;
        $('#m_datatable_selected_number').html(count);
        if (count === 0) {
          $('#addPoints').hide();
        }
    });
    $('#addPointBtn').on('click', function(){
      var path = "tasks/add_points";
      var points = $('#task_point').val();
      if(points == '')
      {
        swal('Error','Points Value Required','error');
        return false;
      }
      //alert(path);
      var task_id = JSON.parse(JSON.stringify(tasksdata));
      $.ajax({
      type: 'GET',
      url: path,
      data: {
        task_id : task_id,
        points : points
      },
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
      success: function(data) {
        var res = $.parseJSON(data);
        if(res.status == 'error'){
          swal('Error',res.message,'error');
          $('#task_point').val('')
          $('#AddPointsModal').modal('toggle');
        }else{
           swal('Success',res.message,'success');
           $('#task_point').val('')
           $('#AddPointsModal').modal('toggle');
           datatable.reload();
        } 
      },
      error: function(data) {
        swal('Error',data,'error');
        return false;
      }
    });
    })
    
});
$("#fill_task_points,#arrange_task_points,#multi_task_points,#fill_attempt_1,#fill_attempt_2,#fill_attempt_3,#fill_attempt_above").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

function deleteQuestion(id)
{
  var path = "task_delete";
    var _this = $(this);
    swal({
      title: "Are you sure to delete this Question?",
      text: "Your will lost all records of this Question",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    },
    function(isConfirm) {
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
          success: function(data) {
            var res = $.parseJSON(data);
            if(res.status == 'error'){
              swal('Error',res.message,'error');
            }else{
               swal.close();
                $("#ResponseSuccessModal").modal('show');
                $("#ResponseSuccessModal #ResponseHeading").text(res.message);
            } 
          },
          error: function(data) {
            swal('Error',data,'error');
          }
        });
      } else {

      }
    });
}
