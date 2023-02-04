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
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="exam-tab" data-bs-toggle="tab" data-bs-target="#exam" type="button" role="tab" aria-controls="exam" aria-selected="true">Exam</button>
      </li>
    </ul>

    <div class="tab-content" id="SubjectTabContent">
      <div class="tab-pane fade show active pt-10" id="lessons" role="tabpanel" aria-labelledby="lessons-tab" style="padding-top: 20px;">
        <div class="row">
            <div class="col-12 pe-3">
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
            {{-- <div class="col-6">
              <div class="card mt-6" style="margin-top:6px;box-shadow: #4c4c4c 0px 4px 12px">
                <div class="card-header " style="background-color: #516a8a; color:white">
                  Details
                </div>
                <div class="card-body">
                  <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
              </div>
            </div> --}}
        </div>
      </div>
      <div class="tab-pane fade" id="quiz" role="tabpanel" aria-labelledby="quiz-tab">
        <div class="row">
          <div class="col-lg-12 col-sm-12 pe-3">
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
          {{-- <div class="col-lg-6 col-sm-12">
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
          </div> --}}
      </div>
    </div>
    <div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
      <div class="row">
        <div class="col-lg-12 col-sm-12 pe-3">
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
        {{-- <div class="col-lg-6 col-sm-12">
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
        </div> --}}
    </div>
  </div>
  <div class="tab-pane fade" id="exam" role="tabpanel" aria-labelledby="exam-tab">
    <div class="row">
      <div class="col-lg-12 col-sm-12 pe-3">
        <table id ="examTable"  class="table table-striped" style="width:100%;box-shadow: #4c4c4c 0px 4px 12px">
          <thead>
            <tr>
                <th>Exams</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>
      </div>
  </div>
</div>

  </div>
</div>

{{-- Modals --}}

<div class="modal fade" id="scoreChartModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="scoreChartTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col-12 text-center" id="scoreChart">
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



 

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
                  
                  var exam ='<button class="btn btn-info btn-sm exam-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="See Lesson Details"><i class="fa-solid fa-list-check"></i></button> </div>';
                  return html+lesson+exam+'</div>';
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
               takingStatus='<span class="badge bg-success st-badge">DONE</span> ';
            }else if(row.studentStatus=='in-progress'){
               takingStatus='<span class="badge bg-info st-badge">In Progress</span> ';
            }else{
              takingStatus='<span class="badge bg-warning st-badge">Ready to Take</span> ';

            }

            if(row.status=="ACTIVE")
              status ='<span class="badge bg-primary st-badge">'+row.status+'</span> ';
            else{
              status ='<span class="badge bg-danger st-badge">'+row.status+'</span> ';
              disabled ="disabled";
            }
            
            if(row.test_type == "multiple"){
              quizType='<span class="badge bg-primary st-badge">Multiple Choice</span>';
            }else if(row.test_type == "identify"){
              quizType='<span class="badge bg-primary st-badge">Identification</span>';
            }else if(row.test_type == "enumerate"){
              quizType='<span class="badge bg-primary st-badge">Enumeration</span>';
            }

            

                  var html ='<div class="row"><div class="col-9"><i class="fa-solid fa-pencil"></i> '+data+'<br> '+status+takingStatus+quizType+' <div style="font-size:9px;margin-left:0px;"><strong>Created Date:</strong> '+moment(row.created_at).format('MMM-DD-YYYY h:mm A')+' <strong>End Date:</strong> '+moment(row.deadline).format('MMM-DD-YYYY h:mm A')+'</div></div><div class="col-3 text-end">';
                  var take ='<button '+disabled+' class="btn btn-success btn-sm take-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take the Quiz"><i class="fa-solid fa-square-pen"></i></button> ';
                  var exam ='<button class="btn btn-info btn-sm view-quiz" data-bs-toggle="tooltip" data-bs-placement="top" title="View Quiz Details"><i class="fa-solid fa-list-check"></i></button> </div>';
                  return html+take+exam+'</div>';
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
               takingStatus='<span class="badge bg-success st-badge">DONE</span> ';
            }else if(row.studentStatus=='in-progress'){
               takingStatus='<span class="badge bg-info st-badge">In Progress</span> ';
            }else{
              takingStatus='<span class="badge bg-warning st-badge">Ready to Take</span> ';

            }

            if(row.status="ACTIVE")
              status ='<span class="badge bg-primary st-badge">'+row.status+'</span> ';
            else
              status ='<span class="badge bg-danger st-badge">'+row.status+'</span> ';
            
            if(row.test_type == "multiple"){
              quizType='<span class="badge bg-primary st-badge">Multiple Choice</span>';
            }else if(row.test_type == "identify"){
              quizType='<span class="badge bg-primary st-badge">Identification</span>';
            }

            

                  var html ='<div class="row"><div class="col-9"><i class="fa-solid fa-pencil"></i> '+data+'<br> '+status+takingStatus+quizType+' <div style="font-size:9px;margin-left:0px;"><strong>Created Date:</strong> '+moment(row.created_at).format('MMM-DD-YYYY h:mm A')+' <strong>End Date:</strong> '+moment(row.deadline).format('MMM-DD-YYYY h:mm A')+'</div></div><div class="col-3 text-end">';
                  var take ='<button '+disabled+' class="btn btn-success btn-sm take-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take the Quiz"><i class="fa-solid fa-square-pen"></i></button> ';
                  var exam ='<button class="btn btn-info btn-sm view-quiz" data-bs-toggle="tooltip" data-bs-placement="top" title="View Quiz Details"><i class="fa-solid fa-list-check"></i></button> </div>';
                  return html+take+exam+'</div>';
          }
        }
      ],
      "columnDefs":[
       

      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });


    var examTable= $('#examTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "ordering":false,
      "searching": false,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/exam/get/"+sectionCode+"/"+subjectCode,
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
               takingStatus='<span class="badge bg-success st-badge">DONE</span> ';
            }else if(row.studentStatus=='in-progress'){
               takingStatus='<span class="badge bg-info st-badge">In Progress</span> ';
            }else{
              takingStatus='<span class="badge bg-warning st-badge">Ready to Take</span> ';

            }

            if(row.status="ACTIVE")
              status ='<span class="badge bg-primary st-badge">'+row.status+'</span> ';
            else
              status ='<span class="badge bg-danger st-badge">'+row.status+'</span> ';
            
            if(row.test_type == "multiple"){
              quizType='<span class="badge bg-primary st-badge">Multiple Choice</span>';
            }else if(row.test_type == "identify"){
              quizType='<span class="badge bg-primary st-badge">Identification</span>';
            }

            

                  var html ='<div class="row"><div class="col-9"><i class="fa-solid fa-pencil"></i> '+data+'<br> '+status+takingStatus+quizType+' <div style="font-size:9px;margin-left:0px;"><strong>Created Date:</strong> '+moment(row.created_at).format('MMM-DD-YYYY h:mm A')+' <strong>End Date:</strong> '+moment(row.deadline).format('MMM-DD-YYYY h:mm A')+'</div></div><div class="col-3 text-end">';
                  var take ='<button '+disabled+' class="btn btn-success btn-sm take-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take the Quiz"><i class="fa-solid fa-square-pen"></i></button> ';
                  var exam ='<button class="btn btn-info btn-sm view-exam" data-bs-toggle="tooltip" data-bs-placement="top" title="View Quiz Details"><i class="fa-solid fa-list-check"></i></button> </div>';
                  return html+take+exam+'</div>';
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
      examTable.ajax.reload();

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
                            show:false,
                            fontWeight:5
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

    var chart = new ApexCharts(document.querySelector("#scoreChart"), options);
    // var chartExams = new ApexCharts(document.querySelector("#chartExams"), options);
    
    chart.render();
    // chartExams.render();
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
          }else if(data.test_type=="enumerate"){
            window.location.href = "/assesment/enumeration?assesmentId="+data.assesment_id;
          }
        }
      });
    });

    $('#examTable tbody').on('click', '.take-btn', function(){
      var data = examTable.row($(this).parents('tr')).data();
      console.log(data);
     
      swal.fire({
        icon:'warning',
        title: 'Are you ready to take this exam?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        if (result.isConfirmed) {
          swal.close();

          if(data.test_type=="exam"){
            window.location.href = "/assesment/exam?assesmentId="+data.assesment_id;
          }
        }
      });
    });

    $('#activityTable tbody').on('click', '.take-btn', function(){
      var data = activityTable.row($(this).parents('tr')).data();
      console.log(data);
     
      swal.fire({
        icon:'warning',
        title: 'Are you ready to take this activity?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        if (result.isConfirmed) {
          swal.close();
          if(data.test_type=="multiple"){
            window.location.href = "/assesment/multiple?assesmentId="+data.assesment_id;
          }else if(data.test_type=="identify"){
            window.location.href = "/assesment/identify?assesmentId="+data.assesment_id;
          }else if(data.test_type=="enumerate"){
            window.location.href = "/assesment/enumeration?assesmentId="+data.assesment_id;
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
        showLoaderOnConfirm: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url:baseUrl+"/api/lesson/download/"+data.id,
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
                a.download = data.lesson;
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

    $('#quizTable tbody').on('click', '.view-quiz', function(){
      var data = quizTable.row($(this).parents('tr')).data();
      var wrongAnswer = (parseInt(data.total_points)-parseInt(data.score));
      
      chart.updateOptions({
        series:[parseInt(data.score),wrongAnswer],
        plotOptions: {
                  pie: {
                    donut: {
                      labels: {
                        show: true,
                        name: {
                          show:true,
                          fontSize: "30"
                        },
                        value: {
                          show:true,
                          offsetY: 1
                        },
                        total:{
                          show:true,
                          showAlways:true,
                          fontSize: "10px",
                          label:"Total Score",
                          formatter:function(w){
                            return parseInt(data.score);
                          }
                        }
                      }
                    }
                  }
                },
                  dataLabels: {
                  enabled: true,
                  formatter: function (val) {
                    var p ="."+val;
                    console.log(p);
                    return parseFloat(data.total_points)*parseFloat(p);
                  }
                }
      });
      $('#scoreChartTitle').text(data.assesment_desc);

      $('#scoreChartModal').modal('show');
    });

    $('#activityTable tbody').on('click', '.view-quiz', function(){
      var data = activityTable.row($(this).parents('tr')).data();
      var wrongAnswer = (parseInt(data.total_points)-parseInt(data.score));
      
      chart.updateOptions({
        series:[parseInt(data.score),wrongAnswer],
        plotOptions: {
                  pie: {
                    donut: {
                      labels: {
                        show: true,
                        name: {
                          show:true,
                          fontSize: "30"
                        },
                        value: {
                          show:true,
                          offsetY: 1
                        },
                        total:{
                          show:true,
                          showAlways:true,
                          fontSize: "10px",
                          label:"Total Score",
                          formatter:function(w){
                            return parseInt(data.score);
                          }
                        }
                      }
                    }
                  }
                },
                  dataLabels: {
                  enabled: true,
                  formatter: function (val) {
                    var p ="."+val;
                    console.log(p);
                    return parseFloat(data.total_points)*parseFloat(p);
                  }
                }
      });
      $('#scoreChartTitle').text(data.assesment_desc);

      $('#scoreChartModal').modal('show');
    });

    $('#examTable tbody').on('click', '.view-exam', function(){
      var data = examTable.row($(this).parents('tr')).data();
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
                          show:true,
                          fontSize: "30"
                        },
                        value: {
                          show:true,
                          offsetY: 10
                        },
                        total:{
                          show:true,
                          showAlways:true,
                          // fontSize: "1.050rem",
                          label:"Total Score",
                          formatter:function(w){
                            return parseInt(data.score);
                          }
                        }
                      }
                    }
                  }
                },
                  dataLabels: {
                  enabled: true,
                  formatter: function (val) {
                    var p ="."+val;
                    console.log(p);
                    return parseFloat(data.total_points)*parseFloat(p);
                  }
                }
      });

      $('#scoreChartTitle').text(data.assesment_desc);

      $('#scoreChartModal').modal('show');
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
