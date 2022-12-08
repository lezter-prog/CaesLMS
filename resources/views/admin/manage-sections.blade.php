@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Sections</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    
    <div class="btn-group me-2">
        <select class="form-select" aria-label="Default select example">
            <option value="G1">Grade 1</option>
            <option value="G2">Grade 2</option>
            <option value="G3">Grade 3</option>
            <option value="G4">Grade 4</option>
            <option value="G5">Grade 5</option>
            <option value="G6">Grade 6</option>
          </select>
    </div>
    <div class="btn-group me-2">
      <button type="button" id ="addTeacherBtn" class="btn btn-sm btn-outline-primary">Add</button>
      <button type="button" class="btn btn-sm btn-outline-primary">Edit</button>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="teachersTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Section Code</th>
            <th>Section</th>
            <th>Grade Code</th>
            <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td>Tiger Nixon</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
        </tr>
        <tr>
            <td>Garrett Winters</td>
            <td>Accountant</td>
            <td>Tokyo</td>
            <td>63</td>
        </tr>
        <tr>
            <td>Ashton Cox</td>
            <td>Junior Technical Author</td>
            <td>San Francisco</td>
            <td>66</td>
        </tr>
        <tr>
            <td>Cedric Kelly</td>
            <td>Senior Javascript Developer</td>
            <td>Edinburgh</td>
            <td>22</td>
        </tr>
        <tr>
            <td>Airi Satou</td>
            <td>Accountant</td>
            <td>Tokyo</td>
            <td>33</td> 
        </tr>
      </tbody>
  

    </table>
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

  <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Teacher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="uploadLogo">
        <div class="modal-body">
          <div class="mb-3">
            <label for="teacherName" class="form-label">Teacher Name</label>
            <input type="text" class="form-control" id="teacherName" >
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Email</label>
            <input type="email" class="form-control" id="address">
          </div>
          <div class="mb-3">
            <label for="schoolYear" class="form-label">Select Grade</label>
            <select type="text" class="form-control" id="schoolYear">
              <option value="G1">Grade 1</option>
              <option value="G2">Grade 2</option>
              <option value="G3">Grade 3</option>
              <option value="G4">Grade 4</option>
              <option value="G5">Grade 5</option>
              <option value="G6">Grade 6</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="schoolYear" class="form-label">Select Section</label>
            <select type="text" class="form-control" id="schoolYear">
              <option value="G1">Section 1</option>
              <option value="G2">Section 2</option>
              <option value="G3">Section 3</option>
              <option value="G4">Section 4</option>
              <option value="G5">Section 5</option>
              <option value="G6">Section 6</option>
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
<admin-sections-js></admin-sections-js>
@endsection
