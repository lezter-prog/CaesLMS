@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Teachers</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <button type="button" id ="addTeacherBtn" class="btn btn-sm btn-outline-primary">Add</button>
      <button type="button" id="updateTeacherBtn" class="btn btn-sm btn-outline-primary">Edit</button>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="teachersTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Teacher</th>
            <th>School Year</th>
            <th>Status</th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>

<div class="modal fade" id="updateTeacherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Teacher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateTeacherForm">
      <div class="modal-body">
        <div class="mb-3">
          <label for="teacherName" class="form-label">Teacher Name</label>
          <input type="text" class="form-control" id="updateTeacherName" required data-code="">
          {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="updateEmail">
        </div>
        {{-- <div class="mb-3">
          <label for="gradeCode" class="form-label">Select Grade</label>
          <select type="text" class="form-control" id="updateGradeCode">
            <option value="G1">Grade 1</option>
            <option value="G2">Grade 2</option>
            <option value="G3">Grade 3</option>
            <option value="G4">Grade 4</option>
            <option value="G5">Grade 5</option>
            <option value="G6">Grade 6</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="updateSectionCode" class="form-label">Select Section</label>
          <select type="text" class="form-control" id="updateSectionCode" required >
            @foreach ($sections as $section)
            <option value="{{ $section->section_code }}">{{ $section->section_desc}}</option>
            @endforeach
          </select>
        </div> --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

  <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Teacher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addTeacherForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="teacherName" class="form-label">Teacher Name</label>
            <input type="text" class="form-control" id="teacherName" >
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email">
          </div>
          {{-- <div class="mb-3">
            <label for="gradeCode" class="form-label">Select Grade</label>
            <select type="text" class="form-control" id="gradeCode">
              <option value="G1">Grade 1</option>
              <option value="G2">Grade 2</option>
              <option value="G3">Grade 3</option>
              <option value="G4">Grade 4</option>
              <option value="G5">Grade 5</option>
              <option value="G6">Grade 6</option>
            </select>
          </div> --}}
          {{-- <div class="mb-3">
            <label for="sectionCode" class="form-label">Select Section</label>
            <select type="text" class="form-control" id="sectionCode" required >
              @foreach ($sections as $section)
              <option value="{{ $section->s_code }}">{{ $section->s_desc}}</option>
              @endforeach
            </select>
          </div> --}}
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
  console.log(token);

$(document).ready(function(){
    console.log('log');
    var teachersTable = $('#teachersTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/teacher/get",
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
        {"data":"sy" },
        {"data":"status"}
      ]
    });

    // select row
    $('#teachersTable tbody').on( 'click', 'tr', function () {   
      console.log($(this).hasClass('selected'));         
        if ( $(this).hasClass('selected') ) { 
            $(this).removeClass('selected'); 
        } 
        else {                 
          teachersTable.$('tr.selected').removeClass('selected'); 
            console.log($(this).text());
            $(this).addClass('selected');                
        }  

      });

// Open Add Modal
    $("#addTeacherBtn").click(()=>{
      $("#addTeacherModal").modal("show");
    });

// Open Update Modal
    $("#updateTeacherBtn").click(()=>{
      var data = teachersTable.row( ".selected" ).data();
      console.log(data);
      $("#updateTeacherName").data("code",data.user_id);
      $("#updateTeacherName").val(data.name);
      $("#updateEmail").val(data.email);
      // $("#updateGradeCode").val(data.handled_g_code);
      // $("#updateSectionCode").val(data.handled_s_code);


      $("#updateTeacherModal").modal("show");
    });

    $("#addTeacherForm").submit((e)=>{

      e.preventDefault();
      swal.fire({
        title: 'Do you want to save the Teacher?',
        showCancelButton: true,
        confirmButtonText: 'Save',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/teacher/create",
            type:"POST",
            data:{
              "name":$("#teacherName").val(),
              "sy":"2022-2023"
            },
            success:(res)=>{
              console.log(res);
              if(res){
                teachersTable.ajax.reload();

                swal.fire({
                  icon:'success',
                  title: 'Saving Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                $("#addTeacherModal").modal("hide");
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

    $("#updateTeacherForm").submit((e)=>{
      var code =$("#updateTeacherName").data("code");

      e.preventDefault();
      swal.fire({
        title: 'Do you want to update the Teacher?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/teacher/"+code+"/update",
            type:"patch",
            data:{
              "name":$("#updateTeacherName").val(),
              "email":$("#updateEmail").val()
            },
            success:(res)=>{
              console.log(res);
              res =JSON.parse(res);
              console.log(res);
              if(res){
                teachersTable.ajax.reload();
                swal.fire({
                  icon:'success',
                  title: 'Updating Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  $("#updateTeacherModal").modal("hide");
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
