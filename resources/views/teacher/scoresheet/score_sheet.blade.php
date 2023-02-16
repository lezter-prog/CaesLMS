@extends('layouts.app')
@section('title', 'Quiz')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">This is a Score Sheet for Subject</h1>
  
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
  </div>
  
</div>
<div class="" style="padding:0px 10px">
    <div class="col-sm-12">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="quiz-tab" data-bs-toggle="tab" data-bs-target="#quiz" type="button" role="tab" aria-controls="quiz" aria-selected="true">Quiz</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="true">Activity</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="exam-tab" data-bs-toggle="tab" data-bs-target="#exam" type="button" role="tab" aria-controls="exam" aria-selected="true">Exam</button>
        </li>
      </ul>
  
      <div class="tab-content" id="SubjectTabContent">
        
        <div class="tab-pane fade show active" id="quiz" role="tabpanel" aria-labelledby="quiz-tab">
          <div class="row">
            <div class="col-lg-12 col-sm-12 pe-3">
              <table id ="quizTable"  class="table table-striped" style="width:100%;box-shadow: #4c4c4c 0px 4px 12px">
                
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
  </div>


 
<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};
  

  $(document).ready(function(){
   var sectionCode={{ Js::from($sectionCode) }}
   var currentQuarter =$("#quarter").val();
   var columns=null;
   var quizTable= null;
   var activityTable= null;
   var examTable= null;
   
   Swal.fire({
    title: 'Gathering Data...',
    html: 'Please wait...',
    allowEscapeKey: false,
    allowOutsideClick: false,
    didOpen: () => {
        Swal.showLoading();
        loadData(sectionCode,"quiz",quarter);
        loadData(sectionCode,"activity",quarter);
        loadData(sectionCode,"exam",quarter);
    }
    });
   
   
    $('#quarter').on('change', function(){
      currentQuarter=$(this).val();
      quizTable.ajax.reload();
    });

    function loadData(sectionCode,assessmentType,quarter){


        $.ajax({
        url:baseUrl+"/api/assessement/scoresheet/header",
        type:"GET",
        data:{
            "quarter":currentQuarter,
            "assessmentType":assessmentType,
            "sectionCode":sectionCode               
        },
        success:(res)=>{
            columns =res;
            Swal.close();
            switch(assessmentType){
                case "quiz":
                    quizTable =$('#quizTable').DataTable({
                        "bPaginate": false,
                        "bLengthChange": false,
                        "bFilter": true,
                        "bInfo": false,
                        "bAutoWidth": false,
                        "sAjaxSource": baseUrl+"/api/assessement/scoresheet",
                        "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
                            console.log("ajaxSRC: "+sSource);
                            oSettings.jqXHR = 
                            $.ajax({
                                "dataType": 'json',
                                "type": "GET",
                                "url": sSource,
                                "data":{
                                "quarter":currentQuarter,
                                "assessmentType":assessmentType,
                                "sectionCode":sectionCode
                                },
                                "beforeSend": function (request) {
                                request.setRequestHeader("Authorization", "Bearer "+token);
                                },
                                "success": fnCallback
                            });
                            },
                        "columns":columns,
                        "columnDefs":[
                            {
                                targets:0,
                                width:"50%"
                            },
                            {
                                targets:'_all',
                                width:"10%",
                            }
                        ],
                        "fnDrawCallback": function() {
                                $('[data-bs-toggle="tooltip"]').tooltip();

                            },
                        });
                    break;

                case "activity":

                activityTable =$('#activityTable').DataTable({
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "sAjaxSource": baseUrl+"/api/assessement/scoresheet",
                    "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
                        console.log("ajaxSRC: "+sSource);
                        oSettings.jqXHR = 
                        $.ajax({
                            "dataType": 'json',
                            "type": "GET",
                            "url": sSource,
                            "data":{
                            "quarter":currentQuarter,
                            "assessmentType":assessmentType,
                            "sectionCode":sectionCode
                            },
                            "beforeSend": function (request) {
                            request.setRequestHeader("Authorization", "Bearer "+token);
                            },
                            "success": fnCallback
                        });
                        },
                    "columns":columns,
                    "columnDefs":[
                        {
                            targets:0,
                            width:"50%"
                        },
                        {
                            targets:'_all',
                            width:"10%",
                        }
                    ],
                    "fnDrawCallback": function() {
                            $('[data-bs-toggle="tooltip"]').tooltip();

                        },
                    });
                break;
                case "exam":
                examTable =$('#examTable').DataTable({
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "sAjaxSource": baseUrl+"/api/assessement/scoresheet",
                    "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
                        console.log("ajaxSRC: "+sSource);
                        oSettings.jqXHR = 
                        $.ajax({
                            "dataType": 'json',
                            "type": "GET",
                            "url": sSource,
                            "data":{
                            "quarter":currentQuarter,
                            "assessmentType":assessmentType,
                            "sectionCode":sectionCode
                            },
                            "beforeSend": function (request) {
                            request.setRequestHeader("Authorization", "Bearer "+token);
                            },
                            "success": fnCallback
                        });
                        },
                    "columns":columns,
                    "columnDefs":[
                        {
                            targets:0,
                            width:"50%"
                        },
                        {
                            targets:'_all',
                            width:"10%",
                        }
                    ],
                    "fnDrawCallback": function() {
                            $('[data-bs-toggle="tooltip"]').tooltip();

                        },
                    });
                break;

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
    });
    }
    

});
</script>
@endsection
