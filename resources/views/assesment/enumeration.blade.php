
@extends('layouts.assesment')

@section('content')
{{-- <script>
  var invoke= (event) =>{
    let nameOfFunction = this[event.target.name];
    let arg1 = event.target.getAttribute('data-uestionId');
      alert(arg1);
    }
</script> --}}

@If($role =="R2")
<div class="row text-center">
  <h6 style="color: red">TEACHERS VIEW ------- NOT ALLOWED TO SUBMIT</h6>
</div>
@endIf
<div class="row text-center">
  <h6>Calamba Adventist Elementary School</h6>
  <h6>Quiz1-Subject</h6>
  <h6>2022-2023</h6>
</div>

<form id="enumerationAssesment" style="margin-top:10px">
  <div class="row text-start">
    <h6> <strong>I. Enumerate the anwer.</strong></h6>
  </div>
  @foreach ($assesmentDetails as $ass)
  <div class="row text-start pb-4">
    <h6>{{$ass->number}}. {{$ass->question}}</h6>

    
    <select class="form-control" name="number{{$ass->number}}" id="number{{$ass->number}}" data-number="{{$ass->number}}" multiple>
        @foreach ($ass->json_choices as $item)
        <option value="{{$item->value}}" {{$item->selected}}>{{$item->value}}</option>
        @endforeach
    </select>
    
    {{-- <div class="col-6 " style="margin-left: 15px;" id="number{{$ass->number}}">
     <input type="text" class="form-control input-sm" name="question{{$ass->number}}"  data-number="{{$ass->number}}" data-test-type="identify">
    </div> --}}
  </div>
  @endforeach
  <div class="row" style="margin-top:10px">
    <div class="col-12 text-center">
      <button class="btn btn-primary btn-sm"  @if($role=="R2") disabled @endIf type="submit">Submit</button>
    </div>
  </div>
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
    var role ={{ Js::from($role) }};
    $('select').select2({
      theme: 'bootstrap-5'
    });

    $('select').on('select2:select', function (e) {
        var currentAnswer =[];
        var data = $(this).select2('data');
        console.log(data);

        if(role=="R2"){
            return
        }
        data.forEach((d)=>{
            currentAnswer.push(d.id);
        });
        console.log($(this).data('number'));

        $.ajax({
            url:baseUrl+"/api/quiz/save/temp/enumerate",
            type:"POST",
            data:{
              "answer":currentAnswer,
              "number":$(this).data('number'),
              "testType":"enumerate",
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
    
    $('input').on('keyup', function(event){
      console.log($(this).val())
      console.log($(this).data('number'))
      
      
      
    });

    $("#enumerationAssesment").submit(function(e){
      e.preventDefault();

      if(role=="R2"){
          return
      }

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


