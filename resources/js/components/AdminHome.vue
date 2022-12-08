<template>
</template>

<script>

$(document).ready(function(){
    $("#editLogoBtn").on('click',function(e){
       console.log($('#uploadLogoModal'));
        //    bootstrap.modal();
        $('#uploadLogoModal').modal("show");
    });
    $("#editProfileBtn").on('click',function(e){
       console.log($('#uploadLogoModal'));
        //    bootstrap.modal();
        $('#updateProfileModal').modal("show");
        $('#schoolName').val();
        $('#schoolAddress').val();
        $('#schoolYear').val();
    });
    $("#uploadLogo").submit( function(e){    
        e.preventDefault();
        // var form = this.form;
        var formData = new FormData();
        var imagefile = document.querySelector('#formFile');
        formData.append("file", imagefile.files[0]);
        axios({
            method: "post",
            url: "/api/profile/upload",
            data: formData,
            headers: { "Content-Type": "multipart/form-data" },
        }).then(function (response) {
                //handle success
                console.log(response);
                location.reload();
        }).catch(function (response) {
                //handle error
                console.log(response);
        });
        
    })
    
})



    particlesJS.load('particle-js', '../json/particles-config.json', function() {
        console.log('callback - particles.js config loaded');
    });

    

   
    function tooltip(element){
        return new bootstrap.Tooltip(element, {
                boundary: document.body // or document.querySelector('#boundary')
            });
    }

    export default {
        // data(){
        //     return {
        //         name:""
        //     }
        // },
        // beforeMount(){
        //     axios.get("/api/profile").then(function (response) {
        //         var  res =response.data[0];
        //         this.name=res.school_name;
        //     })
        //     // console.log(res);

        // },
        mounted() {
            var editLogoBtn = document.getElementById('editLogoBtn');
            var editProfileBtn = document.getElementById('editProfileBtn');

            tooltip(editLogoBtn);
            tooltip(editProfileBtn);
            var logoElement = document.querySelector('.logo-element');
            var contentElement = document.querySelector('.content-element');

            // $("#editLogoBtn").on('click',function(e){
            // $('#uploadLogoModal').modal("show");

            //  });
            
        },
        methods:{
            editButtonClick(e){
                console.log("sample");
                var exampleModal = document.getElementById('uploadLogoModal');
                exampleModal.modal();
                // exampleModal.addEventListener('show.bs.modal', function (event) {
                // // Button that triggered the modal
                // var button = event.relatedTarget
                // // Extract info from data-bs-* attributes
                // var recipient = button.getAttribute('data-bs-whatever')
                // // If necessary, you could initiate an AJAX request here
                // // and then do the updating in a callback.
                // //
                // // Update the modal's content.
                // var modalTitle = exampleModal.querySelector('.modal-title')
                // var modalBodyInput = exampleModal.querySelector('.modal-body input')

                // modalTitle.textContent = 'New message to ' + recipient
                // modalBodyInput.value = recipient
                // })
            }

        }
    }
</script>
