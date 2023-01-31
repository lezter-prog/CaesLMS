@extends('layouts.app')
@section('title', 'Quiz')
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
      <button type="button" id ="importBtn" class="btn btn-sm btn-outline-primary">Upload Quiz</button>
      @if($assessment->status =="CLOSED")
      <button type="button" id ="downloadScoreSheet" class="btn btn-sm btn-outline-primary">Download Score Sheet</button>
      @endif
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
    </button>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <span><span class="badge text-bg-success">Section</span> {{$assessment->s_desc}} </span> |
  <span> <span class="badge text-bg-success">Subject</span> {{$assessment->subj_desc}}</span> |
  <span> <span class="badge text-bg-{{$assessment->statusColor}}">{{$assessment->status}} </span> </span>

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
                  var score =' <span class="badge text-bg-primary">'+data+' pts</span> ';
                  if(data == ""){
                    score ='<span class="badge text-bg-warning"> Not yet taken</span>';
                  }
                    return score;
                  }

        },
        {"data":"status",
            "render":function(data, type, row, meta ){
                  var status ="";
                  
                    if(row.status == "ACTIVE"){
                      status =' <span class="badge text-bg-primary">'+row.status+'</span> ';
                    }
                    var view=' <button  class="btn btn-primary btn-sm view-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Answers"><i class="fa-solid fa-list-check"></i></button>'

                    if(row.score==""){
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
