@extends('layouts.app')

@section('content')
<div class="container pt-4">
    <div class="row">
        <div class="col-lg-10 col-sm-12" >
            <div class="card mb-3" style="max-width: 100%; height:100%">
                <div class="row g-0">
                  <div class="col-md-5 text-center">
                    <img src="../uploads/logo.png" class="img-fluid rounded-start"  alt="..." style="position: relative; width:80%; height:90%">
                    <div style="padding-left:10px">
                        <button id="editLogoBtn" class="btn btn-default btn-sm" style="float: right;margin-top: -20px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" >
                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                        </button>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card-body">
                      <h5 class="card-title"><strong >{{ $profile->school_name }} </strong></h5>
                      <p class="card-text">Located at {{ $profile->school_address }}</p>
                      <p class="card-text">School Year {{ $profile->school_year }}</p>

                      {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                      <div style="padding-left:10px">
                        <p class="card-text" style="margin-bottom: 0"><small class="text-muted">Last updated 3 mins ago</small></p> 
                        <button id="editProfileBtn" class="btn btn-default btn-sm" style="float: right;margin-top: -22px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-pen-to-square fa-lg"></i></button></div>
                        <hr>

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
          <div class="mb-3">
            <label for="schoolYear" class="form-label">School Year</label>
            <input type="text" class="form-control" id="schoolYear" value="{{ $profile->school_year}} ">
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
<admin-home></admin-home>
@endsection