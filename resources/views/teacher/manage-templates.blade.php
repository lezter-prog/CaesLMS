@extends('layouts.app')
@section('title', 'Templates')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Templates of Quiz, Activity and Exam</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <select class="form-select js-data-example-ajax" id="quarter" aria-label="Default select example">
        @foreach ($quarters as $quarter)
        <option value="{{$quarter->quarter_code}}" @if ($quarter->status === 'ACTIVE') selected @endif >{{$quarter->quarter_desc}}</option>
        @endforeach
      </select>
    </div>
   
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div> 
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="templatesTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Template  Description</th>
            <th>File</th>
            <th></th>
            
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>



@endsection
