@extends('layouts.app')
@section('title', 'Announcement')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Announcement</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    
    <div class="btn-group me-2">
      <button type="button" id ="addAnnouncementBtn" class="btn btn-sm btn-outline-primary">Add</button>
      <button type="button" id="updateAnnouncementBtn"class="btn btn-sm btn-outline-primary">Edit</button>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="announcementTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Announcement For:</th>
            <th>Announcement Description</th>
            <th>Date</th>
            <th>Uploaded By:</th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
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
   var announcementId=null;
   var announcementTable= $('#announcementTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/announcement/get/student",
      "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
        console.log("ajaxSRC: "+sSource);
          oSettings.jqXHR = 
          $.ajax({
           
            "dataType": 'json',
            "type": "GET",
            "url": sSource,
            "data":{
            },
            "beforeSend": function (request) {
              request.setRequestHeader("Authorization", "Bearer "+token);
            },
            "success": fnCallback
          });
        },
      "columns":[
        { "data":"announcement_for"},
        { "data":"announcement_desc"},
        {"data":"status" },
        {
          "data":"status",
          "render": function ( data, type, row, meta ) {
            console.log(row);
              return '<button class="btn btn-success btn-sm section-subjects" data-bs-toggle="tooltip" data-bs-placement="top" title="Section Subjects"><i class="fa-solid fa-folder"></i></button>';
            }
         }
      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

    $('#sectionsTable tbody').on('click', '.section-subjects', function(){
      var data = sectionTable.row( $(this).closest('tr') ).data();
      sectionCode =data.s_code;
      $("#subjectSectionModal").modal("show");
    })

    $('#announcementTable tbody').on( 'click', 'tr', function () {   
      console.log($(this).hasClass('selected'));         
        if ( $(this).hasClass('selected') ) { 
            $(this).removeClass('selected'); 
        } 
        else {                 
          announcementTable.$('tr.selected').removeClass('selected'); 
            console.log($(this).text());
            $(this).addClass('selected');                
        }  

      });



    $("#addAnnouncementBtn").click(()=>{
      $("#addAnnouncementModal").modal("show");
    });
    
    $("#updateAnnouncementBtn").click(()=>{
      var data = announcementTable.row( ".selected" ).data();
      console.log(data);
      announcementId=data.id;
      
      $("#updateannouncementFor").val(data.announcement_for);
      $("#updateAnnouncement").val(data.announcement_desc);
    

      $("#updateAnnouncementModal").modal("show");
    });

    $("#addAnnouncementForm").submit((e)=>{
      e.preventDefault();
      swal.fire({
        title: 'Do you want to save the Announcement?',
        showCancelButton: true,
        confirmButtonText: 'Save',
      }).then((result) => {
       
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/announcement/create",
            type:"POST",
            data:{
              "announcement_desc":$("#announcement").val(),
              "announcement_for":$("#announcementFor").val(),
              "school_year":"2022-2023"
            },
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire('Saved!', '', 'success');
                swal.close();
                $("#addAnnouncementModal").modal("hide");
                announcementTable.ajax.reload();
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


    $("#updateAnnouncementForm").submit((e)=>{
      // var code =$("#updateAnnouncementName").data("code");

      e.preventDefault();
      swal.fire({
        title: 'Do you want to update the Section?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/announcement/update",
            type:"patch",
            data:{
              "announcement_desc":$("#updateAnnouncement").val(),
              "announcement_for":$("#updateAnnouncementFor").val(),
               "id":announcementId
            },
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire('Update!', '', 'success');
                swal.close();
                $("#updateAnnouncementModal").modal("hide");
                announcementTable.ajax.reload();
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

    

});
</script>
@endsection
