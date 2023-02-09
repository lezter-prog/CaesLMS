@extends('layouts.app')
@section('title', 'Templates')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Templates</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    
   
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
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

<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};

  $(document).ready(function(){
    var templateTable = $("#templatesTable").DataTable({
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
                var download ='<div class="float-end"><button class="btn btn-success btn-sm download-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Lesson"><i class="fa-solid fa-download"></i></button> ';
                return download;
              }
          }
        ]
    });

  })
</script>
@endsection


