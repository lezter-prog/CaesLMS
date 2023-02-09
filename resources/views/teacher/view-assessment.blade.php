@extends('layouts.app')
@section('title', 'Assessment View')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <div class="row">
    <h1 class="h2">{{$assessmentDesc}}</h1> 
    
  </div>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    {{-- <div class="btn-group me-2">
      <select class="form-select js-data-example-ajax" id="quarter" aria-label="Default select example">
        @foreach ($quarters as $quarter)
        <option value="{{$quarter->quarter_code}}" @if ($quarter->status === 'ACTIVE') selected @endif >{{$quarter->quarter_desc}}</option>
        @endforeach
      </select>
    </div> --}}
    <div class="btn-group me-2">
      @if($assessment->status =="CLOSED")
      <button type="button" id ="reopen" class="btn btn-sm btn-outline-primary">Re-Open Quiz</button>
      @else
      <button type="button" id ="quizCloseBtn" class="btn btn-sm btn-outline-warning">Close This Assessment</button>
      @endif
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
    </button>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <span><span class="badge bg-success">Section</span> {{$assessment->s_desc}} </span> |
  <span> <span class="badge bg-success">Subject</span> {{$assessment->subj_desc}}</span> |
  <span> <span class="badge bg-info">{{$assessment->test_type}}</span> </span> |
  <span> <span class="badge bg-{{$assessment->statusColor}}">{{$assessment->status}} </span> </span>

  <div class="row ">
   </div>
  
  <div class="col-12 ">
    
    <table id ="scoreSheetTable"  class="table table-striped" style="width:100%">
        <thead>
          <tr>
              <th>Student Name</th>
              <th>Section</th>
              <th>Score</th>   
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
   var sectionCode={{ Js::from($assessment->section_code) }};
   var currentQuarter =$("#quarter").val();
   var assessmentId ={{ Js::from($assessment->assesment_id) }};
   var totalPoints ={{ Js::from($assessment->total_points) }};
   var scoreSheetTable= $('#scoreSheetTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/assessment/get/scores",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
           
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
              "quarter":currentQuarter,
              "assessmentId":assessmentId,
              "sectionCode":sectionCode
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"first_name",
          "render":function(data,settings,row){

            return data+" "+row.last_name;

          }
        }, 
        { "data":"s_desc"},
        { "data":"score",
          "className":"text-center",
          "render":function(data, type, row, meta ){
                console.log(row);
                var score ='<span class="badge bg-primary">'+data+'/'+totalPoints+'</span>';

                if(row.studentStatus ==null){
                    score ='<span class="badge bg-warning"> Not yet taken</span>';
                }else if(row.studentStatus=="in-progress"){
                    score ='<span class="badge bg-info"> In Progress</span>';
                }
                    return score;
              }

        },
        {"data":"status",
            "render":function(data, type, row, meta ){
                  var status ="";
                  
                    if(row.status == "ACTIVE"){
                      status =' <span class="badge bg-primary">'+row.status+'</span> ';
                    }
                    var view=' <button  class="btn btn-primary btn-sm view-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Answers"><i class="fa-solid fa-list-check"></i></button>'

                    if(row.score=="" || row.score==null){
                        view="";
                    }
                    return view;
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
          "className":"text-center"
        }
        
      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });
    $('#quarter').on('change', function(){
      currentQuarter=$(this).val();
      scoreSheetTable.ajax.reload();

    });
    $('#scoreSheetTable tbody').on('click','.view-btn',function(){
      var data = scoreSheetTable.row( $(this).closest('tr') ).data();
      location.href="/assesment/view/answer?assesmentId="+assessmentId+"&&studentId="+data.id_number; 
    });

    $("#quizCloseBtn").on('click',function(){
      swal.fire({
        title: 'Are you sure you want to close this quiz?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        if (result.isConfirmed) {
          swal.showLoading();
          $.ajax({
            url:baseUrl+"/api/assessment/close",
            type:"POST",
            data:{
              "assessmentId":assessmentId
            },
            success:(res)=>{
              console.log(res);
              if(res.result){  
                swal.fire({
                  icon:'success',
                  title: 'Closing Quiz Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  location.reload();
                });
              }else{
                swal.fire({
                  icon:'error',
                  title: res.message,
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  // location.reload();
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
      });

    });
    $("#reopen").on('click',function(){
      swal.fire({
        title: 'Are you sure you want to re-open this quiz?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        if (result.isConfirmed) {
          swal.showLoading();
          $.ajax({
            url:baseUrl+"/api/assessment/open",
            type:"POST",
            data:{
              "assessmentId":assessmentId
            },
            success:(res)=>{
              console.log(res);
              if(res.result){  
                swal.fire({
                  icon:'success',
                  title: 'Re-Opening Quiz Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  location.reload();
                });
              }else{
                swal.fire({
                  icon:'error',
                  title: res.message,
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  // location.reload();
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
      });

    })

      
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
