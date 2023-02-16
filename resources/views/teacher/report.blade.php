@extends('layouts.app')
@section('title', 'Reports')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Score Sheet Report</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <button type="button" id="generateBtn" class="btn btn-sm btn-outline-primary" data-target="#scoreSheetModal">Generate a Score Sheet Report</button>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY {{session('school_year')}}</b>
  </div>
  
</div> 


<div class="modal fade" id="scoreSheetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Generate Score Sheet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="scoreSheet">
        <div class="modal-body">

            <div class="mb-3">
                <label for="lesson" class="form-label">School Year</label>
                {{-- <input type="text" class="form-control" id="subject" name="subject" readonly> --}}
                <select type="text" class="form-control" id="schoolYear" name="school_year" >
                    <option  value="" selected disabled>Select School Year</option>
                  @foreach($schoolYears as $schoolYear)
                  <option  value="{{$schoolYear->sy}}">{{$schoolYear->sy}}</option>
                  @endforeach
                </select>
                {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
              </div>
            <div class="mb-3">
              <label for="section" class="form-label">Section</label>
              {{-- <input type="text" class="form-control" id="subject" name="subject" readonly> --}}
              <select type="text" class="form-control" id="section" name="section_code" >
               
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
            
            
            
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Generate</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};
 

  $(document).ready(function(){
    
    var schoolYear ={{ Js::from(session('school_year')) }};
    $("#generateBtn").on('click',function(){
    
        $("#scoreSheetModal").modal('show');
    });

    $("#schoolYear").on('change',function(){
        var sy = $(this).val();
        $("#subject").html('');
        $("#section").html('');
            $.ajax({
                  url:baseUrl+"/api/teacher/handled/section/subject",
                  type:"GET",
                  data:{
                    "schoolYear":sy
                  },
                  success:(res)=>{
                    console.log(res);
                    res.sections.forEach((data)=>{
                        console.log(data);
                        $("#section").append('<option value="'+data.section_code+'">'+data.s_desc+'</option>')
                    })
                    res.subjects.forEach((data)=>{
                        console.log(data);
                        $("#subject").append('<option value="'+data.subj_code+'">'+data.subj_desc+'</option>')
                    })

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
    })

    $("#scoreSheet").submit((e)=>{
      e.preventDefault();  
    //   var form = $("#scoreSheet");

    //   var formData = new FormData(form[0]);
      swal.fire({
        title: 'Do you want to Generate the ScoreSheet?',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                  url:baseUrl+"/api/generate/scoresheet",
                  type:"POST",
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
                  data:{
                    "schoolYear":$("#schoolYear").val(),
                    "subjectCode":$("#subject").val(),
                    "sectionCode":$("#section").val(),
                  },
                  success:(res)=>{
                    const url = window.URL.createObjectURL(res);
                    console.log(url);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = $('#schoolYear').val()+$('#section').val()+$('#subject').val()+"_ScoreSheet.xlsx";
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
         
        } else {
          swal.fire('Changes are not saved', '', 'info')
        }
      })

    });

  })
</script>
@endsection


