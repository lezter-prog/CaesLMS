@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Subjects</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <select class="form-select" id="grades" aria-label="Default select example">
          <option value="G1">Grade 1</option>
          <option value="G2">Grade 2</option>
          <option value="G3">Grade 3</option>
          <option value="G4">Grade 4</option>
          <option value="G5">Grade 5</option>
          <option value="G6">Grade 6</option>
        </select>
  </div>
    <div class="btn-group me-2">
      <button type="button" id ="addSubjectBtn" class="btn btn-sm btn-outline-primary">Add</button>
      <button type="button" id="updateSubjectBtn" class="btn btn-sm btn-outline-primary">Edit</button>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="subjectsTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Subject Code</th>
            <th>Subject Desc.</th>
            <th>Grade</th>
            <th>Status</th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>

<div class="modal fade" id="updateSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateSubjectForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="update_subject_code" class="form-label">Subject Code</label>
            <input type="text" class="form-control" id="update_subject_code" >
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="update_subject_desc" class="form-label">Subject Description</label>
            <input type="text" class="form-control" id="update_subject_desc">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="gradeCode" class="form-label">Select Grade</label>
            <select type="text" class="form-control" id="update_gradeCode">
              <option value="G1">Grade 1</option>
              <option value="G2">Grade 2</option>
              <option value="G3">Grade 3</option>
              <option value="G4">Grade 4</option>
              <option value="G5">Grade 5</option>
              <option value="G6">Grade 6</option>
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

  <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addSubjectForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="subject_code" class="form-label">Subject Code</label>
            <input type="text" class="form-control" id="subject_code" >
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="subject_desc" class="form-label">Subject Description</label>
            <input type="text" class="form-control" id="subject_desc">
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
    var subjectsTable = $('#subjectsTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/subjects/get",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
        console.log("request data: "+$("#grades").val());
          oSettings.jqXHR = 
          $.ajax({
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
              gradeCode:$("#grades").val()
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"subj_code"},
        { "data":"subj_desc" },
        { "data":"g_code" },
        { "data":"status",
            "render":function(row,settings,data){
                console.log(data);
                // return "<button class='showpass btn btn-success btn-sm' data-id='"+data.user_id+"'>show password</button>";
                return data.status;
              }
        }
      ],
      "columnDefs":[
        {
            "target":3,
            "className":"text-center"
        }
    ]
    });

    // select row
    $('#subjectsTable tbody').on( 'click', 'tr', function () {   
      console.log($(this).hasClass('selected'));         
        if ( $(this).hasClass('selected') ) { 
            $(this).removeClass('selected'); 
        } 
        else {                 
            subjectsTable.$('tr.selected').removeClass('selected'); 
            console.log($(this).text());
            $(this).addClass('selected');                
        }  

      });

      $("#grades").on('change',()=>{
        subjectsTable.ajax.reload();
      });

// Open Add Modal
    $("#addSubjectBtn").click(()=>{
      $("#addSubjectModal").modal("show");
    });

// Open Update Modal
    $("#updateSubjectBtn").click(()=>{
      var data = subjectsTable.row( ".selected" ).data();
      console.log(data);
      $("#update_subject_code").val(data.subj_code);
      $("#update_subject_desc").val(data.subj_desc);
      $("#update_gradeCode").val(data.g_code);
      $("#updateSubjectModal").modal("show");
    });

    $("#addSubjectForm").submit((e)=>{

      e.preventDefault();
      swal.fire({
        title: 'Do you want to save the subject?',
        showCancelButton: true,
        confirmButtonText: 'Save',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/subject/create",
            type:"POST",
            data:{
              "subj_code":$("#subject_code").val(),
              "subj_desc":$("#subject_desc").val(),
              "g_code":$("#gradeCode").val(),
              "sy":"2022-2023"
            },
            success:(res)=>{
              console.log(res);
              if(res){
                subjectsTable.ajax.reload();

                swal.fire({
                  icon:'success',
                  title: 'Saving Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                    $("#subject_code").val("");
                    $("#subject_desc").val("");
                    $("#gradeCode").val("");
                  swal.close();
                $("#addSubjectModal").modal("hide");

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

    $("#updateSubjectForm").submit((e)=>{
      var code =$("#update_subject_code").val();

      e.preventDefault();
      swal.fire({
        title: 'Do you want to update the Teacher?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/subject/"+code+"/update",
            type:"patch",
            data:{
              "subj_desc":$("#update_subject_desc").val(),
              "g_code":$("#update_gradeCode").val()
            },
            success:(res)=>{
              console.log(res);
              res =JSON.parse(res);
              console.log(res);
              if(res){
                subjectsTable.ajax.reload();
                swal.fire({
                  icon:'success',
                  title: 'Updating Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  $("#updateSubjectModal").modal("hide");
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
