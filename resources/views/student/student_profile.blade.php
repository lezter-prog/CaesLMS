@extends('layouts.app')
@section('title', 'Student Profile')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Students Profile</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    
    {{-- <div class="btn-group me-2">
      <button type="button" id ="addAnnouncementBtn" class="btn btn-sm btn-outline-primary">Add</button>
      <button type="button" id="updateAnnouncementBtn"class="btn btn-sm btn-outline-primary">Edit</button>
    </div> --}}
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="row" style="padding:0px 10px">
  <div class="col-12 pe-2 ps-2">
    <form id="studentProfile">
        <div class="row">
            <div class="col-6 pe-2">
                <label for="exampleInputEmail1" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstname" value="{{$student->first_name}}" readonly>
            </div>
            <div class="col-6 pe-2">
                <label for="exampleInputEmail1" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" value="{{$student->last_name}}" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-4 pe-2">
                <label for="birthdate" class="form-label">Birth Date</label>
                <div class="input-group log-event" id="birthdate" data-td-target-input="nearest" data-td-target-toggle="nearest">
                    <input id="birthdate" name="birthdate" value="{{ $profile->birthdate}}" type="text" class="form-control" data-td-target="#birthdate" required>
                    <span class="input-group-text" data-td-target="#birthdate" data-td-toggle="datetimepicker">
                    <i class="fas fa-calendar"></i>
                    </span>
                </div>
            </div>
            <div class="col-4 pe-2">
                <label for="exampleInputEmail1" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" value="{{$profile->age}}">
            </div>
            <div class="col-4 pe-2">
                <label for="exampleInputEmail1" class="form-label">Contact No</label>
                <input type="number" class="form-control" id="number" name="contact_no" value="{{$profile->contact_no}}">
            </div>
        </div>
        <div class="row">
            
            <div class="col-12 pe-2">
                <label for="exampleInputEmail1" class="form-label">Current Address</label>
                <input type="text" class="form-control" id="currentAddress" name="address" value="{{$profile->address}}">
            </div>
            
        </div>
        <div class="row">
            
            <div class="col-8 pe-2 mb-3">
                <label for="exampleInputEmail1" class="form-label">Guardian 1</label>
                <input type="text" class="form-control" id="guardian" name="guardian" value="{{$profile->guardian}}">
            </div>
            <div class="col-4 pe-2">
                <label for="exampleInputEmail1" class="form-label">Contact No</label>
                <input type="number" class="form-control" id="guardian1_no" name="guardian_contact_no" value="{{$profile->guardian_contact_no}}">
            </div>
            
        </div>
        <div class="row pe-2 mb-3">
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Save Changes </button>
            </div>
        </div>
        
      </form>
  </div>
</div>


  <!-- UpdateModal -->
  <div class="modal fade" id="updateAnnouncementModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Annoucement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateAnnouncementForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="announcementName" class="form-label">Announcement Description</label>
            <textarea type="text" class="form-control" rows="4" cols="50" id="updateAnnouncement" required > </textarea>
            {{-- <div id="emailHelp" class="form-text">We'll never share your ema il with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="grade" class="form-label">Announcement For:</label>
            <select type="text" class="form-control" id="updateAnnouncementFor" required>
              <option value="Student">Student</option>
          
            </select>
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
<!-- addModal -->
  <div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Annoucement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addAnnouncementForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="announcementName" class="form-label">Announcement Description</label>
            <textarea type="text" class="form-control" rows="4" cols="50" id="announcement" required > </textarea>
            {{-- <div id="emailHelp" class="form-text">We'll never share your ema il with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="grade" class="form-label">Announcement For:</label>
            <select type="text" class="form-control" id="announcementFor" required>
              <option value="Student">Student</option>
          
            </select>
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
    tempusDominus.extend(window.tempusDominus.plugins.customDateFormat);
    const picker= new tempusDominus.TempusDominus(document.getElementById('birthdate'),{
        display: {
        components: {
            clock: false
        }
    },
    localization: {
        format: 'yyyy-MM-dd'
      }
    });
    picker.dates.formatInput = date => moment(date).format('YYYY-MM-DD');
  
    $("#studentProfile").submit(function(e){
        e.preventDefault();
        var form = $("#studentProfile");
        var formData = new FormData(form[0]);

    swal.fire({
        title: 'Are you sure you want to update your profile?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then((result) => {
        if (result.isConfirmed) {
          swal.showLoading();

          $.ajax({
            url:baseUrl+"/api/student/profile",
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
                  title: 'Updating Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  location.reload();
                });
              }else{
                swal.fire({
                  icon:'error',
                  title: res.message,
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
    })
});
</script>
@endsection
