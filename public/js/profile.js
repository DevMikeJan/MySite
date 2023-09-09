$(document).ready(function(){

    $(".profile_img").click(function(){
        $("input.profile_choose_img").trigger("click");
    });

    $(".profile_choose_img").change(function(){
        var prof = $(this).val();
        var ext = prof.substring(prof.lastIndexOf('.') + 1).toLowerCase();

        if (prof){

            if(ext == "png" || ext == "jpg" || ext == "jpeg"){
                $("#uploadProfileImg").trigger("submit");
            }
            else {
                alert("Please Select Valid Images");
            }
        }
    });

    $(".uploadProfileImg").submit(function (e) { 
        e.preventDefault();

        var upload_link = $("#uploadProfilePicLink").val();
        var user_id = $("#profile_user_id").val();
        var profilePic =  $("#profile_choose_img").prop("files")[0];
        var profilePath = $("#profile_path_link").val();
        
        var new_form_data = new FormData();
        new_form_data.append("user_id", user_id);
        new_form_data.append("img", profilePic);

        $.ajax({
            url: upload_link,
            method:'POST',
            data:new_form_data,
            contentType:false,
            cache:false,
            processData:false,
            success:function(data){
              $('#profile_uploaded_img').val(data);
              if (data !== null){
                  img = data ;
                }
                else {
                    img = ""
                }

                $("#profile_img_uploaded").attr("src",profilePath + img);
            }
        });
    });

    // function setProfilePic() {
    //     var uploadedPic = $("#profile_uploaded_img");
    //     var profilePath = $("#profile_path_link").val();
    //     var img;
    //     try {
    //         var objArray = JSON.parse(uploadedPic.val());//json used to read php obj array
    //         isErr = false;
    //     } catch(err) {
    //         isErr= true;
    //     } 

    //     $.each(objArray, function (key, value) {
    //         if (value.PROFILE_IMG !== null){
    //             img = value.PROFILE_IMG ;
    //         }
    //         else {
    //             img = ""
    //         }
    //         $("#profile_img_uploaded").attr("src",profilePath + img);
    //     });
    // }


    $("#profile_cover_img").click(function(){
        $("input.profile_choose_cover").trigger("click");
    });


    $(".profile_choose_cover").change(function(){
        var prof = $(this).val();
        var ext = prof.substring(prof.lastIndexOf('.') + 1).toLowerCase();

        if (prof){
            if(ext == "png" || ext == "jpg" || ext == "jpeg"){
                $("#uploadProfileCover").trigger("submit");
            }
            else {
                alert("Please Select Valid Images");
            }
        }
    });

    $(".uploadProfileCover").submit(function(e){
        e.preventDefault();

        var upload_link = $("#uploadProfileCoverLink").val();
        var user_id = $("#profile_user_id").val();
        var profileCover =  $("#profile_choose_cover").prop("files")[0];
        var profilePath = $("#profileCover_path_link").val();

        var new_form_data = new FormData();
        new_form_data.append("user_id", user_id);
        new_form_data.append("img", profileCover);

        $.ajax({
            url: upload_link,
            method:'POST',
            data:new_form_data,
            contentType:false,
            cache:false,
            processData:false,
            success:function(data){
              $('#profile_uploaded_cover').val(data);
                if (data !== null){
                    img = data;
                }
                else {
                    img = ""
                }

                $("#profile_cover_act_img").attr("src",profilePath + img);
            }
        });
    });

    // function setProfileCover() {
    //     var uploadedPic = $("#profile_uploaded_cover");
    //     var profilePath = $("#profileCover_path_link").val();
    //     var img;
    //     try {
    //         var objArray = JSON.parse(uploadedPic.val());//json used to read php obj array
    //         isErr = false;
    //     } catch(err) {
    //         isErr= true;
    //     } 

    //     $.each(objArray, function (key, value) {
    //         alert(key.COVER_IMG);
    //         if (key.COVER_IMG !== null){
    //             img = key.COVER_IMG ;
    //         }
    //         else {
    //             img = ""
    //         }
    //         $("#profile_cover_act_img").attr("src",profilePath + img);
    //     });
    // }

});