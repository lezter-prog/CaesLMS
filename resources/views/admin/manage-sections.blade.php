@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Sections</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    
    <div class="btn-group me-2">
        <select class="form-select js-data-example-ajax" id="grades" aria-label="Default select example">
            <option value="G1">Grade 1</option>
            <option value="G2">Grade 2</option>
            <option value="G3">Grade 3</option>
            <option value="G4">Grade 4</option>
            <option value="G5">Grade 5</option>
            <option value="G6">Grade 6</option>
          </select>
    </div>
    <div class="btn-group me-2">
      <button type="button" id ="addSectionBtn" class="btn btn-sm btn-outline-primary">Add</button>
      <button type="button" id="updateSectionBtn"class="btn btn-sm btn-outline-primary">Edit</button>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="sectionsTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Section Code</th>
            <th>Section</th>
            <th>Grade Code</th>
            <th>Teacher</th>
            <th>Status</th>
            <th></th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
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
   var sectionCode="";
   var sectionTable= $('#sectionsTable').DataTable({
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

    $("#updateTeacher").select2({
      dropdownParent: $('#updateSectionModal'),
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



    $("#addSectionBtn").click(()=>{
      $("#addSectionModal").modal("show");
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

    $("#addSectionForm").submit((e)=>{
      e.preventDefault();
      var selectedTeacher =$("#teacher").select2('data')[0];
      console.log(selectedTeacher);
      swal.fire({
        title: 'Do you want to save the Section?',
        showCancelButton: true,
        confirmButtonText: 'Save',
      }).then((result) => {
       
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/section/create",
            type:"POST",
            data:{
              "section_desc":$("#sectionName").val(),
              "grade_code":$("#gradeCode").val(),
              "teacher_id":selectedTeacher.id,
              "school_year":"2022-2023"
            },
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire('Saved!', '', 'success');
                swal.close();
                $("#addSectionModal").modal("hide");
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
