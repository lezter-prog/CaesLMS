@extends('layouts.app')
@section('title', 'Quiz')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Quizes</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <select class="form-select js-data-example-ajax" id="quarter" aria-label="Default select example">
        @foreach ($quarters as $quarter)
        <option value="{{$quarter->quarter_code}}" @if ($quarter->status === 'ACTIVE') selected @endif >{{$quarter->quarter_desc}}</option>
        @endforeach
      </select>
    </div>
    <div class="btn-group me-2">
      <button type="button" id ="importBtn" class="btn btn-sm btn-outline-primary">Upload Quiz</button>
      
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="quizTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            {{-- <th>Quiz Id</th> --}}
            <th>Quiz Description</th>
            <th>Section</th>
            <th>Subject</th>
            <th>Type</th>
            <th>Status</th>
            <th></th>
        
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>

<div class="modal fade bd-example " id="uploadQuizModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Quiz</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="uploadQuizForm">
      <div class="modal-body">
        <div class="mb-3">
          <label for="grade" class="form-label"></label>
          <select type="text" class="form-control" id="assessmentType" name="assessmentType" >
            <option  value="quiz">Quiz</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="lesson" class="form-label">Section</label>
          {{-- <input type="text" class="form-control" id="subject" name="subject" readonly> --}}
          <select type="text" class="form-control" id="section" name="section_code" >
            @foreach($sections as $section)
            <option  value="{{$section->s_code}}">{{$section->s_desc}}</option>
            @endforeach
          </select>
          {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
        <div class="mb-3">
          <label for="lesson" class="form-label">Subject</label>
          {{-- <input type="text" class="form-control" id="subject" name="subject" readonly> --}}
          <select type="text" class="form-control" id="subject" name="subj_code" >
            
          </select>
          {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
        <div class="mb-3">
          <label for="lesson" class="form-label">Quiz Description</label>
          <input type="text" class="form-control" id="quizDesc" name="quizDesc" required>
          {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
        <div class="mb-3">
          <div class="input-group">
            <input type="file" class="form-control" id="quiz_file" name="quiz_file" aria-describedby="upload-quiz" aria-label="upload" required>
            
          </div>
        </div>
        <div class="mb-3">
          <label for="lesson" class="form-label">Total Points</label>
          <input type="number" class="form-control" id="totalPoints" name="totalPoints" required>
        </div>
        <div class="mb-3">
          <label for="grade" class="form-label">Select Quiz Type</label>
          <select type="text" class="form-control" id="quizType" name="quizType" >
            <option value="multiple">Multiple Choice</option>
            <option value="identify">Identification</option>
            <option value="enumerate">Enumeration</option>
          </select>
        </div>
        
        <div class="mb-3">
          <label for="endDateInput" class="form-label">End Date</label>
          <div class="input-group log-event" id="endDate" data-td-target-input="nearest" data-td-target-toggle="nearest">
            <input id="endDateInput" name="endDate" type="text" class="form-control" data-td-target="#endDate" readonly required>
            <span class="input-group-text" data-td-target="#endDate" data-td-toggle="datetimepicker">
              <i class="fas fa-calendar"></i>
            </span>
          </div>
          {{-- <label for="lesson" class="form-label">Select End Date</label>
          <input type="text" class="form-control" id="endDate" name="subject" readonly> --}}
          {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
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
   var sectionCode="";
   var currentQuarter =$("#quarter").val();
   var quizTable= $('#quizTable').DataTable({
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
              "type":"quiz"
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"assesment_desc",
            "render":function(data, type, row, meta ){
              var type =' <span class="badge bg-primary">'+row.test_type+'</span> ';
              
                // if(row.status == "ACTIVE"){
                //   status =' <span class="badge text-bg-primary">'+row.status+'</span> ';
                // }

                return data;
              }
        }, 
        { "data":"s_desc"},
        { "data":"subj_desc"},
        { "data":"test_type",
            "render":function(data, type, row, meta){
                return ' <span class="badge bg-primary">'+data+'</span>';
            }
        },
        {"data":"status",
             "render":function(data, type, row, meta ){
                  var status ="";
                  
                    if(row.status == "ACTIVE"){
                      status =' <span class="badge bg-primary">'+row.status+'</span> ';
                    }else{
                      status =' <span class="badge bg-danger">'+row.status+'</span> ';
                    }
                     
                    return status;
                  }
        },
        {"data":"status",
            "render":function(data, type, row, meta ){
              var disabled="";
              if(row.status=="CLOSED"){   
                disabled="disabled"
              }
                  
                    var eye=' <button  class="btn btn-info btn-sm viewquiz-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View the quiz"><i class="fa-regular fa-eye"></i></button>'
                    // var close=' <button  class="btn btn-warning btn-sm close-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Close the Quiz"><i class="fa-regular fa-rectangle-xmark"></i></button>'
                    var edit=' <button '+disabled+' class="btn btn-danger btn-sm delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Quiz"><i class="fa-solid fa-trash"></i></button>'
                    var view=' <button  class="btn btn-primary btn-sm view-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="See Score Sheet"><i class="fa-solid fa-list-check"></i></button>'
                    return eye+edit+view;
                  }
        }
      ],
      "columnDefs":[
        {
          "targets":0,
          "width":"25%"
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
        },
        {
          "targets":4,
          "width":"10%",
          "className":"text-center"
        },
        {
          "targets":5,
          "width":"15%",
          "className":"text-center"
        }
        
      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });
    const picker= new tempusDominus.TempusDominus(document.getElementById('endDate'));
    picker.dates.formatInput = date => moment(date).format('YYYY-MM-DD hh:mm A');

    $('#quarter').on('change', function(){
      currentQuarter=$(this).val();
      quizTable.ajax.reload();

    });

    $('#importBtn').on('click', function(){
      var sectionCode=$("#section").val();
      $.ajax({
          url:baseUrl+"/api/teacher/section/subjects/",
          type:"GET",
          data:{
            sectionCode:sectionCode
          },
          success:(res)=>{
            // console.log(res);
            if(res.data){
              res.data.forEach(data=>{
                $("#subject").append('<option value="'+data.subj_code+'">'+data.subj_desc+'<option>')
              })
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
     
      // $("#uploadQuizForm #subject").data("subjectCode",data.subj_code);
      // $("#uploadQuizForm #subject").val(data.subj_desc);
      // console.log($("#subject").data("subjectCode"));
      
      $("#uploadQuizModal").modal("show");
    })

    $('#quizTable tbody').on('click', '.viewquiz-btn', function(){
      var data = quizTable.row($(this).parents('tr')).data();
      console.log(data);

      if(data.test_type=="multiple"){
        window.location.href = "/assesment/multiple?assesmentId="+data.assesment_id;
      }else if(data.test_type=="identify"){
        window.location.href = "/assesment/identify?assesmentId="+data.assesment_id;
      }else if(data.test_type=="enumerate"){
        window.location.href = "/assesment/enumeration?assesmentId="+data.assesment_id;
      }
        
    });

    $("#uploadQuizForm").submit((e)=>{
      e.preventDefault();
      // var subjCode =$("#uploadQuizForm #subject").data("subjectCode");
      var form = $("#uploadQuizForm");
      var formData = new FormData(form[0]);

      swal.fire({
        title: 'You are uploading new Quiz?',
        showCancelButton: true,
        confirmButtonText: 'Upload',
      }).then((result) => {
        if (result.isConfirmed) {
          swal.showLoading();
          $.ajax({
            url:baseUrl+"/api/teacher/upload/quiz",
            type:"POST",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data:formData,
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire({
                  icon:'success',
                  title: 'Upload Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  quizTable.ajax.reload();
                $("#uploadQuizModal").modal("hide");
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

          $('#quizTable tbody').on( 'click', '.view-btn', function () {
            var data = quizTable.row( $(this).closest('tr') ).data();

            console.log(data);

            location.href="/teacher/view/assessment?assessmentId="+data.assesment_id+"&assessmentType=quiz";

          } );


          $('#quizTable tbody').on( 'click', '.delete-btn', function () {
            var data = quizTable.row( $(this).closest('tr') ).data();

            swal.fire({
              title: 'Are you sure you want to delete this Quiz?',
              showCancelButton: true,
              confirmButtonText: 'Delete',
            }).then((result) => {
            
              if (result.isConfirmed) {

                $.ajax({
                  url:baseUrl+"/api/assessement/remove/"+data.assesment_id,
                  type:"POST",
                  success:(res)=>{
                    console.log(res);
                    if(res.result){
                      swal.fire({
                      icon:'success',
                      title: 'Delete Success',
                      showCancelButton: false,
                      confirmButtonText: 'Ok',
                    }).then((result) => {
                      swal.close();
                      quizTable.ajax.reload();
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
            
          } );

});
</script>
@endsection
