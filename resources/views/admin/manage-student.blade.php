@extends('layouts.app')
@section('title', 'Students')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Students</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <button type="button" id ="importBtn" class="btn btn-sm btn-outline-primary">Import</button>
      <button type="button" id="addStudentBtn" class="btn btn-sm btn-outline-primary">add</button>
      <button type="button" id="updateStudentBtn" class="btn btn-sm btn-outline-primary">Edit</button>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="studentsTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Student</th>
            <th>username</th>
            {{-- <th>password</th> --}}
            <th>Section</th>
            <th>Grade</th>
            <th>Password</th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>

<div class="modal fade" id="updateStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Teacher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateStudentForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="update_first_name" data-code ="">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="update_middle_name">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="update_last_name">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="update_gradeCode" class="form-label">Select Grade</label>
            <select type="text" class="form-control" id="update_gradeCode">
              <option value="">Select Grade</option>
              <option value="G1">Grade 1</option>
              <option value="G2">Grade 2</option>
              <option value="G3">Grade 3</option>
              <option value="G4">Grade 4</option>
              <option value="G5">Grade 5</option>
              <option value="G6">Grade 6</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="update_sectionCode" class="form-label">Select Section</label>
            <select type="text" class="form-control" id="update_sectionCode" required >
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

  <div class="modal fade" id="importStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import Students</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="importStudentForm">
        <div class="modal-body">
          <div class="mb-3">
            <div class="input-group">
              <input type="file" class="form-control" id="studentFile" name="studentFile" aria-describedby="importStudentsBtn" aria-label="Upload">
              <button class="btn btn-outline-secondary" type="submit" id="importStudentsBtn">Import</button>
            </div>
          </div>
         
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button> --}}
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addStudentForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" >
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middle_name">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="gradeCode" class="form-label">Select Grade</label>
            <select type="text" class="form-control" id="gradeCode">
              <option value="G1">Grade 1</option>
              <option value="G2">Grade 2</option>
              <option value="G3">Grade 3</option>
              <option value="G4">Grade 4</option>
              <option value="G5">Grade 5</option>
              <option value="G6">Grade 6</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="sectionCode" class="form-label">Select Section</label>
            <select  class="js-example-responsive  form-control" id="sectionCode" required >
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
<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};

$(document).ready(function(){
    console.log('log');
    var studentsTable = $('#studentsTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/student/get",
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
        { "data":"name"},
        { "data":"username" },
        { "data":"s_desc" },
        { "data":"grade_desc" },
        { "data":"",
            "render":function(row,settings,data){
                console.log(data);
                return "<button class='showpass btn btn-success btn-sm' data-bs-toggle='tooltip' data-bs-placement='top' title='Generate New Password' data-id='"+data.user_id+"'><i class='fa-solid fa-rotate'></i></button>";
            }
        }
      ],
      "columnDefs":[
        {
            "target":4,
            "className":"text-center"
        }
    ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

    

    // select row
    $('#studentsTable tbody').on( 'click', 'tr', function () {   
      console.log($(this).hasClass('selected'));         
        if ( $(this).hasClass('selected') ) { 
            $(this).removeClass('selected'); 
        } 
        else {                 
          studentsTable.$('tr.selected').removeClass('selected'); 
            console.log($(this).text());
            $(this).addClass('selected');                
        }  

      });

    $("#importBtn").click(()=>{
      $("#importStudentModal").modal("show");
    });

// Open Add Modal
    $("#addStudentBtn").click(()=>{
      $("#addStudentModal").modal("show");
    });

// Open Update Modal
    $("#updateStudentBtn").click(()=>{
      var data = studentsTable.row( ".selected" ).data();
      console.log(data);
      $("#update_first_name").data("code",data.id_number);
      $("#update_first_name").val(data.first_name);
      $("#update_middle_name").val(data.middle_name);
      $("#update_last_name").val(data.last_name);
      $("#update_gradeCode").val(data.g_code);

      $("#update_SectionCode").val(data.s_code);


      $("#updateStudentModal").modal("show");
    });

    $("#addStudentForm").submit((e)=>{

      e.preventDefault();
      var selectedSection =$("#sectionCode").select2('data')[0];
      swal.fire({
        title: 'Do you want to save the Student?',
        showCancelButton: true,
        confirmButtonText: 'Save',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/student/create",
            type:"POST",
            data:{
              "first_name":$("#first_name").val(),
              "middle_name":$("#middle_name").val(),
              "last_name":$("#last_name").val(),
              "g_code":selectedSection.g_code,
              "s_code":selectedSection.id,
              "sy":"2022-2023"
            },
            success:(res)=>{
              console.log(res);
              if(res){
                studentsTable.ajax.reload();

                swal.fire({
                  icon:'success',
                  title: 'Saving Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                $("#addStudentModal").modal("hide");
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

    $("#updateStudentForm").submit((e)=>{
      var code =$("#update_first_name").data("code");

      e.preventDefault();
      swal.fire({
        title: 'Do you want to update the Teacher?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/student/"+code+"/update",
            type:"patch",
            data:{
              "first_name":$("#update_first_name").val(),
              "middle_name":$("#update_middle_name").val(),
              "last_name":$("#update_last_name").val(),
              "g_code":$("#update_gradeCode").val(),
              "s_code":$("#update_sectionCode").val(),
            },
            success:(res)=>{
              console.log(res);
              res =JSON.parse(res);
              console.log(res);
              if(res){
                studentsTable.ajax.reload();
                swal.fire({
                  icon:'success',
                  title: 'Updating Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  $("#updateStudentModal").modal("hide");
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

  $("#importStudentForm").submit((e)=>{
      e.preventDefault();

      var form = $("#importStudentForm");

      var formData = new FormData(form[0]);
      swal.fire({
        title: 'Do you want to import all students in file?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/student/import",
            type:"post",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data:formData,
            success:(res)=>{
              console.log(res);
              if(res){
                studentsTable.ajax.reload();
                swal.fire({
                  icon:'success',
                  title: 'Imported Successfully',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  $("#updateStudentModal").modal("hide");
                });
              }else{
                swal.fire({
                  icon:'warning',
                  title: 'Import Failed',
                  message:res.message,
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  // swal.close();
                  // $("#updateStudentModal").modal("hide");
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

  $("#sectionCode").select2({
      dropdownParent: $('#addStudentModal'),
      theme: 'bootstrap-5',
      delay: 250,
      placeholder: 'Select Section',
      ajax: {
        method:"GET",
        headers: {
          "Authorization" : "Bearer "+token
        },
        dataType: "json",
        url: baseUrl+'/api/section/get/select2',
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
          console.log("process result:"+data.results);
          return data;
        },
        minimumInputLength: 1,
        
       
          // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
      },
      templateResult: function(repo){
        console.log(repo);
        if (!repo.loading) {
          // return "<strong>"+repo.text+"</strong>-"+repo.g_desc;
          return $(repo.text);
        }
      },
      templateSelection: function(repo){
        console.log(repo);
        if (!repo.loading) {
          // return "<strong>"+repo.text+"</strong>-"+repo.g_desc;
          return $(repo.text);
        }
      }

    });

    $('#sectionCode').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("Selected Section: "+data.g_code);
        $("#gradeCode").val(data.g_code);
    });


});
</script>
@endsection
