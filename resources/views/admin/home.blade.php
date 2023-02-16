@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="container pt-4">
    <div class="row">
        <div class="col-lg-10 col-sm-12" >
            <div class="card mb-3" style="max-width: 100%; height:100%">
                <div class="row g-0">
                  <div class="col-md-5 text-center">
                    <img src="../uploads/logo.png" class="img-fluid rounded-start"  alt="..." style="position: relative; width:80%; height:90%">
                    <!--<div style="padding-left:10px">-->
                    <!--    <button id="editLogoBtn" class="btn btn-default btn-sm" style="float: right;margin-top: -20px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" >-->
                    <!--        <i class="fa-solid fa-pen-to-square fa-lg"></i>-->
                    <!--    </button>-->
                    <!--</div>-->
                  </div>
                  <div class="col-md-6">
                    <div class="card-body">
                      <h5 class="card-title"><strong >{{ $profile->school_name }} </strong></h5>
                      <p class="card-text">Located at {{ $profile->school_address }}</p>
                      <p class="card-text">School Year {{ $profile->school_year }}</p>
                      <p class="card-text">{{ $quarter->quarter_desc }}</p>

                      <div style="padding-left:10px">
                        <p class="card-text" style="margin-bottom: 0"><small class="text-muted"></small></p>
                        <button id="editProfileBtn" class="btn btn-default btn-sm" style="float: right;margin-top: -22px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square fa-lg"></i></button>
                      </div>
                      
                      <hr>
                    </div>
                    @if($quarter->quarter_code == "Q4")
                      @if($profile->isPreparing == 1)
                      <button id="viewPreparation" class="btn btn-info btn-sm" style="margin-left:12px" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square fa-lg"></i> View Preparation For Next School Year</button>
                      @else
                      <button id="prepare" class="btn btn-primary btn-sm" style="margin-left:12px" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square fa-lg"></i> Prepare for the next School Year</button>
                      @endif
                    @endif
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadLogoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload Logo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="uploadLogo">
        <div class="modal-body">
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload New Logo</label>
                <input class="form-control" type="file" id="formFile" name="file">
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="uploadLogo">
        <div class="modal-body">
          <div class="mb-3">
            <label for="schoolName" class="form-label">School Name</label>
            <input type="text" class="form-control" id="schoolName" value="{{ $profile->school_name }} ">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">School Address</label>
            <input type="text" class="form-control" id="address" value="{{ $profile->school_address}} ">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};

$(document).ready(function(){
  var schoolYear ={{ Js::from($profile->school_year) }};
  $("body").tooltip({ selector: '[data-bs-toggle=tooltip]' });
    $("#editLogoBtn").on('click',function(e){
       console.log($('#uploadLogoModal'));
        //    bootstrap.modal();
        $('#uploadLogoModal').modal("show");
    });
    $("#editProfileBtn").on('click',function(e){
       console.log($('#uploadLogoModal'));
        //    bootstrap.modal();
        $('#updateProfileModal').modal("show");
        $('#schoolName').val();
        $('#schoolAddress').val();
        $('#schoolYear').val();
    });
    $("#uploadLogo").submit( function(e){    
        e.preventDefault();
        // var form = this.form;
        var formData = new FormData();
        var imagefile = document.querySelector('#formFile');
        formData.append("file", imagefile.files[0]);
        axios({
            method: "post",
            url: "/api/profile/upload",
            data: formData,
            headers: { "Content-Type": "multipart/form-data" },
        }).then(function (response) {
                //handle success
                console.log(response);
                location.reload();
        }).catch(function (response) {
                //handle error
                console.log(response);
        });
        
    })

    $("#prepare").on('click', function(){
    swal.fire({
        title: 'You are Setting the System to prepare for next School?',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          swal.showLoading();
          $.ajax({
            url:baseUrl+"/api/prepare",
            type:"POST",
            data:{
              "school_year":schoolYear
            },
            success:(res)=>{
              console.log(res);
              if(res.result){  
                swal.fire({
                  icon:'success',
                  title: "The System is now Preparing for Next School Year",
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  location.reload();
                });
              }else{
                swal.fire({
                  icon:'error',
                  title: "error Preparation",
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  // location.reload();
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
       
      });
  });
    
})



    // particlesJS.load('particle-js', '../json/particles-config.json', function() {
    //     console.log('callback - particles.js config loaded');
    // });

    

   
    function tooltip(element){
        return new bootstrap.Tooltip(element, {
                boundary: document.body // or document.querySelector('#boundary')
            });
    }



    
</script>
@endsection