<template>
</template>

<script>
$(document).ready(function(){
    console.log('log');
    $('#teachersTable').DataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false 
    });


    $("#addTeacherBtn").click(()=>{
      $("#addTeacherModal").modal("show");
    });

});
</script>