@extends('layouts.app')
@section('title', 'Student Profile')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Students Profile</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    
    <div class="btn-group me-2">
      <button type="button" id ="backButton" class="btn btn-sm btn-outline-primary">Back</button>
    </div>
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
                    <input id="birthdate" name="birthdate" value="{{ $profile->birthdate}}" type="text" class="form-control" data-td-target="#birthdate" required readonly>
                    <span class="input-group-text" data-td-target="#birthdate" data-td-toggle="datetimepicker">
                    <i class="fas fa-calendar"></i>
                    </span>
                </div>
            </div>
            <div class="col-4 pe-2">
                <label for="exampleInputEmail1" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" value="{{$profile->age}}" readonly>
            </div>
            <div class="col-4 pe-2">
                <label for="exampleInputEmail1" class="form-label">Contact No</label>
                <input type="number" class="form-control" id="number" name="contact_no" value="{{$profile->contact_no}}" readonly>
            </div>
        </div>
        <div class="row">
            
            <div class="col-12 pe-2">
                <label for="exampleInputEmail1" class="form-label">Current Address</label>
                <input type="text" class="form-control" id="currentAddress" name="address" value="{{$profile->address}}" readonly>
            </div>
            
        </div>
        <div class="row">
            
            <div class="col-8 pe-2 mb-3">
                <label for="exampleInputEmail1" class="form-label">Guardian 1</label>
                <input type="text" class="form-control" id="guardian" name="guardian" value="{{$profile->guardian}}" readonly>
            </div>
            <div class="col-4 pe-2">
                <label for="exampleInputEmail1" class="form-label">Contact No</label>
                <input type="number" class="form-control" id="guardian1_no" name="guardian_contact_no" value="{{$profile->guardian_contact_no}}" readonly>
            </div>
        </div>
        
      </form>
  </div>
</div>


<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};

$(document).ready(function(){
    var sectionCode ={{ Js::from($student->s_code) }};
    $("#backButton").on('click',function(){
        location.href="/admin/students";
    })
});
</script>
@endsection
