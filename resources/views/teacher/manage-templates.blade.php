@extends('layouts.app')
@section('title', 'Templates')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Templates</h1>
  
  
  <div class="btn-toolbar mb-2 mb-md-0">
    @if($role == "R0")
    <div class="btn-group me-2">
      <button type="button" id ="importBtn" class="btn btn-sm btn-outline-primary">Upload Template</button>
    </div>
    @endIf
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY {{session('school_year')}}</b>
  </div>
  
</div> 
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="templatesTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Template  Description</th>
            <th>File</th>
            <th></th>
            
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>

<div class="modal fade" id="uploadTemplateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Template</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="uploadTemplateForm">
      <div class="modal-body">
        <div class="mb-3">
          <label for="lesson" class="form-label">Template Description</label>
          <input type="text" class="form-control" id="templateDesc" name="templateDesc" >
          {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
  
        <div class="mb-3">
          <div class="input-group">
            <input type="file" class="form-control" id="template_file" name="template_file" aria-describedby="upload-lesson" aria-label="Upload">
            <button class="btn btn-outline-secondary" type="button" id="upload_template" disabled>Upload Template</button>
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

<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};
 

  $(document).ready(function(){
    var role ={{ Js::from($role) }};
    var templatesTable = $("#templatesTable").DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/template/get/all",
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
          {"data":"template_desc"},
          {"data":"filename"},
          {"data":"filename",
          "className":"text-center",
            "render":function(data,meta,row,table){
              var buttons ="";
              console.log(role);
                var download ='<button class="btn btn-success btn-sm download-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Template"><i class="fa-solid fa-download"></i></button> ';
                var remove =' <button class="btn btn-danger btn-sm remove-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Template"><i class="fa-solid fa-trash"></i></button> ';
                  if(role == "R0"){
                    buttons =download+remove;
                  }else{
                    buttons =download;
                  }
                return buttons;
              }
          }
        ]
    });

    $('#templatesTable tbody').on('click', '.download-btn', function(){
      var data = templatesTable.row($(this).parents('tr')).data();
     
      swal.fire({
        icon:'info',
        title: 'You are trying to download a template?',
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url:baseUrl+"/api/template/download/"+data.id,
            type:"GET",
            xhr: function() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 2) {
                        if (xhr.status == 200) {
                            xhr.responseType = "blob";
                        } else {
                            xhr.responseType = "text";
                        }
                    }
                };
                return xhr;
            },
            success:(b)=>{
                const url = window.URL.createObjectURL(b);
                console.log(url);
                var a = document.createElement('a');
                a.href = url;
                a.download = data.filename;
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                swal.close();

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
        }
      });
    });


    $('#templatesTable tbody').on('click', '.remove-btn', function(){
      var data = templatesTable.row($(this).parents('tr')).data();
              swal.fire({
                title: 'Do you want to remove selected Templates?',
                showCancelButton: true,
                confirmButtonText: 'Removed',
              }).then((result) => {
              
                if (result.isConfirmed) {

                  $.ajax({
                    url:baseUrl+"/api/template/remove",
                    type:"POST",
                    data:{
                      "filename":data.filename,
                      "id":data.id                
                    },
                    success:(res)=>{
                      console.log(res);
                      
                      if(res.result){
                        swal.fire({
                            icon:'success',
                            title: 'Uploading Template Success',
                            showCancelButton: false,
                            confirmButtonText: 'Ok',
                          }).then((result) => {
                            swal.close();
                            $("#uploadTemplateModal").modal("hide");
                            location.reload();
                            swal.close();
                            templatesTable.ajax.reload();
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


    $('#importBtn').on('click', function(){
      $("#uploadTemplateModal").modal("show");
    })

    $("#uploadTemplateForm").submit((e)=>{
      e.preventDefault();  
      var form = $("#uploadTemplateForm");

      var formData = new FormData(form[0]);

      swal.fire({
        title: 'Do you want to save the Template?',
        showCancelButton: true,
        confirmButtonText: 'Save'
      }).then((result) => {
       
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/template/upload",
            type:"POST",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data:formData,
            success:(res)=>{
              console.log(res);
              if(res.result){
                swal.fire({
                  icon:'success',
                  title: 'Uploading Template Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  $("#uploadTemplateModal").modal("hide");
                  location.reload();
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

  })
</script>
@endsection


