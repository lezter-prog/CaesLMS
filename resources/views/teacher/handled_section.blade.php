@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">{{ $sections->s_desc}}</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    
    
    {{-- <div class="btn-group me-2">
      <button type="button" id ="addSectionBtn" class="btn btn-sm btn-outline-primary">Upload</button>
      <button type="button" id="updateSectionBtn"class="btn btn-sm btn-outline-primary">View</button>
    </div> --}}
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
    </button>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-sm-12">
    

    <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <button class="nav-link active" id="v-pills-students-tab" data-bs-toggle="pill" data-bs-target="#v-pills-students" type="button" role="tab" aria-controls="v-pills-students" aria-selected="true">Students</button>
          <button class="nav-link" id="v-pills-lessons-tab" data-bs-toggle="pill" data-bs-target="#v-pills-lessons" type="button" role="tab" aria-controls="v-pills-lessons" aria-selected="false">Lessons</button>
          <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Quizes</button>
          <button class="nav-link" id="v-pills-activities-tab" data-bs-toggle="pill" data-bs-target="#v-pills-activities" type="button" role="tab" aria-controls="v-pills-activities" aria-selected="false">Activities</button>

          <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Exams</button>
        </div>
        <div class="tab-content" id="v-pills-tabContent" style="width: 100%">
          <div class="tab-pane fade show active" id="v-pills-students" role="tabpanel" aria-labelledby="v-pills-students-tab">
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
          <div class="tab-pane fade" id="v-pills-lessons" role="tabpanel" aria-labelledby="v-pills-lessons-tab">
            <div class="btn-toolbar mb-2 mb-md-0">
    
    
              <div class="btn-group me-2">
                <button type="button" id ="addLessonBtn" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Lesson">Add</button>
                <button type="button" id="updateLessonBtn"class="btn btn-sm btn-outline-primary">Edit</button>
              </div>
            </div>
            <table id ="teacherLessonsTable"  class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                      <th>Lesson</th>
                      <th>Subject</th>
                      <th>file</th>
                      <th>Status</th>
                      <th></th>
                  </tr>
                </thead>
                <tbody>
                 
                </tbody>
            
          
              </table>          
          </div>
          <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
          <table id ="quizzeTable"  class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                      <th>Quizze Name </th>
                      <th>Subject</th>
                      <th>Uploaded Date</th>
                      <th>Deadline</th>
                  </tr>
                </thead>
                <tbody>
                 
                </tbody>
            
          
              </table> 
          </div>
          <div class="tab-pane fade" id="v-pills-activities" role="tabpanel" aria-labelledby="v-pills-activities-tab">...</div>

          <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
        </div>
      </div>
    {{-- <table id ="sectionsTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Student Name</th>
            <th>Status</th>
            <th></th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table> --}}
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
  <div class="modal fade bd-example-modal-lg" id="subjectSectionModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Section Subjects</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <table id ="sectionSubjectsTable"  class="table table-striped" style="width:100%">
              <thead>
                <tr>
                    <th>Section Code</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th></th>
                </tr>
              </thead>
              <tbody>
                
               
              </tbody>
          
        
            </table>
          </div>
          
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button> --}}
        </div>
        
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
      "sAjaxSource": baseUrl+"/api/section/get",
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
        { "data":"s_code"},
        { "data":"s_desc"},
        { "data":"g_code" },
        { "data":"teacher_id" },
        {"data":"status" },
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

    var teacherLessonsTable= $('#teacherLessonsTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/lesson/get/all",
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
        { "data":"lesson"},
        { "data":"subj_desc"},
        { "data":"file" },
        { "data":"status" },
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
    var quizzeTable= $('#quizzeTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/section/get",
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
        { "data":"s_code"},
        { "data":"s_desc"},
        { "data":"g_code" },
        { "data":"teacher_id" },
        {"data":"status" },
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

    // subjects Section Table
    var sectionSubjectsTable= $('#sectionSubjectsTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/section/subjects/get",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
           
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":function(d){
              d.sectionCode = sectionCode;
              return d;
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"s_section"},
        { "data":"subject"},
        { "data":"teacher" },
        {"data":"status" },
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

    $("#grades").on('change',()=>{
      sectionTable.ajax.reload();
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

    $("#selectSubject").select2({
      dropdownParent: $('#addLessonModal'),
      theme: 'bootstrap-5',
      delay: 250,
      placeholder: 'Select for a Subject',
      ajax: {
        method:"GET",
        headers: {
          "Authorization" : "Bearer "+token
        },
        dataType: "json",
        url: baseUrl+'/api/subjects/get/select2',
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
    $('#sectionsTable tbody').on('click', '.section-subjects', function(){
      var data = sectionTable.row( $(this).closest('tr') ).data();
      sectionCode =data.s_code;
      $("#subjectSectionModal").modal("show");
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


    $("#updateSectionForm").submit((e)=>{
      var code =$("#updateSectionName").data("code");

      e.preventDefault();
      swal.fire({
        title: 'Do you want to update the Section?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/section/"+code+"/update",
            type:"patch",
            data:{
              "s_code":code,
              "s_desc":$("#updateSectionName").val(),
              "g_code":$("#updateGradeCode").val(),
              "teacher_id":$("#updateTeacher").select2('data')
            },
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire('Update!', '', 'success');
                swal.close();
                $("#updateSectionModal").modal("hide");
                sectionTable.ajax.reload();
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
