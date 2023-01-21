{{-- @extends('layouts.app')
@section('title', 'Icons')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Icons</h1>

  <div class="btn-group me-2">
    <button type="button" id ="addAnnouncementBtn" class="btn btn-sm btn-outline-primary">Add</button>
    <button type="button" id="updateAnnouncementBtn"class="btn btn-sm btn-outline-primary">Edit</button>
  </div>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="iconTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Icons</th>
            <th>Colors</th>
            <th></th>
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>

 
<script>
  var baseUrl=window.location.origin;
  var token ={{ Js::from(session('token')) }};

  $(document).ready(function(){
   var sectionCode="";
   var iconTable= $('#iconTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/icons/get/all",
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
        { "data":"icon"},
        { "data":"color"},
      
        {
          "data":"status",
          "render": function ( data, type, row, meta ) {
            console .log(row);
            if(row.status==null|| row.status=="" ){
              return '<button class="btn btn-success btn-sm quarter" data-bs-toggle="tooltip" data-bs-placement="top" title="Quarter" id="updateStatusBtn" > <i class="fa-solid fa-lock"></i> </button>';

            }
            return "";

            }
         }
      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

      
          $('#iconsTable tbody').on( 'click', '#updateStatusBtn', function () {
            var data = iconTable.row( $(this).closest('tr') ).data();

            swal.fire({
              title: 'Are you sure to use this Quarter?',
              showCancelButton: true,
              confirmButtonText: 'Update',
            }).then((result) => {
            
              if (result.isConfirmed) {

                $.ajax({
                  url:baseUrl+"/api/quarter/update/"+data.quarter_code,
                  type:"PATCH",
                  success:(res)=>{
                    console.log(res);
                    if(res){
                      swal.fire('Saved!', '', 'success');
                      swal.close();
                      iconTable.ajax.reload();
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
               
          } );

});
</script>
@endsection --}}


@extends('layouts.app')
@section('title', 'Icons')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pl-3 pr-3 pt-3 pb-2  mb-3 border-bottom" style="padding-left:20px; padding-right:20px">
  <h1 class="h2">Icons</h1>
  
  <div class="btn-toolbar mb-2 mb-md-0">
    
    <div class="btn-group me-2">
      <button type="button" id ="addIconsBtn" class="btn btn-sm btn-outline-primary">Add</button>
      <button type="button" id="updateIconstBtn"class="btn btn-sm btn-outline-primary">Edit</button>
      <button type="button" id="removeIconstBtn"class="btn btn-sm btn-outline-primary">Delete</button>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary ">
      <b>SY 2022-2023</b>
  </div>
  
</div>
<div class="" style="padding:0px 10px">
  <div class="col-12">
    <table id ="iconsTable"  class="table table-striped" style="width:100%">
      <thead>
        <tr>
            <th>Icons</th>
            <th>Color</th>
            
        </tr>
      </thead>
      <tbody>
       
      </tbody>
  

    </table>
  </div>
</div>


  <!-- UpdateModal -->
<div class="modal fade" id="updateIconsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Icon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form id="updateIconsForm">
      <div class="modal-body">
        <div class="mb-3">
          <label for="iconsName" class="form-label">Icons</label>
          <input type="text" class="form-control" id="updateIcons" required >
          {{-- <div id="emailHelp" class="form-text">We'll never share your ema il with anyone else.</div> --}}
        </div>
        <div class="mb-3">
          <label for="colorName" class="form-label">Color </label>
          <input type="color" class="form-control" id="updateColor" required >
          {{-- <div id="emailHelp" class="form-text">We'll never share your ema il with anyone else.</div> --}}
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
  <div class="modal fade" id="addIconsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Icon</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <form id="addIconsForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="iconsName" class="form-label">Icon </label>
            <input type="text" class="form-control" id="icon" required >
            {{-- <div id="emailHelp" class="form-text">We'll never share your ema il with anyone else.</div> --}}
          </div>
          <div class="mb-3">
            <label for="colorName" class="form-label">Color </label>
            <input type="color" class="form-control" id="color" required >
            {{-- <div id="emailHelp" class="form-text">We'll never share your ema il with anyone else.</div> --}}
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
   var iconId=null;
   
   var iconsTable= $('#iconsTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false,
      "sAjaxSource": baseUrl+"/api/icons/get/all",
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
        { "data":"icon"},
        { "data":"color"},
       
      ],
      "fnDrawCallback": function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

        },
    });

    $('#iconsTable tbody').on( 'click', 'tr', function () {   
      console.log($(this).hasClass('selected'));         
        if ( $(this).hasClass('selected') ) { 
            $(this).removeClass('selected'); 
        } 
        else {                 
            iconsTable.$('tr.selected').removeClass('selected'); 
            console.log($(this).text());
            $(this).addClass('selected');                
        }  

      });



    $("#addIconsBtn").click(()=>{
      $("#addIconsModal").modal("show");
    });
    
    $("#updateIconstBtn").click(()=>{
      var data = iconsTable.row( ".selected" ).data();
      console.log(data);
      iconId=data.id;
      
      
      $("#updateIcons").val(data.announcement_desc);
      $("#updateIcons").val(data.announcement_desc);
    

      $("#updateIconsModal").modal("show");
    });
//  remove
        $("#removeIconstBtn").click(()=>{
              var data = iconsTable.row( ".selected" ).data();
              swal.fire({
                title: 'Do you want to remove Icon?',
                showCancelButton: true,
                confirmButtonText: 'removed',
              }).then((result) => {
              
                if (result.isConfirmed) {

                  $.ajax({
                    url:baseUrl+"/api/icon/delete",
                    type:"POST",
                    data:{
                      "iconId":data.id
                      
                    },
                    success:(res)=>{
                      console.log(res);
                      if(res){
                        swal.fire('Saved!', '', 'success');
                        swal.close();
                        iconsTable.ajax.reload();
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
    $("#addIconsForm").submit((e)=>{
      e.preventDefault();
      swal.fire({
        title: 'Do you want to save the Icon?',
        showCancelButton: true,
        confirmButtonText: 'Save',
      }).then((result) => {
       
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/icon/create",
            type:"POST",
            data:{
              "icon":$("#icon").val(),
              "color":$("#color").val(),
              
            },
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire('Saved!', '', 'success');
                swal.close();
                $("#addIconsModal").modal("hide");
                iconsTable.ajax.reload();
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


    $("#updateIconsForm").submit((e)=>{
      // var code =$("#updateAnnouncementName").data("code");

      e.preventDefault();
      swal.fire({
        title: 'Do you want to update the Icon?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
      
        if (result.isConfirmed) {

          $.ajax({
            url:baseUrl+"/api/icon/update",
            type:"patch",
            data:{
              "iconId":iconId,
              "icon":$("#updateIcons").val(),
              "color":$("#updateColor").val(),
        
            },
            success:(res)=>{
              console.log(res);
              if(res){
                swal.fire('Update!', '', 'success');
                swal.close();
                $("#updateIconsModal").modal("hide");
                iconsTable.ajax.reload();
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
