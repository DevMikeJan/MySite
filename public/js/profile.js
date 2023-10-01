$(document).ready(function(){
    var defaultDegree = $(".Home_button").css("transform");
    var value = defaultDegree.split('(')[1].split(')')[0].split(',');
    var ab = value[0];
    var bc = value[1];
    var defaultAngles = Math.round(Math.atan2(bc, ab) * (180/Math.PI));


    $(".Profile_home_btn").mouseover(function(){
        var degree = $(".Home_button").css("transform");
        

        if(degree !== 'none') {
            var values = degree.split('(')[1].split(')')[0].split(',');
            var a = values[0];
            var b = values[1];
            var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
        } else { var angle = 0; }
    
        if(angle > 0){
            $(".Home_button").css({"transform":"rotate("+ defaultAngles +"deg)","animation-play-state":"paused"});
        }
    });

    $("#Profile_home_btn").mouseleave(function(){
        $(".Home_button").css({"animation-play-state":"running"});
    });

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


    $("#profile_activities_btn").click(function(){
        $(".profile_content_container").css({"display":"grid", "grid-template-columns":"100% 0"});
        $(".profile_reviews_actitivities_wrapper").css("overflow","auto ");
        $("#profile_load_asset_container").empty();
    });

    $("#profile_asset_btn").click(function(){
        $(".profile_content_container").css({"display":"grid", "grid-template-columns":"0 100%"});
        $(".profile_reviews_actitivities_wrapper").css("overflow","hidden");
        loadAssets();
    });

    function loadAssets(){
        var myAssetUplLink = $("#profile_asset_uploaded_link").val();

        $.ajax({
            url: myAssetUplLink,
            method:'POST',
            data:'',
            contentType:false,
            cache:false,
            processData:false,
            success:function(data){
                serLoadedAsset(data);
            }
        });
    }

    var imgSrc = '/public/uploadedAssets/'

    function serLoadedAsset($data){
        var srcUploadedImg = $("#prof_uploaded_img_src").val() + imgSrc;
        var fullPath = '';
        try {
            var objArray = JSON.parse($data);//json used to read php obj array
            isErr = false;
        } catch(err) {
            isErr= true;
        } finally {
            //code for finally block
        }

        if (isErr){
            alert($data);
        }
        
        else {
            $("#profile_load_asset_container").empty();
            $.each(objArray, function (key, value) {
                fullPath = srcUploadedImg + value.ASSET_IMG_RAN_NUM 
                
                $("#profile_load_asset_container").append("<div class = 'profile_loaded_assets' id = 'profile_loaded_assets'> \
                                                            <img id = 'my_asset_img' class = 'my_asset_img' src = '"+ fullPath +"'><br>\
                                                            <span>"+ value.ASSET_NAME +" </span><br>\
                                                            <span>"+ value.ASSET_DESC +" </span><br>\
                                                            </div>");
            });
        }

       
    }

    var isEditAssetVisisble = false

    $("#profile_load_asset_container").on('click', '#profile_loaded_assets',function(){

        if (isEditAssetVisisble == false) {
            $(".edit_asset_container").css({"transform":"translateY(0)"});
            isEditAssetVisisble = true;
        }
        
    });

    $("#close_asset_container").click(function(){

        if (isEditAssetVisisble == true) { 
            $(".edit_asset_container").css({"transform":"translateY(-1000px)"});
            isEditAssetVisisble = false
        }
    });

});