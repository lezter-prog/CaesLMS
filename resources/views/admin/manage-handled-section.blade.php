@extends('layouts.app')
@section('title', 'Teacher')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Handled Section By {{ $teacherName}}</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <button type="button" id ="addTeacherSection" class="btn btn-sm btn-outline-primary">Add</button>
      {{-- <button type="button" id="updateTeacherBtn" class="btn btn-sm btn-outline-primary">Edit</button> --}}
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="sectionsTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Section Code</th>
            <th>Section Description</th>
            <th></th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>

  <div class="modal fade" id="viewSubjectsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Handled Subjects</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addTeacherForm">
        <div class="modal-body">
          <div class="row g-3" >
            <div class="col-8" style="padding-bottom:10px">
              <input type="text" class="form-control" id="teacherName" placeholder="fullName" aria-label="First name" value="{{ $teacherName}}" readonly>
            </div>
            <div class="col-8">
              <input type="text" class="form-control" id="sectionDesc" placeholder="Section" aria-label="Last name" readonly>
            </div>
          </div>
          <div class="row" style="padding-bottom:10px">
            <div class="col-12">
              <table id ="subjectsTable"  class="table table-striped" style="width:100%">
                <thead>
                   <tr>
                      <th>
                        <div class="form-check" style="min-height: 0.44rem;">
                          <input class="form-check-input" type="checkbox" value="" id="allsubject">
                          <label class="form-check-label" for="flexCheckDefault">
                            All
                          </label>
                        </div>
                      </th>
                      <th>Subject Code</th>
                      <th>Subject Desc</th>
                      <th>Grade Code</th>
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
  <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Teacher Section</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addSectionForm">
        <div class="modal-body">
          
          <div class="row" style="padding-bottom:10px">
            <div class="col-8">
              <select type="text" class="form-control" id="sectionCode" >
                {{-- @foreach ($sections as $section)
                <option value="{{ $section->s_code }}">{{ $section->s_desc}}</option>
                @endforeach --}}
              </select>            
            </div>
          </div>
          <div class="row" style="padding-bottom:10px">
            <div class="col-12">
              <table id ="addSubjectsTable"  class="table table-striped" style="width:100%">
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


<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};
  console.log(token);

$(document).ready(function(){
    var gradeCode =[''];
    var selectAllSubject =false;
    var teacherId ={{ Js::from($teacherId) }};
    var subjectsTable = $('#subjectsTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "ordering": false,
      "sAjaxSource": baseUrl+"/api/teacher/handled/subjects",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
              gradeCode:gradeCode,
              teacherId:teacherId
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"status",
            "render":function(data,type,row,meta){
                console.log(data);
                    console.log(meta.row);
                    if(data=="selected"){
                        subjectsTable.row(meta.row).select();
                    }
                    return "";
                }
        
        },
        {"data":"subj_code" },
        {"data":"subj_desc"},
        {"data":"g_code"},
        // {"data":"g_code",
        //   "render":function(row,settings,data){
        //     var select ='<select id="'+data.subj_code+'" class="form-select">';
        //     var options =$("#sectionCode").select2('data');
        //       console.log(options);
        //       for(option of options){
        //         select=select+'<option value="'+option.id+'">'+option.s_desc+'</option>';
        //       }
        //       select=select+'</select>'
        //       return select;
        //   }
        // }
        
      ],
      columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]]
    });

    var addSubjectsTable = $('#addSubjectsTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "ordering": false,
      "sAjaxSource": baseUrl+"/api/teacher/handled/subjects",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
        console.log(teacherId);
        console.log(gradeCode);
          oSettings.jqXHR = 
          $.ajax({
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
              gradeCode:gradeCode,
              teacherId:teacherId
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"status",
          "render":function(data,type,row,meta){
                // console.log(meta.row);
                // if(data=="selected"){
                //   updateSubjectsTable.row(meta.row).select();
                // }
                  return "";
              }
        },
        {"data":"subj_code" },
        {"data":"subj_desc"},
        {"data":"g_code"},
        // {"data":"g_code",
        //   "render":function(data,settings,row){
        //     var selected ="";
        //     var select ='<select id="'+row.subj_code+'" class="form-select">';
        //     var options =$("#updateSectionCode").select2('data');
        //       console.log(options)
        //       console.log(row)
        //       for(option of options){
        //          if(option.g_code=data){
        //           selected=option.id;
        //           select=select+'<option value="'+option.id+'">'+option.s_desc+'</option>';
        //         }
        //       }
        //       select=select+'</select>'
        //       return select;
        //   }
  
        // }
        
      ],
      columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]]
    });

    var sectionsTable = $('#sectionsTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/teacher/handled/sections",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
                "teacherId":teacherId
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"s_code"},
        {"data":"s_desc" },
        {"data":"s_code",
            "render":function(data,settings,row){
                return '<button role="button" id="handledSections" class="btn btn-primary btn-sm">View Handled Subjects</button>'

            }
        }
      ]
    });

    $("#allsubject").on('click',function(){
      if($(this).is(':checked')){
        selectAllSubject =true;
        subjectsTable.rows().select();   
      }else{
        selectAllSubject =false;
        subjectsTable.rows().deselect();   
      }
    });

    $("#update_allsubject").on('click',function(){
      if($(this).is(':checked')){
        selectAllSubject =true;
        updateSubjectsTable.rows().select();   
      }else{
        selectAllSubject =false;
        updateSubjectsTable.rows().deselect();   
      }
    })

    // select row
    $('#sectionsTable tbody').on( 'click', 'tr', function () {   
      console.log($(this).hasClass('selected'));         
        if ( $(this).hasClass('selected') ) { 
            $(this).removeClass('selected'); 
            
        } 
        else {                 
            sectionsTable.$('tr.selected').removeClass('selected'); 
            console.log($(this).text());
            $(this).addClass('selected');   
            var data = sectionsTable.row( ".selected" ).data();
            console.log(data); 
        }  

      });

// Open Add Modal
    $("#addTeacherSection").click(()=>{
      $("#addSectionModal").modal("show");
    });

    $('#sectionsTable tbody').on( 'click','#handledSections',(event)=>{
        event.preventDefault();
        console.log($(this).closest('tr'));
        var data = sectionsTable.row().data();
        console.log(data);
        $("#sectionDesc").val(data.s_desc);
        gradeCode.push(data.g_code);
        subjectsTable.ajax.reload();
        $("#viewSubjectsModal").modal("show");
    })

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
      var arrayData=[];
      var s_code="";
      // var api =subjectsTable.api();
        subjectsTable
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
    //  console.log(JSON.stringify(subjects));
      console.log(arrayData);
      console.log($("#sectionCode").val());
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
              "subjects":JSON.stringify(arrayData),
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

  $("#sectionCode").select2({
      dropdownParent: $('#addSectionModal'),
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
        gradeCode=[''];
        gradeCode.push(data.g_code);
        addSubjectsTable.ajax.reload();
    });
    $('#updateSectionCode').on('select2:select', function (e) {
        var data = e.params.data;
        console.log("Selected Section: "+data.g_code);
        if(!gradeCode.includes(data.g_code)){
          gradeCode.push(data.g_code)
        }else{
            gradeCode =[''];
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
