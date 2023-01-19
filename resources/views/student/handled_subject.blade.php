@extends('layouts.subjects')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2"><strong>{{ $subject->subj_desc}}</strong></h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    
    
    <div class="btn-group me-2">
      <select class="form-select js-data-example-ajax" id="quarter" aria-label="Default select example">
          <option value="Q1">First Grading</option>
          <option value="Q2">Second Grading</option>
          <option value="Q3">Third Grading</option>
          <option value="Q4">Fourth Grading</option>
        </select>
  </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
    </button>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-sm-12">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="lessons-tab" data-bs-toggle="tab" data-bs-target="#lessons" type="button" role="tab" aria-controls="lessons" aria-selected="true">Lesson</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="subjects-tab" data-bs-toggle="tab" data-bs-target="#subjects" type="button" role="tab" aria-controls="subjects" aria-selected="true">Quiz</button>
      </li>
    </ul>

    <div class="tab-content" id="SubjectTabContent">
      <div class="tab-pane fade show active pt-10" id="lessons" role="tabpanel" aria-labelledby="lessons-tab" style="padding-top: 20px;">
        <div class="row">
            <div class="col-6 pe-3">
              <table id ="studentLesson"  class="table table-striped" style="width:100%;box-shadow: #4c4c4c 0px 4px 12px">
                <thead>
                  <tr>
                      <th>Lessons</th>
                  </tr>
                </thead>
                <tbody>
                 
                </tbody>
              </table>
            </div>
            <div class="col-6">
              <div class="card mt-6" style="margin-top:6px;box-shadow: #4c4c4c 0px 4px 12px">
                <div class="card-header " style="background-color: #516a8a; color:white">
                  Details
                </div>
                <div class="card-body">
                  {{-- <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                </div>
              </div>
            </div>
        </div>
        
      </div>
      <div class="tab-pane fade" id="subjects" role="tabpanel" aria-labelledby="subjects-tab">
        <div class="row">
          <div class="col-lg-6 col-sm-12 pe-3">
            <table id ="quizTable"  class="table table-striped" style="width:100%;box-shadow: #4c4c4c 0px 4px 12px">
              <thead>
                <tr>
                    <th>Quiz</th>
                </tr>
              </thead>
              <tbody>
               
              </tbody>
            </table>
          </div>
          <div class="col-lg-6 col-sm-12">
            <div class="card mt-6" style="margin-top:6px;box-shadow: #4c4c4c 0px 4px 12px">
              <div class="card-header " style="background-color: #516a8a; color:white;">
                Details
              </div>
              <div class="card-body">
                <div class="row ">
                  <div class="col-12 text-center" id="chart">
                    
                  </div>
                </div>
                
              </div>
            </div>
          </div>
      </div>
    </div>

  </div>
</div>

{{-- Modals --}}

  <div class="modal fade" id="updateSectionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Section</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateSectionForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="sectionName" class="form-label">Section Name</label>
            <input type="text" class="form-control" id="updateSectionName" required data-code="">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="grade" class="form-label">Select Grade</label>
            <select type="text" class="form-control" id="updateGradeCode" required>
              <option value="G1">Grade 1</option>
              <option value="G2">Grade 2</option>
              <option value="G3">Grade 3</option>
              <option value="G4">Grade 4</option>
              <option value="G5">Grade 5</option>
              <option value="G6">Grade 6</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="updateTeacher" class="form-label">Select Teacher</label>
            <select class="js-example-responsive form-control" id="updateTeacher">
            </select>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>



  <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addSectionForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="sectionName" class="form-label">Section Name</label>
            <input type="text" class="form-control" id="sectionName" required >
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="grade" class="form-label">Select Grade</label>
            <select type="text" class="form-control" id="gradeCode" required>
              <option value="G1">Grade 1</option>
              <option value="G2">Grade 2</option>
              <option value="G3">Grade 3</option>
              <option value="G4">Grade 4</option>
              <option value="G5">Grade 5</option>
              <option value="G6">Grade 6</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="teacher" class="form-label">Select Teacher</label>
            <select class="js-example-responsive form-control" id="teacher">
            </select>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

{{-- Add Lesson  --}}

  <div class="modal fade" id="addLessonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Lesson</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addLessonForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="lesson" class="form-label">Lesson</label>
            <input type="text" class="form-control" id="lesson" name="lesson" required >
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <div class="input-group">
              <input type="file" class="form-control" id="lesson_file" name="lesson_file" aria-describedby="upload-lesson" aria-label="Upload">
              <button class="btn btn-outline-secondary" type="button" id="upload_lesson">Upload Lesson</button>
            </div>
          </div>
          <div class="mb-3">
            <label for="grade" class="form-label">Select Subject</label>
            <select type="text" class="form-control" id="selectSubject" name="selectSubject" >
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>

{{-- Subjec Section Modal --}}
  <div class="modal fade bd-example " id="uploadQuizModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload Quiz</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="uploadQuizForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="grade" class="form-label">Select if Activity</label>
            <select type="text" class="form-control" id="quizType" name="quizType" >
              <option  value="quiz">Quiz</option>
              <option value="activity">Activity</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="lesson" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" readonly>
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <div class="input-group">
              <input type="file" class="form-control" id="quiz_file" name="quiz_file" aria-describedby="upload-quiz" aria-label="upload">
              
            </div>
          </div>
          <div class="mb-3">
            <label for="grade" class="form-label">Select Quiz Type</label>
            <select type="text" class="form-control" id="quizType" name="quizType" >
              <option value="multiple">Multiple Choice</option>
              <option value="identification">Identification</option>
              <option value="enumeration">Enumeration</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="endDateInput" class="form-label">End Date</label>
            <div class="input-group log-event" id="endDate" data-td-target-input="nearest" data-td-target-toggle="nearest">
              <input id="endDateInput" name="endDate" type="text" class="form-control" data-td-target="#endDate" readonly>
              <span class="input-group-text" data-td-target="#endDate" data-td-toggle="datetimepicker">
                <i class="fas fa-calendar"></i>
              </span>
            </div>
            {{-- <label for="lesson" class="form-label">Select End Date</label>
            <input type="text" class="form-control" id="endDate" name="subject" readonly> --}}
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<script>

  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};

  $(document).ready(function(){

   
   var subjectCode={{ Js::from($subjectCode) }};
   var sectionCode={{ Js::from($sectionCode) }};
   console.log(subjectCode);
   var studentLesson= $('#studentLesson').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "ordering":false,
      "searching": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/lesson/get/"+subjectCode+"/"+sectionCode,
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
           
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
              "gradeCode":$("#grades").val()
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"lesson",
          "render":function(data, type, row, meta ){
            console.log(row);
                  var html ='<div class=""> <i class="fa-solid fa-file"></i> '+data;
                  var lesson ='<div class="float-end"><button class="btn btn-success btn-sm download-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Lesson"><i class="fa-solid fa-download"></i></button> ';
                  var quiz ='<button class="btn btn-warning btn-sm quiz-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Lesson"><i class="fa-solid fa-eye"></i></button> ';
                  var exam ='<button class="btn btn-info btn-sm exam-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="See Lesson Details"><i class="fa-solid fa-list-check"></i></button> </div>';
                  return html+lesson+quiz+exam+'</div>';
          }
        }
      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

    var quizTable= $('#quizTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "ordering":false,
      "searching": false,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/quiz/get/"+sectionCode+"/"+subjectCode,
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"assesment_desc",
          "render":function(data, type, row, meta ){
            console.log(row);
            var disabled="";
            var status='';
            var takingStatus='';
            if(row.isTaken){
               disabled ="disabled";
               takingStatus='<span class="badge text-bg-success">DONE</span>';
            }else{
               takingStatus='<span class="badge text-bg-warning">Ready to Take</span>';

            }

            if(row.status="ACTIVE")
              status ='<span class="badge text-bg-primary">'+row.status+'</span> ';
            else
              status ='<span class="badge text-bg-danger">'+row.status+'</span> ';

            

                  var html ='<div class="row"><div class="col-9"><i class="fa-solid fa-pencil"></i> '+data+' '+status+takingStatus+' <div style="font-size:9px;margin-left:10px;"><strong>Created Date:</strong> '+moment(row.created_at).format('MMM-DD-YYYY h:mm A')+' <strong>End Date:</strong> '+moment(row.updated_at).format('MMM-DD-YYYY h:mm A')+'</div></div><div class="col-3 text-end">';
                  var take ='<button '+disabled+' class="btn btn-success btn-sm take-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take the Quiz"><i class="fa-solid fa-square-pen"></i></button> ';
                  var quiz ='<button class="btn btn-warning btn-sm quiz-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Lesson"><i class="fa-solid fa-eye"></i></button> ';
                  var exam ='<button class="btn btn-info btn-sm view-quiz" data-bs-toggle="tooltip" data-bs-placement="top" title="View Quiz Details"><i class="fa-solid fa-list-check"></i></button> </div>';
                  return html+take+quiz+exam+'</div>';
          }
        }
      ],
      "columnDefs":[
       

      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

    // $("#quarter").select2({
    //   theme: 'bootstrap-5',
    //   placeholder: 'Select Quarter Period',
    //   closeOnSelect:true
    // });
    // $('#quarter').on('select2:opening select2:closing', function( event ) {
    //     var $searchfield = $(this).parent().find('select2-search__field');
    //     $searchfield.css('display', 'none');
    //   });
    
    

    const picker= new datetimepicker(document.getElementById('endDate'));
    picker.dates.formatInput = date => moment(date).format('YYYY-MM-DD hh:mm A');

   
    $('#quizTable tbody').on('click', '.take-btn', function(){
      var data = quizTable.row($(this).parents('tr')).data();
     
      swal.fire({
        icon:'warning',
        title: 'Are you ready to take this quiz?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        if (result.isConfirmed) {
          swal.close();
        window.location.href = "/assesment/multiple?assesmentId="+data.assesment_id;
        }
      });
    });

    $('#quizTable tbody').on('click', '.view-quiz', function(){
      var data = quizTable.row($(this).parents('tr')).data();

      var options = {
      chart: {
        type: 'donut'
      },
      series: [11, 4],
      labels: ['Correct Answer','Wrong Answer'],
      colors:['#198754', '#dc3545'],
      plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              name: {
                
              },
              value: {
                
              },
              total:{
                show:true,
                showAlways:true,
                label:"Total Score",
              }
            }
          }
        }
      }
    }

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
     
    });

    $('#sectionsTable tbody').on( 'click', 'tr', function () {   
      console.log($(this).hasClass('selected'));         
        if ( $(this).hasClass('selected') ) { 
            $(this).removeClass('selected'); 
        } 
        else {                 
          sectionTable.$('tr.selected').removeClass('selected'); 
            console.log($(this).text());
            $(this).addClass('selected');                
        }  

      });

    $("#addLessonBtn").click(()=>{
      $("#addLessonModal").modal("show");
    });
    
    $("#updateSectionBtn").click(()=>{
      var data = sectionTable.row( ".selected" ).data();
      console.log(data);
      $("#updateSectionName").data("code",data.s_code);
      $("#updateSectionName").val(data.s_desc);
      $("#updateGradeCode").val(data.g_code);
      $("#updateTeacher").val(data.teacher_id);

      $("#updateSectionModal").modal("show");
    });

    $("#addLessonForm").submit((e)=>{
      e.preventDefault();
      var selectedSubject =$("#selectSubject").select2('data')[0];
      console.log(selectedSubject);
      var form = $("#addLessonForm");

      var formData = new FormData(form[0]);
      formData.append("subj_code", selectedSubject.id);
      formData.append("section_code", sectionCode);

      swal.fire({
        title: 'Do you want to save the Lesson?',
        showCancelButton: true,
        confirmButtonText: 'Save'
      }).then((result) => {
       
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/lesson/create",
            type:"POST",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data:formData,
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire('Saved!', '', 'success');
                swal.close();
                $("#addLessonModal").modal("hide");
                teacherLessonsTable.ajax.reload();
              }

            },
            error: function (xhr, ajaxOptions, thrownError) {
              console.log(xhr);
              alert(xhr.status);
              alert(thrownError);
            },
            beforeSend: function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
          })
         
        } else {
          swal.fire('Changes are not saved', '', 'info')
        }
      })

    });



    $("#uploadQuizForm").submit((e)=>{
      e.preventDefault();
      var subjCode =$("#subject").data("subjectCode");
      var form = $("#uploadQuizForm");
      var formData = new FormData(form[0]);
      formData.append("subj_code", subjCode);
      formData.append("section_code", sectionCode);

      swal.fire({
        title: 'You are uploading new Quiz?',
        showCancelButton: true,
        confirmButtonText: 'Upload',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url:baseUrl+"/api/teacher/upload/quiz",
            type:"POST",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data:formData,
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire({
                  icon:'success',
                  title: 'Upload Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                $("#uploadQuizModal").modal("hide");
                });
                
              }

            },
            error: function (xhr, ajaxOptions, thrownError) {
              console.log(xhr);
              alert(xhr.status);
              alert(thrownError);
            },
            beforeSend: function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
          })
        
        } else {
          swal.fire('Changes are not saved', '', 'info')
        }
      })
  });

    

});
</script>
@endsection
