@extends('layouts.app')
@section('title', 'Activity')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Activity</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <select class="form-select js-data-example-ajax" id="quarter" aria-label="Default select example">
        @foreach ($quarters as $quarter)
        <option value="{{$quarter->quarter_code}}" @if ($quarter->status === 'ACTIVE') selected @endif >{{$quarter->quarter_desc}}</option>
        @endforeach
      </select>
    </div>
    <div class="btn-group me-2">
      <button type="button" id ="importBtn" class="btn btn-sm btn-outline-primary">Upload Activity</button>
      
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="activityTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            {{-- <th>Quiz Id</th> --}}
            <th>Activity Description</th>
            <th>Section</th>
            <th>Subject</th>
            <th>Total Points</th>
            <th>Status</th>
        
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
   var activityTable= $('#activityTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/quiz/get/all",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
           
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
              "quarter":currentQuarter,
              "type":"activity"
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"assesment_desc",
            // "render":function(data, type, row, meta ){
            //   var status ="";
              
            //     if(row.status == "ACTIVE"){
            //       status =' <span class="badge text-bg-primary">'+row.status+'</span> ';
            //     }
            //     return data+status;
            //   }
        }, 
        { "data":"s_desc"},
        { "data":"subj_desc"},
        { "data":"total_points" },
        {"data":"status",
            "render":function(data, type, row, meta ){
                  var status ="";
                  
                    if(row.status == "ACTIVE"){
                      status =' <span class="badge text-bg-primary">'+row.status+'</span> ';
                    }
                    var close=' <button  class="btn btn-warning btn-sm close-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Close the Quiz"><i class="fa-regular fa-rectangle-xmark"></i></button>'
                    var edit=' <button  class="btn btn-success btn-sm edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Re-Upload Quiz"><i class="fa-solid fa-pen-to-square"></i></button>'
                    var view=' <button  class="btn btn-primary btn-sm view-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Quiz"><i class="fa-solid fa-list-check"></i></button>'

                    return status+edit+close+view;
                  }
        }
      ],
      "columnDefs":[
        {
          "targets":0,
          "width":"30%"
        },
        {
          "targets":1,
          "width":"15%"
        },
        {
          "targets":2,
          "width":"15%"
        },
        {
          "targets":3,
          "width":"10%",
          "className":"text-end"
        },
        {
          "targets":4,
          "width":"15%",
          "className":"text-center"
        }
        
      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });
    $('#quarter').on('change', function(){
      currentQuarter=$(this).val();
      activityTable.ajax.reload();

    });

      
          $('#activityTable tbody').on( 'click', '#updateStatusBtn', function () {
            var data = activityTable.row( $(this).closest('tr') ).data();

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
                      activityTable.ajax.reload();
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
