@extends('layouts.app')
@section('title', 'Change Password')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Change Password</h1>
 
</div>
<div class="" style="padding:0px 20px">
  <div class="col-6 ">
  <form id="passForm">
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Enter Old-Password</label>
    <input type="password" class="form-control" id="password" required>
  </div>
  <label for="exampleInputPassword1" class="form-label">Enter New Password</label>
  <div class="input-group mb-3">
    <input type="password" class="form-control" id="password1"  minlength="8" aria-describedby="basic-addon2" required>
    <div class="input-group-append">
      <button class="btn btn-outline-secondary"id="showPassword1" type="button">Show</button>
    </div>
  </div>
  <label for="exampleInputPassword1" class="form-label">Re-Enter New Password</label>
  <div class="input-group mb-3">
    <input type="password" class="form-control"id="password2" minlength="8" aria-describedby="basic-addon2" required>
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" id="showPassword2" type="button">Show</button>
    </div>
  </div>
  <button type="submit" class="btn btn-primary float-end" id="savePass">Change Password</button>
</form>
  </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"></form>

<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};

// sample
$(document).ready(function()  {

  $("#showPassword2").on('click', function(){
    console.log($("#password2").attr('type'));
    if($("#password2").attr('type')=="password"){
      $("#password2").attr("type","text");
      $(this).text("Hide");
    }else{
      $("#password2").attr("type","password");
      $(this).text("Show");
    }
    
  })
  $("#showPassword1").on('click', function(){
    console.log($("#password1").attr('type'));
    if($("#password1").attr('type')=="password"){
      $("#password1").attr("type","text");
      $(this).text("Hide");
    }else{
      $("#password1").attr("type","password");
      $(this).text("Show");
    }
    
  })
       

    $("#passForm").submit((e)=>{
        e.preventDefault();

        if ( $("#password1").val()!=$("#password2").val()) {
           swal.fire('Error!', 'Password not Match', 'error');
              return false;
        }
        else {
      swal.fire({
        title: 'Do you want to Change Password',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/user/update/password",
            type:"patch",
            data:{
              "newPassword":$("#password1").val(),
              "oldPassword":$("#password").val(),
               
            },
            success:(res)=>{
              console.log(res);
              if( typeof res.message === "undefined"){
                swal.fire({
                  icon:'success',
                  title: 'Change Password Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  $("#logout-form").submit()
                });


              }else{
                swal.fire({
                  icon:'error',
                  title: 'Change Password failed',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
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

        } 
    });
});





</script>
@endsection
