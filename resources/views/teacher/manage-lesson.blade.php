@extends('layouts.app')
@section('title', 'Lesson')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Lesson</h1>
  
 
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <select class="form-select js-data-example-ajax" id="quarter" aria-label="Default select example">
        @foreach ($quarters as $quarter)
        <option value="{{$quarter->quarter_code}}" @if ($quarter->status === 'ACTIVE') selected @endif >{{$quarter->quarter_desc}}</option>
        @endforeach
      </select>
    </div>
    
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY {{session('school_year')}}</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="lessonTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Lesson Description</th>
            <th>Lesson Subject</th>
            <th>Lesson Section</th>
            <th>File Name</th>
            <th>Status</th>
            <th></th>
        
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>

 
<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};

  $(document).ready(function(){
   var sectionCode="";
   var currentQuarter =$("#quarter").val();
   var lessonTable= $('#lessonTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      responsive: true,
      "sAjaxSource": baseUrl+"/api/lesson/get/all",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
           
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
              "quarter":currentQuarter
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        // { "data":"subj_code"},
        { "data":"lesson"},
        { "data":"subj_desc" }, 
        { "data":"s_desc"},
        { "data":"file" },
        {"data":"status"},
        {"data":"",
          "className":"text-center",
            "render":function(data,meta,row,table){
              var buttons ="";
              console.log(role);
                var download ='<button class="btn btn-success btn-sm download-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Template"><i class="fa-solid fa-download"></i></button> ';
                var remove =' <button class="btn btn-danger btn-sm remove-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Template"><i class="fa-solid fa-trash"></i></button> ';
                return download+remove;
              }
          }
      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

    $('#lessonTable tbody').on('click', '.remove-btn', function(){
      var data = lessonTable.row($(this).parents('tr')).data();
              swal.fire({
                title: 'Do you want to remove selected Lesson?',
                showCancelButton: true,
                confirmButtonText: 'Removed',
              }).then((result) => {
              
                if (result.isConfirmed) {

                  $.ajax({
                    url:baseUrl+"/api/lesson/remove",
                    type:"POST",
                    data:{
                      "file":data.filename,
                      "id":data.id                
                    },
                    success:(res)=>{
                      console.log(res);
                      
                      if(res.result){
                        swal.fire({
                            icon:'success',
                            title: 'Removing Lesson Success',
                            showCancelButton: false,
                            confirmButtonText: 'Ok',
                          }).then((result) => {
                            swal.close();
                            lessonTable.ajax.reload();
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

    $('#quarter').on('change', function(){
      currentQuarter=$(this).val();
      lessonTable.ajax.reload();

    });

      
          $('#lessonTable tbody').on( 'click', '#updateStatusBtn', function () {
            var data = lessonTable.row( $(this).closest('tr') ).data();

            swal.fire({
              title: 'Are you sure to use this Quarter?',
              showCancelButton: true,
              confirmButtonText: 'Update',
            }).then((result) => {
            
              if (result.isConfirmed) {

                $.ajax({
                  url:baseUrl+"/api/quarter/update/"+data.quarter_code,
                  type:"PATCH",
                  success:(res)=>{
                    console.log(res);
                    if(res){
                      swal.fire('Saved!', '', 'success');
                      swal.close();
                      lessonTable.ajax.reload();
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
               
          } );

});
</script>
@endsection
