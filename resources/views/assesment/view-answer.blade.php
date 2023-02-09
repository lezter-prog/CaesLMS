
@extends('layouts.assesment')

@section('content')
{{-- <script>
  var invoke= (event) =>{
    let nameOfFunction = this[event.target.name];
    let arg1 = event.target.getAttribute('data-uestionId');
      alert(arg1);
    }
</script> --}}
<style>
  .wrong-answer{
    /* border-color: red; */
    background: #fd5d5d !important;
  }
  .right-answer{
    border-color: green;
    background: #0eb93f !important;
  }

</style>
<div class="row text-left">
  <h6>{{$assessmentDesc}}</h6>
  <h6>List of Answer</h6>
  <h6>By: {{$name}}</h6>
</div>
<form id="identicationAssesment" style="margin-top:10px">
  @foreach ($assesmentDetails as $ass)
  <div class="row text-start pb-4">
    <h6>{{$ass->number}}. {{$ass->question}}</h6>
    <div class="col-6 " style="margin-left: 15px;" id="number{{$ass->number}}">
      @if($testType != "enumerate")
        <input type="text" class="form-control input-sm {{ $ass->class }}" autocomplete="off" name="question{{$ass->number}}" value="{{$ass->answers}}" data-number="{{$ass->number}}" data-test-type="identify" readonly>
      @else
        <input type="text" class="form-control input-sm {{ $ass->class }}" autocomplete="off" name="question{{$ass->number}}" value="{{$ass->json_answer}}" data-number="{{$ass->number}}" data-test-type="identify" readonly>
      @endif
      </div>
  </div>
  @endforeach
  
</form>

@endsection

@section('script')
<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};
  var sectionCode ={{ Js::from($sectionCode) }};
  var subjCode ={{ Js::from($subjCode) }};

  var annotation =[];
  var numbers =[];
  // import { annotate } from 'https://unpkg.com/rough-notation?module';
  
 

//   window.onbeforeunload = function(){
//     alert('not allowed to leave');
//     return false;
//   };

//   document.addEventListener("visibilitychange", function (event) {
//     event.preventDefault();
//       alert("not allowed");
//       return false
// });
  
// document.addEventListener('contextmenu', function(e) {
//   e.preventDefault();
//   alert('not allowed');
// });

// document.onkeydown = function(e) { 
//   if(event.keyCode == 123) { 
//     alert('not allowed');
//     return false; 
//   } 
//   } 

  $(document).ready(function(){
    var assesmentId ={{ Js::from($assesmentId) }};
    $('input').on('keyup', function(event){
      console.log($(this).val())
      console.log($(this).data('number'))
      
      $.ajax({
            url:baseUrl+"/api/quiz/save/temp",
            type:"POST",
            data:{
              "answer":$(this).val(),
              "number":$(this).data('number'),
              "testType":$(this).data('test-type'),
              "assesmentId":assesmentId
            },
            success:(res)=>{
              console.log(res);
              if(res){

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
      
    });

    $("#identicationAssesment").submit(function(e){
      e.preventDefault();

      swal.fire({
        title: 'Are you sure?',
        text:'You will be submitting all your answers',
        showCancelButton: true,
        confirmButtonText: 'submit',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/quiz/submit/answer",
            type:"POST",
            data:{
              "assesmentId":assesmentId
            },
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire({
                  icon:'success',
                  title: 'Submission Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  location.href ="/student/handled/subject?subj_code="+subjCode+"&&section_code="+sectionCode;
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
    })
  
   
  })

  
</script>
@endsection


