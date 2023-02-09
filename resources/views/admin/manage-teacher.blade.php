@extends('layouts.app')
@section('title', 'Teacher')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Teachers</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <button type="button" id ="addTeacherBtn" class="btn btn-sm btn-outline-primary">Add</button>
      <button type="button" id="updateTeacherBtn" class="btn btn-sm btn-outline-primary">Edit</button>
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
            <th>Teacher</th>
            <th>School Year</th>
            <th>Status</th>
            <th></th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>



  <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Teacher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addTeacherForm">
        <div class="modal-body">
          <div class="row g-3" style="padding-bottom:10px">
            <div class="col-6" style="padding-right:10px">
              <input type="text" class="form-control" id="teacherFirstName" placeholder="First name" aria-label="First name">
            </div>
            <div class="col-6">
              <input type="text" class="form-control" id="teacherLastName"placeholder="Last name" aria-label="Last name">
            </div>
          </div>
          {{-- <div class="row" style="padding-bottom:10px">
            <div class="col-12">
              <select type="text" class="form-control" id="sectionCode" multiple="multiple" >
                
              </select>            
            </div>
          </div> --}}
          
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="updateTeacherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Teacher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateTeacherForm">
        <div class="modal-body">
          <div class="row g-3" style="padding-bottom:10px">
            <div class="col-4" style="padding-right:10px">
              <input type="text" class="form-control" id="updateTeacherFirstName" placeholder="First name" aria-label="First name">
            </div>
            <div class="col-4">
              <input type="text" class="form-control" id="updateTeacherLastName"placeholder="Last name" aria-label="Last name">
            </div>
            
          </div>
          <div class="row" style="padding-bottom:10px">
            <div class="col-8">
              <select type="text" class="form-control" id="updateSectionCode" multiple="multiple" >
                {{-- @foreach ($sections as $section)
                <option value="{{ $section->s_code }}">{{ $section->s_desc}}</option>
                @endforeach --}}
              </select>            
            </div>
          </div>
          <div class="row" style="padding-bottom:10px">
            <div class="col-12">
              <table id ="updateSubjectsTable"  class="table table-striped" style="width:100%">
                <thead>
                   <tr>
                      <th>
                        <div class="form-check" style="min-height: 0.44rem;">
                          <input class="form-check-input" type="checkbox" value="" id="update_allsubject">
                          <label class="form-check-label" for="flexCheckDefault">
                            All
                          </label>
                        </div>
                      </th>
                      <th>Subject Code</th>
                      <th>Subject Desc</th>
                      <th>Grade Code</th>
                      <th>Select Section</th>
                  </tr>
                </thead>
                <tbody>
                 
                </tbody>
            
          
              </table>
            </div>
          
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

  <div class="modal fade" id="generatedPwModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Student Generated Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addStudentForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="first_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="fullname" readonly>
          </div>
          <div class="mb-3">
            <label for="first_name" class="form-label">Generated Password</label>
            <input type="text" class="form-control" id="generatedPassword" readonly>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <!--<button type="submit" class="btn btn-primary">Save changes</button>-->
        </div>
        </form>
      </div>
    </div>
  </div>


<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};
  console.log(token);

$(document).ready(function(){
    var gradeCode =[];
    var selectAllSubject =false;
    var teaceherId ="";
   

    var teachersTable = $('#teachersTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/teacher/get",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"name"},
        {"data":"sy" },
        {"data":"status"},
        {"data":"user_id",
          "render":function(data,settings,row){
              var handled= '<a href="/admin/handled/sections?teacherId='+data+'&name='+row.name+'" role="button" id="handledSections" class="btn btn-info btn-sm">Handled Sections</a>'
              var generate =' <button class="generate btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Generate New Password" data-id="'+data.user_id+'"><i class="fa-solid fa-rotate"></i></button>';
              var viewCurrent ='';
              if(row.isGeneratedPassword){
                var viewCurrent =' <button class="showpass btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="View Generate Password" data-id="'+data.user_id+'"><i class="fa-solid fa-eye"></i></button>';
              }
              return handled+generate+viewCurrent;
          }
        }],
        "columnDefs":[
          {
              "target":3,
              "className":"text-center"
          }
        ]
    });

  $("#teachersTable tbody").on('click','.showpass', function(){
      var data = teachersTable.row($(this).parents('tr')).data();
      console.log(data);

      $("#fullname").val(data.first_name+" "+data.last_name);
      $("#generatedPassword").val(data.value);
      $("#generatedPwModal").modal('show');

  });

  $("#teachersTable tbody").on('click','.generate', function(){
    var data = teachersTable.row($(this).parents('tr')).data();
    console.log(data);

    swal.fire({
        title: 'You will be Generating password for selected Teacher?',
        showCancelButton: true,
        confirmButtonText: 'Contine'
      }).then((result) => {
        if (result.isConfirmed) {
          swal.showLoading();
          $.ajax({
            url:baseUrl+"/api/generate/password",
            type:"POST",
            data:{
              "userId":data.user_id
            },
            success:(res)=>{
              console.log(res);
              if(res.result){  
                swal.fire({
                  icon:'success',
                  title: data.first_name+" "+data.last_name+"'s Generated password is: "+res.value,
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  studentsTable.ajax.reload();
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
  });

    // select row
    $('#teachersTable tbody').on( 'click', 'tr', function () {   
      console.log($(this).hasClass('selected'));         
        if ( $(this).hasClass('selected') ) { 
            $(this).removeClass('selected'); 
        }else {                 
        teachersTable.$('tr.selected').removeClass('selected'); 
          console.log($(this).text());
          $(this).addClass('selected');
        }  
      });

// Open Add Modal
    $("#addTeacherBtn").click(()=>{
      $("#sectionCode").select2('destroy');
      $("#sectionCode").select2().val("").trigger('change');
      $("#sectionCode").select2({
      dropdownParent: $('#addTeacherModal'),
      theme: 'bootstrap-5',
      delay: 250,
      placeholder: 'Select Section',
      ajax: {
        method:"GET",
        headers: {
          "Authorization" : "Bearer "+token
        },
        dataType: "json",
        url: baseUrl+'/api/section/get/select2',
        data: function (params) {
          console.log("select2 params:"+params.term);
          var query = {
            search: params.term
          }
          // Query parameters will be ?search=[term]&type=public
          return query;
        },
        processResults: function (data) {
          // data = JSON.parse(data);
          console.log("process result:"+data.results);
          return data;
        },
        minimumInputLength: 1,
          // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
      },
      templateResult: function(repo){
        console.log(repo);
        if (!repo.loading) {
          // return "<strong>"+repo.text+"</strong>-"+repo.g_desc;
          return $(repo.text);
        }
      },
      templateSelection: function(repo){
        console.log(repo);
        if (!repo.loading) {
          // return "<strong>"+repo.text+"</strong>-"+repo.g_desc;
          return $(repo.text);
        }
      }

    });
      $("#addTeacherModal").modal("show");
    });

// Open Update Modal
    $("#updateTeacherBtn").click(()=>{
      var data = teachersTable.row( ".selected" ).data();
      teaceherId=data.user_id;

      $("#updateTeacherFirstName").data("code",data.user_id);
      $("#updateTeacherFirstName").val(data.first_name);
      $("#updateTeacherLastName").val(data.last_name);

        var sections = [];
        var sectionCodes = [];
            gradeCode=[''];
          for(obj of data.sections){
            sections.push({
              id:obj.s_code,
              text:'<strong>'+obj.s_desc+'</strong> - <small>'+obj.grade_desc+'<small>',
              s_desc:obj.s_desc
            });
            sectionCodes.push(obj.s_code);
            console.log(obj);
            if(!gradeCode.includes(obj.g_code)){
              gradeCode.push(obj.g_code);
            }
          }
          console.log(sections);
          $('#updateSectionCode').select2('destroy');
          $("#updateSectionCode").select2({
              dropdownParent: $('#updateTeacherModal'),
              theme: 'bootstrap-5',
              delay: 250,
              placeholder: 'Select Section',
              data:sections,
              ajax: {
                method:"GET",
                headers: {
                  "Authorization" : "Bearer "+token
                },
                dataType: "json",
                url: baseUrl+'/api/section/get/select2',
                data: function (params) {
                  console.log("select2 params:"+params.term);
                  var query = {
                    search: params.term
                  }
                  // Query parameters will be ?search=[term]&type=public
                  return query;
                },
                processResults: function (data) {
                  // data = JSON.parse(data);
                  console.log("process result:"+data.results);
                  return data;
                },
                minimumInputLength: 1,
                
              
                  // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
              },
              templateResult: function(repo){
                console.log(repo);
                if (!repo.loading) {
                  // return "<strong>"+repo.text+"</strong>-"+repo.g_desc;
                  return $(repo.text);
                }
              },
              templateSelection: function(repo){
                console.log(repo);
                  return $(repo.text);
                
              }

          });

      

      if ($('#updateSectionCode').hasClass("select2-hidden-accessible")) {
        $("#updateSectionCode").val(sectionCodes).trigger("change.select2");
        $("#updateTeacherModal").modal("show");
      }
      
      updateSubjectsTable.ajax.reload();
      var tableCount=updateSubjectsTable.data().count();
      var rowsSelectedCount =updateSubjectsTable.rows('.selected').count();
      console.log("Count rows:"+rowsSelectedCount);
      if(tableCount==rowsSelectedCount){
        $("#update_allsubject").prop( "checked", true );
      }
    });


    $("#addTeacherForm").submit((e)=>{
      e.preventDefault();
     
      swal.fire({
        title: 'Do you want to save the Teacher?',
        showCancelButton: true,
        confirmButtonText: 'Save',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/teacher/create",
            type:"POST",
            data:{
              "first_name":$("#teacherFirstName").val(),
              "last_name":$("#teacherLastName").val(),
              "sy":"2022-2023"
            },
            success:(res)=>{
              console.log(res);
              if(res){
                teachersTable.ajax.reload();

                swal.fire({
                  icon:'success',
                  title: 'Saving Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                $("#addTeacherModal").modal("hide");
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

    });

    $("#updateTeacherForm").submit((e)=>{
      
      e.preventDefault();

      var code =$("#updateTeacherFirstName").data("code");
      var arrayData=[];
      var s_code="";
      updateSubjectsTable
        .rows({selected: true})
        .every(function(rowIdx,tableLoop,rowLoop){
          var data = this.data();
          console.log(this.row(rowIdx).column(4).nodes());
          $(this.row(rowIdx).column(4).nodes())
          .find("select#"+data.subj_code+".form-select").each( function () {
            // console.log("found"+$(this).val());
            s_code=$(this).val();
          });
          data.s_code=s_code;
          console.log(data);
          arrayData.push(data);
        });
      swal.fire({
        title: 'Do you want to update the Teacher?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/teacher/"+code+"/update",
            type:"patch",
            data:{
              "first_name":$("#updateTeacherFirstName").val(),
              "last_name":$("#updateTeacherLastName").val(),
              "subjects":JSON.stringify(arrayData)
            },
            success:(res)=>{
              console.log(res);
              res =JSON.parse(res);
              console.log(res);
              if(res){
                teachersTable.ajax.reload();
                swal.fire({
                  icon:'success',
                  title: 'Updating Success',
                  showCancelButton: false,
                  confirmButtonText: 'Ok',
                }).then((result) => {
                  swal.close();
                  $("#updateTeacherModal").modal("hide");
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
  });

  

    $("#updateSectionCode").select2({
      dropdownParent: $('#updateTeacherModal'),
      theme: 'bootstrap-5',
      delay: 250,
      placeholder: 'Select Section',
      ajax: {
        method:"GET",
        headers: {
          "Authorization" : "Bearer "+token
        },
        dataType: "json",
        url: baseUrl+'/api/section/get/select2',
        data: function (params) {
          console.log("select2 params:"+params.term);
          var query = {
            search: params.term
          }
          // Query parameters will be ?search=[term]&type=public
          return query;
        },
        processResults: function (data) {
          // data = JSON.parse(data);
          console.log("process result:"+data.results);
          return data;
        },
        minimumInputLength: 1,
        
       
          // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
      },
      templateResult: function(repo){
        console.log(repo);
        if (!repo.loading) {
          // return "<strong>"+repo.text+"</strong>-"+repo.g_desc;
          return $(repo.text);
        }
      },
      templateSelection: function(repo){
        console.log(repo);
        if (!repo.loading) {
          // return "<strong>"+repo.text+"</strong>-"+repo.g_desc;
          return $(repo.text);
        }
      }

    });

    $('#sectionCode').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("Selected Section: "+data.g_code);
        if(!gradeCode.includes(data.g_code)){
          gradeCode.push(data.g_code)
        } 
        subjectsTable.ajax.reload();
    });
    $('#updateSectionCode').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("Selected Section: "+data.g_code);
        if(!gradeCode.includes(data.g_code)){
          gradeCode.push(data.g_code)
        }
        console.log(gradeCode);
        updateSubjectsTable.ajax.reload();
    });
    $("#updateSectionCode").on('change',(event)=>{
     console.log($("#updateSectionCode").val());

     var data =$("#updateSectionCode").select2('data');
              console.log(data);
          if(data.length>0){
            for(obj of data){
              console.log(obj);
              if(!gradeCode.includes(obj.g_code)){
                gradeCode.push(obj.g_code)
              }
            }
          }else{
            gradeCode =[''];
          }
          updateSubjectsTable.ajax.reload();

    })

});
</script>
@endsection
