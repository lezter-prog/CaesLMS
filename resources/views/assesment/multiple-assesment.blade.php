
@extends('layouts.assesment')

@section('content')
{{-- <script>
  var invoke= (event) =>{
    let nameOfFunction = this[event.target.name];
    let arg1 = event.target.getAttribute('data-uestionId');
      alert(arg1);
    }
</script> --}}
<div class="row text-center">
  <h6>Calamba Adventist Elementary School</h6>
  <h6>Quiz1-Subject</h6>
  <h6>2022-2023</h6>
</div>
<form id="multipleAssesment">
  <div class="row text-start">
    <h6> <strong>I. Choose the letter of the correct answer</strong></h6>
  </div>
  @foreach ($assesmentDetails as $ass)
  <div class="row text-start">
    <h6>{{$ass->number}}. {{$ass->question}}</h6>
    <div class="col-6 " style="margin-left: 15px;" id="number{{$ass->number}}">
      <h6><input  type="radio" {{$ass->choiceAChecked}} name="question{{$ass->number}}" data-number="{{$ass->number}}"  value="{{$ass->choice_A}}" > <span class="pointer" id="choiceA" >A.</span>  {{$ass->choice_A}} </h6>
      <h6><input  type="radio" {{$ass->choiceBChecked}} name="question{{$ass->number}}" data-number="{{$ass->number}}"  value="{{$ass->choice_B}}" > <span class="pointer" id="choiceB" >B.</span>  {{$ass->choice_B}} </h6>
      <h6><input  type="radio" {{$ass->choiceCChecked}} name="question{{$ass->number}}" data-number="{{$ass->number}}"  value="{{$ass->choice_C}}" > <span class="pointer" id="choiceC" >C.</span>   {{$ass->choice_C}} </h6>
      <h6><input  type="radio" {{$ass->choiceDChecked}} name="question{{$ass->number}}" data-number="{{$ass->number}}"  value="{{$ass->choice_D}}" > <span class="pointer" id="choiceD" >D.</span>   {{$ass->choice_D}} </h6>
    </div>
  </div>
  @endforeach
  <div class="row">
    <div class="col-12 text-center">
      <button class="btn btn-primary btn-sm" type="submit">Submit</button>
    </div>
  </div>
</form>

@endsection

@section('script')
<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};
  var annotation =[];
  var numbers =[];
  // import { annotate } from 'https://unpkg.com/rough-notation?module';
  
 

  window.onbeforeunload = function(){
    alert('not allowed to leave');
    return false;
  };

  document.addEventListener("visibilitychange", function (event) {
    event.preventDefault();
      alert("not allowed");
      return false
});
  
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
  alert('not allowed');
});

document.onkeydown = function(e) { 
  if(event.keyCode == 123) { 
    alert('not allowed');
    return false; 
  } 
  } 

  $(document).ready(function(){
    var assesmentId ={{ Js::from($assesmentId) }};
    $('input').iCheck({
      handle: 'radio',
      radioClass: 'iradio_square-blue '
    });

    
    $('input').on('ifChecked', function(event){
      console.log($(this).val())
      console.log($(this).data('number'))
      
      $.ajax({
            url:baseUrl+"/api/quiz/save/temp",
            type:"POST",
            data:{
              "answer":$(this).val(),
              "number":$(this).data('number'),
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

    $("#multipleAssesment").submit(function(e){
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
                  location.href ="/student/handled/subject?subj_code=BIB1&&section_code=S1"
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


