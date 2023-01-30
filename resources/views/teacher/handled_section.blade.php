@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">{{ $sections->s_desc}} - {{ $sections->g_code}}</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
    </button>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-sm-12">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab" aria-controls="students" aria-selected="true">Students</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="subjects-tab" data-bs-toggle="tab" data-bs-target="#subjects" type="button" role="tab" aria-controls="subjects" aria-selected="true">Subjects</button>
      </li>
    </ul>

    <div class="tab-content" id="SectionTabContent">
      <div class="tab-pane fade show active" id="students" role="tabpanel" aria-labelledby="students-tab">
        <table id ="teacherStudentsTable"  class="table table-striped" style="width:100%">
          <thead>
            <tr>
                <th>Student Name</th>
                <th>Status</th>
                <th>Quizes</th>
                <th>Activities</th>
                <th>Exams</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="subjects" role="tabpanel" aria-labelledby="subjects-tab">
        <table id ="sectionSubjects"  class="table table-striped" style="width:100%">
          <thead>
            <tr>
                <th>SubjectCode</th>
                <th>Subject</th>
                <th></th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table> 
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
            <label for="lesson" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" readonly>
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="lesson" class="form-label">Lesson</label>
            <input type="text" class="form-control" id="lesson" name="lesson" required >
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <div class="input-group">
              <input type="file" class="form-control" id="lesson_file" name="lesson_file" aria-describedby="upload-lesson" aria-label="Upload">
              <button class="btn btn-outline-secondary" type="button" id="upload_lesson" disabled>Upload Lesson</button>
            </div>
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
            <select type="text" class="form-control" id="assessmentType" name="assessmentType" >
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
            <label for="lesson" class="form-label">Quiz Description</label>
            <input type="text" class="form-control" id="quizDesc" name="quizDesc" required>
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <div class="input-group">
              <input type="file" class="form-control" id="quiz_file" name="quiz_file" aria-describedby="upload-quiz" aria-label="upload" required>
              
            </div>
          </div>
          <div class="mb-3">
            <label for="lesson" class="form-label">Total Points</label>
            <input type="number" class="form-control" id="totalPoints" name="totalPoints" required>
          </div>
          <div class="mb-3">
            <label for="grade" class="form-label">Select Quiz Type</label>
            <select type="text" class="form-control" id="quizType" name="quizType" >
              <option value="multiple">Multiple Choice</option>
              <option value="identify">Identification</option>
              <option value="enumerate">Enumeration</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label for="endDateInput" class="form-label">End Date</label>
            <div class="input-group log-event" id="endDate" data-td-target-input="nearest" data-td-target-toggle="nearest">
              <input id="endDateInput" name="endDate" type="text" class="form-control" data-td-target="#endDate" readonly required>
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


  <div class="modal fade bd-example " id="uploadExamModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload Exam</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="uploadExamForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="lesson" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" readonly>
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="lesson" class="form-label">Exam Description</label>
            <input type="text" class="form-control" id="examDesc" name="examDesc" required>
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <div class="input-group">
              <input type="file" class="form-control" id="exam_file" name="exam_file" aria-describedby="upload-exam" aria-label="upload" required>
              
            </div>
          </div>
          <div class="mb-3">
            <label for="lesson" class="form-label">Total Points</label>
            <input type="number" class="form-control" id="totalPoints" name="totalPoints" required>
          </div>
          {{-- <div class="mb-3">
            <label for="grade" class="form-label">Select Quiz Type</label>
            <select type="text" class="form-control" id="quizType" name="quizType" >
              <option value="multiple">Multiple Choice</option>
              <option value="identify">Identification</option>
              <option value="enumeration">Enumeration</option>
            </select>
          </div> --}}
          
          <div class="mb-3">
            <label for="endDateInput" class="form-label">End Date</label>
            <div class="input-group log-event" id="exam_endDate" data-td-target-input="nearest" data-td-target-toggle="nearest">
              <input id="endDateInput" name="endDate" type="text" class="form-control" data-td-target="#exam_endDate" readonly required>
              <span class="input-group-text" data-td-target="#exam_endDate" data-td-toggle="datetimepicker">
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
   var sectionCode={{ Js::from($sectionCode) }};
   console.log(sectionCode);
   var teacherStudentsTable= $('#teacherStudentsTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/student/get/"+sectionCode,
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
        { "data":"id_number",
          "render":function(data, type, row, meta ){
            console.log(row);
            return row.first_name+" "+row.last_name;
          }
        },
        { "data":"id_number"},
        { "data":"id_number" },
        { "data":"id_number" },
        {
          "data":"status",
          "render": function ( data, type, row, meta ) {
              return '<button class="btn btn-success btn-sm section-subjects" data-bs-toggle="tooltip" data-bs-placement="top" title="Section Subjects"><i class="fa-solid fa-folder"></i></button>';
            }
         }
      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

    var sectionSubjects= $('#sectionSubjects').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/teacher/section/subjects",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
              "sectionCode":sectionCode
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"subj_code"},
        { "data":"subj_desc"},
        {
          "data":"status",
          "render": function ( data, type, row, meta ) {
                  var lesson ='<button class="btn btn-success btn-sm lesson-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="upload Lesson"><i class="fa-solid fa-chalkboard-user"></i></button> ';
                  var quiz ='<button class="btn btn-warning btn-sm quiz-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="upload Quiz"><i class="fa-solid fa-lightbulb"></i></button> ';
                  var exam ='<button class="btn btn-danger btn-sm exam-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="upload Exam"><i class="fa-solid fa-list-check"></i></button> ';
              return lesson+quiz+exam;
            }
         }
      ],
      "columnDefs":[
        {"target":0,"width":"25%"},
        {"target":1,"width":"50%"}

      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

    
    $("#teacher").select2({
      dropdownParent: $('#addSectionModal'),
      theme: 'bootstrap-5',
      delay: 250,
      placeholder: 'Search for a Teacher',
      ajax: {
        method:"GET",
        headers: {
          "Authorization" : "Bearer "+token
        },
        dataType: "json",
        url: baseUrl+'/api/teacher/get/select2',
        data: function (params) {
          console.log("select2 params:"+params.term);
          var query = {
            search: params.term
          }

          // Query parameters will be ?search=[term]&type=public
          return query;
        },
        processResults: function (data) {
          // data = JSON.parse(data);
          // console.log("process result:"+data.results);
          return data;
        },
        
        minimumInputLength: 1,
        templateResult: (t)=>{
          console.log(t);
          if (repo.loading) {
            return repo.text;
          }
        }
       
          // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
      }

    });

    const picker= new datetimepicker(document.getElementById('endDate'));
    picker.dates.formatInput = date => moment(date).format('YYYY-MM-DD hh:mm A');

    const picker2= new datetimepicker(document.getElementById('exam_endDate'));
    picker2.dates.formatInput = date => moment(date).format('YYYY-MM-DD hh:mm A');

   
    $('#sectionSubjects tbody').on('click', '.quiz-btn', function(){
      var data = sectionSubjects.row($(this).parents('tr')).data();
     
      $("#uploadQuizForm #subject").data("subjectCode",data.subj_code);
      $("#uploadQuizForm #subject").val(data.subj_desc);
      console.log($("#subject").data("subjectCode"));
      
      $("#uploadQuizModal").modal("show");
    })

    $('#sectionSubjects tbody').on('click', '.exam-btn', function(){
      var data = sectionSubjects.row($(this).parents('tr')).data();
     
      $("#uploadExamForm #subject").data("subjectCode",data.subj_code);
      $("#uploadExamForm #subject").val(data.subj_desc);
      // console.log($("#subject").data("subjectCode"));
      
      $("#uploadExamModal").modal("show");
    })


    $('#sectionSubjects tbody').on('click', '.lesson-btn', function(){
      var data = sectionSubjects.row($(this).parents('tr')).data();
     
      $("#addLessonModal #subject").data("subjectCode",data.subj_code);
      $("#addLessonModal #subject").val(data.subj_desc);
      // console.log($("#subject").data("subjectCode"));
      
      $("#addLessonModal").modal("show");
    })

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
      var subjCode =$("#addLessonForm #subject").data("subjectCode");      
      var form = $("#addLessonForm");

      var formData = new FormData(form[0]);
      formData.append("subj_code", subjCode);
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
                swal.fire({
                  icon:'success',
                  title: 'Uploading Lesson Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  $("#addLessonModal").modal("hide");
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



    $("#uploadQuizForm").submit((e)=>{
      e.preventDefault();
      var subjCode =$("#uploadQuizForm #subject").data("subjectCode");
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

  $("#uploadExamForm").submit((e)=>{
      e.preventDefault();
      var subjCode =$("#uploadExamForm #subject").data("subjectCode");
      var form = $("#uploadExamForm");
      var formData = new FormData(form[0]);
      formData.append("subj_code", subjCode);
      formData.append("section_code", sectionCode);

      swal.fire({
        title: 'You are uploading new Exam?',
        showCancelButton: true,
        confirmButtonText: 'Upload',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url:baseUrl+"/api/teacher/upload/exam",
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
                $("#uploadExamModal").modal("hide");
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
