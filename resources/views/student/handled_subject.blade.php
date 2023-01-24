@extends('layouts.subjects')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2"><strong>{{ $subject->subj_desc}}</strong></h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    
    
    <div class="btn-group me-2">
      <select class="form-select js-data-example-ajax" id="quarter" aria-label="Default select example">
        @foreach ($quarters as $quarter)
        <option value="{{$quarter->quarter_code}}" @if ($quarter->status === 'ACTIVE') selected @endif >{{$quarter->quarter_desc}}</option>
        @endforeach
      </select>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
    </button>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-sm-12">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="lessons-tab" data-bs-toggle="tab" data-bs-target="#lessons" type="button" role="tab" aria-controls="lessons" aria-selected="true">Lesson</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="quiz-tab" data-bs-toggle="tab" data-bs-target="#quiz" type="button" role="tab" aria-controls="quiz" aria-selected="true">Quiz</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="true">Activity</button>
      </li>
    </ul>

    <div class="tab-content" id="SubjectTabContent">
      <div class="tab-pane fade show active pt-10" id="lessons" role="tabpanel" aria-labelledby="lessons-tab" style="padding-top: 20px;">
        <div class="row">
            <div class="col-6 pe-3">
              <table id ="studentLesson"  class="table table-striped" style="width:100%;box-shadow: #4c4c4c 0px 4px 12px">
                <thead>
                  <tr>
                      <th>Lessons</th>
                  </tr>
                </thead>
                <tbody>
                 
                </tbody>
              </table>
            </div>
            <div class="col-6">
              <div class="card mt-6" style="margin-top:6px;box-shadow: #4c4c4c 0px 4px 12px">
                <div class="card-header " style="background-color: #516a8a; color:white">
                  Details
                </div>
                <div class="card-body">
                  {{-- <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                </div>
              </div>
            </div>
        </div>
        
      </div>
      <div class="tab-pane fade" id="quiz" role="tabpanel" aria-labelledby="quiz-tab">
        <div class="row">
          <div class="col-lg-6 col-sm-12 pe-3">
            <table id ="quizTable"  class="table table-striped" style="width:100%;box-shadow: #4c4c4c 0px 4px 12px">
              <thead>
                <tr>
                    <th>Quiz</th>
                </tr>
              </thead>
              <tbody>
               
              </tbody>
            </table>
          </div>
          <div class="col-lg-6 col-sm-12">
            <div class="card mt-6" style="margin-top:6px;box-shadow: #4c4c4c 0px 4px 12px">
              <div class="card-header " style="background-color: #516a8a; color:white;">
                Details
              </div>
              <div class="card-body">
                <div class="row ">
                  <div class="col-12 text-center" id="chart">
                    
                  </div>
                </div>
                
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
      <div class="row">
        <div class="col-lg-6 col-sm-12 pe-3">
          <table id ="activityTable"  class="table table-striped" style="width:100%;box-shadow: #4c4c4c 0px 4px 12px">
            <thead>
              <tr>
                  <th>Activity</th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
          </table>
        </div>
        <div class="col-lg-6 col-sm-12">
          <div class="card mt-6" style="margin-top:6px;box-shadow: #4c4c4c 0px 4px 12px">
            <div class="card-header " style="background-color: #516a8a; color:white;">
              Details
            </div>
            <div class="card-body">
              <div class="row ">
                <div class="col-12 text-center" id="chartActivity">
                  
                </div>
              </div>
              
            </div>
          </div>
        </div>
    </div>
  </div>

  </div>
</div>

{{-- Modals --}}

 



 

{{-- Add Lesson  --}}

 
<script>

  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};

  $(document).ready(function(){

    var currentQuarter =$("#quarter").val();
    console.log(currentQuarter);

   
   var subjectCode={{ Js::from($subjectCode) }};
   var sectionCode={{ Js::from($sectionCode) }};
   console.log(subjectCode);
   var studentLesson= $('#studentLesson').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "processing": true,
      "language": {
        "processing": "Lesson Table is currently processing"
      },
      "serverSide": true,
      "bFilter": true,
      "bInfo": false,
      "ordering":false,
      "searching": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/lesson/get/"+subjectCode+"/"+sectionCode,
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
              "gradeCode":$("#grades").val(),
              "quarterCode":currentQuarter
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"lesson",
          "render":function(data, type, row, meta ){
            console.log(row);
                  var html ='<div class=""> <i class="fa-solid fa-file"></i> '+data;
                  var lesson ='<div class="float-end"><button class="btn btn-success btn-sm download-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Lesson"><i class="fa-solid fa-download"></i></button> ';
                  var quiz ='<button class="btn btn-warning btn-sm quiz-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Lesson"><i class="fa-solid fa-eye"></i></button> ';
                  var exam ='<button class="btn btn-info btn-sm exam-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="See Lesson Details"><i class="fa-solid fa-list-check"></i></button> </div>';
                  return html+lesson+quiz+exam+'</div>';
          }
        }
      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

    var quizTable= $('#quizTable').DataTable({
      "bPaginate": false,
      "processing": true,
      "language": {
        "processing": "Quiz Table Processing"
      },
      "serverSide": true,
      "bLengthChange": false,
      "bFilter": true,
      "ordering":false,
      "searching": false,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/quiz/get/"+sectionCode+"/"+subjectCode,
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
              "quarterCode":currentQuarter
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
            console.log(row);
            var quizType ='';
            var disabled="";
            var status='';
            var takingStatus='';
            if(row.isTaken){
               disabled ="disabled";
               takingStatus='<span class="badge text-bg-success">DONE</span> ';
            }else{
               takingStatus='<span class="badge text-bg-warning">Ready to Take</span> ';

            }

            if(row.status="ACTIVE")
              status ='<span class="badge text-bg-primary">'+row.status+'</span> ';
            else
              status ='<span class="badge text-bg-danger">'+row.status+'</span> ';
            
            if(row.test_type == "multiple"){
              quizType='<span class="badge text-bg-primary">Multiple Choice</span>';
            }else if(row.test_type == "identify"){
              quizType='<span class="badge text-bg-primary">Identification</span>';
            }

            

                  var html ='<div class="row"><div class="col-9"><i class="fa-solid fa-pencil"></i> '+data+'<br> '+status+takingStatus+quizType+' <div style="font-size:9px;margin-left:0px;"><strong>Created Date:</strong> '+moment(row.created_at).format('MMM-DD-YYYY h:mm A')+' <strong>End Date:</strong> '+moment(row.deadline).format('MMM-DD-YYYY h:mm A')+'</div></div><div class="col-3 text-end">';
                  var take ='<button '+disabled+' class="btn btn-success btn-sm take-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take the Quiz"><i class="fa-solid fa-square-pen"></i></button> ';
                  var quiz ='<button class="btn btn-warning btn-sm quiz-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Lesson"><i class="fa-solid fa-eye"></i></button> ';
                  var exam ='<button class="btn btn-info btn-sm view-quiz" data-bs-toggle="tooltip" data-bs-placement="top" title="View Quiz Details"><i class="fa-solid fa-list-check"></i></button> </div>';
                  return html+take+quiz+exam+'</div>';
          }
        }
      ],
      "columnDefs":[
       

      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });


    var activityTable= $('#activityTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "ordering":false,
      "searching": false,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/activity/get/"+sectionCode+"/"+subjectCode,
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
        { "data":"assesment_desc",
          "render":function(data, type, row, meta ){
            console.log(row);
            var quizType ='';
            var disabled="";
            var status='';
            var takingStatus='';
            if(row.isTaken){
               disabled ="disabled";
               takingStatus='<span class="badge text-bg-success">DONE</span> ';
            }else{
               takingStatus='<span class="badge text-bg-warning">Ready to Take</span> ';

            }

            if(row.status="ACTIVE")
              status ='<span class="badge text-bg-primary">'+row.status+'</span> ';
            else
              status ='<span class="badge text-bg-danger">'+row.status+'</span> ';
            
            if(row.test_type == "multiple"){
              quizType='<span class="badge text-bg-primary">Multiple Choice</span>';
            }else if(row.test_type == "identify"){
              quizType='<span class="badge text-bg-primary">Identification</span>';
            }

            

                  var html ='<div class="row"><div class="col-9"><i class="fa-solid fa-pencil"></i> '+data+'<br> '+status+takingStatus+quizType+' <div style="font-size:9px;margin-left:0px;"><strong>Created Date:</strong> '+moment(row.created_at).format('MMM-DD-YYYY h:mm A')+' <strong>End Date:</strong> '+moment(row.deadline).format('MMM-DD-YYYY h:mm A')+'</div></div><div class="col-3 text-end">';
                  var take ='<button '+disabled+' class="btn btn-success btn-sm take-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take the Quiz"><i class="fa-solid fa-square-pen"></i></button> ';
                  var quiz ='<button class="btn btn-warning btn-sm quiz-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Lesson"><i class="fa-solid fa-eye"></i></button> ';
                  var exam ='<button class="btn btn-info btn-sm view-quiz" data-bs-toggle="tooltip" data-bs-placement="top" title="View Quiz Details"><i class="fa-solid fa-list-check"></i></button> </div>';
                  return html+take+quiz+exam+'</div>';
          }
        }
      ],
      "columnDefs":[
       

      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

    $('#quarter').on('change', function(){
      currentQuarter=$(this).val();
      studentLesson.ajax.reload();
      quizTable.ajax.reload();

    });
    
    var options = {
                  chart: {
                    type: 'donut'
                  },
                  series: [0,0],
                  labels: ['Correct Answer','Wrong Answer'],
                  colors:['#198754', '#dc3545'],
                  noData: {
                      text: 'Loading...'
                    },
                  plotOptions: {
                    pie: {
                      donut: {
                        labels: {
                          show: true,
                          name: {
                            
                          },
                          value: {
                            show:false
                          },
                          total:{
                            show:true,
                            showAlways:true,
                            label:"Total Score ",
                          }
                        }
                      }
                    }
                  }
            };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    
    chart.render();
    // const picker= new datetimepicker(document.getElementById('endDate'));
    // picker.dates.formatInput = date => moment(date).format('YYYY-MM-DD hh:mm A');

   
    $('#quizTable tbody').on('click', '.take-btn', function(){
      var data = quizTable.row($(this).parents('tr')).data();
      console.log(data);
     
      swal.fire({
        icon:'warning',
        title: 'Are you ready to take this quiz?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        if (result.isConfirmed) {
          swal.close();
          if(data.test_type=="multiple"){
            window.location.href = "/assesment/multiple?assesmentId="+data.assesment_id;
          }else if(data.test_type=="identify"){
            window.location.href = "/assesment/identify?assesmentId="+data.assesment_id;
          }
        }
      });
    });

    $('#studentLesson tbody').on('click', '.download-btn', function(){
      var data = studentLesson.row($(this).parents('tr')).data();
     
      swal.fire({
        icon:'info',
        title: 'You are trying to download a lesson?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        if (result.isConfirmed) {
          swal.close();
          $.ajax({
            url:baseUrl+"/api/lesson/download/"+data.id,
            type:"GET",
            success:(res)=>{
              // console.log(res);
              if(res){
                // var blob = new Blob([res], { type: "application/octetstream"});
                // const url = window.URL.createObjectURL(res);
                console.log(res)
                a = document.createElement('a');
                a.href = res;
                // Give filename you wish to download
                a.download = data.lesson;
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();

               
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
        }
      });
    });

    $('#quizTable tbody').on('click', '.view-quiz', function(){
      var data = quizTable.row($(this).parents('tr')).data();
      console.log(data);
      var wrongAnswer = (parseInt(data.total_points)-parseInt(data.score));
      
      chart.updateOptions({
        series:[parseInt(data.score),wrongAnswer],
        plotOptions: {
                  pie: {
                    donut: {
                      labels: {
                        show: true,
                        name: {
                          fontSize: "30"
                        },
                        value: {
                          show:false
                        },
                        total:{
                          show:true,
                          showAlways:true,
                          fontSize: "30",
                          label:parseInt(data.score)+" Points",
                        }
                      }
                    }
                  }
                }
      });
    });

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

    $("#addLessonBtn").click(()=>{
      $("#addLessonModal").modal("show");
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

    $("#addLessonForm").submit((e)=>{
      e.preventDefault();
      var selectedSubject =$("#selectSubject").select2('data')[0];
      console.log(selectedSubject);
      var form = $("#addLessonForm");

      var formData = new FormData(form[0]);
      formData.append("subj_code", selectedSubject.id);
      formData.append("section_code", sectionCode);

      swal.fire({
        title: 'Do you want to save the Lesson?',
        showCancelButton: true,
        confirmButtonText: 'Save'
      }).then((result) => {
       
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/lesson/create",
            type:"POST",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data:formData,
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire('Saved!', '', 'success');
                swal.close();
                $("#addLessonModal").modal("hide");
                teacherLessonsTable.ajax.reload();
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



    $("#uploadQuizForm").submit((e)=>{
      e.preventDefault();
      var subjCode =$("#subject").data("subjectCode");
      var form = $("#uploadQuizForm");
      var formData = new FormData(form[0]);
      formData.append("subj_code", subjCode);
      formData.append("section_code", sectionCode);

      swal.fire({
        title: 'You are uploading new Quiz?',
        showCancelButton: true,
        confirmButtonText: 'Upload',
      }).then((result) => {
        if (result.isConfirmed) {
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

    

});
</script>
@endsection
