$(document).ready(function(){
    var isViewDtl = 0;
    var isErr = false;

    $(".view_dtl").click(function(){
        var asset_id = $(this).parent("div").find("span#asset_id_holder").text();
        var link = $("#assetLink").val();

        var new_form_data = new FormData();
        new_form_data.append("asset_id", asset_id);

        $.ajax({
            url: link,
            method:'POST',
            data:new_form_data,
            contentType:false,
            cache:false,
            processData:false,
            beforeSend:function(){
              $('#php_msg').html('Loading......');
            },
            success:function(data){
              $('#get_specific_asset_info').val(data);
                loadSpeficAsset();
                getReviews(asset_id);
                $('#php_msg').html('');

                if (isErr == false){
                    $(".asset_detail_container").css("transform", "translateY(0)");
                }
            }
          });
    });

    function loadSpeficAsset() {
        var array = $("#get_specific_asset_info");
        var fileLink = $("#file_link").val();
        var reviewID;
        try {
            var objArray = JSON.parse(array.val());//json used to read php obj array
            isErr = false;
        } catch(err) {
            alert(err);
            isErr= true;
        } finally {
            //code for finally block
        }
        $.each(objArray, function (key, value) {
            if (value.REF_ASSET_NO !== null){
                reviewID = value.REF_ASSET_NO ;
            }
            else {
                reviewID = ""
            }

            $("#asset_id").val(value.ASSETFILE_ID);
            $("#asset_review_id").val(reviewID);
            $("#asset_name").text("Name: "+ value.ASSET_NAME);
            $("#asset_desc").text("Description: "+ value.ASSET_DESC);
            $("#asset_img_src").attr("src",fileLink + value.ASSET_IMG_RAN_NUM);
        });
    }

    $("#close_asset_dtl").click(function(){
        $(".asset_detail_container").css("transform", "translateY(-1000px)");
        if (isOpenRate == true){
            $("#set_rate").trigger('click');
        }

        if (isStar1Selected){
            $('#rate_star1').trigger('click');
        }
    });

    function chkIfAlreadyRated(userID, link, reviewID){ 
        var new_form_data = new FormData();
        var isReviewed= false;

        new_form_data.append("reviewer_id", userID);
        new_form_data.append("review_id", reviewID);

        $.ajax({ 
            method:'POST',
            data: new_form_data, 
            url: link, 
            contentType:false,
            cache:false,
            processData:false,
        }).done(function (response) { 
            $('#chkIfReviewed').val(response);
            isReviewed =$('#chkIfReviewed').val();

            if (isReviewed == "") {
                if (isOpenRate == false){
                    $(".asset_rate_wrapper").css("width","100%");
                    $(".set_rate").text("Close Rate");
                    isOpenRate= true;
                }
                else if (isOpenRate == true) {
                    $(".asset_rate_wrapper").css("width","0");
                    $(".set_rate").text("Rate");
                    isOpenRate= false;
                }
            }
            else {
                alert("You've already rated this asset");
            }
        }) ;
    }
    
    var isOpenRate = false
    $("#set_rate").click(function(){
        var isLoggedIn = $("#isLoggedIn").val();
        var reviewer_id = $("#user_id_reviewer").val();
        var isRatedAlreadyLink = $("#isAlreadyRated").val();
        var reviewID = $("#asset_id").val();

        if (isLoggedIn) {
             chkIfAlreadyRated(reviewer_id,isRatedAlreadyLink,reviewID);
        }
        else {
            alert("Please Sign-in First");
        }
    });

    //review section
    var starCount = 0

    $("#asset_rate_form").submit(function(e){
        e.preventDefault();
        var reviewLink = $("#asset_rate_link").val();
        var asset_ref_no = $("#asset_id").val();;
        var asset_review_stars = starCount;
        var asset_review_comment = $("#rate_comment").val();
        var review_by_id = $("#user_id_reviewer").val();
        var review_by_name = $("#user_name_reviewer").val();

      

        var new_form_data = new FormData();
        new_form_data.append("asset_ref_no", asset_ref_no);
        new_form_data.append("asset_review_stars", asset_review_stars);
        new_form_data.append("asset_review_comment", asset_review_comment);
        new_form_data.append("review_by_id", review_by_id);
        new_form_data.append("review_by_name", review_by_name);

        $.ajax({
            url: reviewLink,
            method:'POST',
            data:new_form_data,
            contentType:false,
            cache:false,
            processData:false,
            beforeSend:function(){
              $('#response_msg').html('Loading......');
            },
            success:function(data){
              $('#response_msg').html(data);
              getReviews(asset_ref_no);
            }
          });
    });

    var isRowsEmpty;
    function getReviews($asset_ref_no){
        var reviewLink = $("#reviewsLink").val();
        var new_form_data = new FormData();
        new_form_data.append("asset_ref_no", $asset_ref_no);

        $.ajax({
            url: reviewLink,
            method:'POST',
            data:new_form_data,
            contentType:false,
            cache:false,
            processData:false,

            beforeSend:function(){
              //$('#response_msg').html('Loading......');
            },

            success:function(data){
              $('#get_reviews').val(data);
              var array = $("#get_reviews");
              var fileLink = $("#file_link").val();
              var imgSrc = $("#profile_img_src").val();
              var userLoggedInID = $("#user_id_reviewer").val();
              var starsPath = $("#starIconPath").val();
              var starCounts = 0;
              var starIcons = '';
              var maxOverAllStars = 5000;
              var overAllTotStars = 0;
              var objArray;
              var img ='', reviewerID = '', reviewerName = '';
              var wStars = "";
              var woStars = "";
              var totBar;

                try {
                    if (array.val() != "false")
                    {
                      objArray   = JSON.parse(array.val());//json used to read php obj array
                      isRowsEmpty = false;
                    }
                    else  if (array.val() == "false") {
                        isRowsEmpty = true;
                    }
                  
                    isErr = false;
                } catch(err) {
                    alert(err);
                    isErr= true;
                    isRowsEmpty = true;
                } finally {
                    //code for finally block
                }

                $('#asset_ratings').children().not('h5,.tot_stars').remove();

                if (isRowsEmpty == false) {

                    if (isOpenRate == true) {
                        $(".asset_rate_wrapper").css("width","0");
                        $(".set_rate").text("Rate");
                        isOpenRate= false;
                    }

                    $.each(objArray, function (key, value) {

                        starCounts = value.ASSET_REVIEW_STARS;
                        overAllTotStars += starCounts
                   
                        if (value.PROFILE_IMG == null){
                            img =  "<img src='"+ imgSrc +"User.png'>";
                        }
                        else {
                            img =   "<img src='"+ imgSrc + value.PROFILE_IMG +"' alt=''>";
                        }
                        
                        if (value.REVIEW_BY_NAME == null) {
                            reviewerName = "Anonimous";
                        }
                        else {
                            reviewerName = value.REVIEW_BY_NAME;
                        }

                        if (value.REVIEW_BY_ID == userLoggedInID) {
                            $("#asset_review_id").val(value.REF_ASSET_NO);
                        }

                        for(var i = 0; i < starCounts; i++) {
                            wStars += "<img src = '"+ starsPath +"/selectedRateStar.png' >";
                        }

                        for(var i = starCounts; i < 5; i++) {
                             woStars += "<img src = '"+ starsPath +"/unSelectedRateStar.png' >";
                        }

                        starIcons = "<div class = 'reviewed_stars_container' id = 'reviewed_stars_container'>\
                                        "+ wStars +"\
                                        "+ woStars +"\
                                     </div>"
                      
                        $('#asset_ratings').append("<div class = 'comment_container'>\
                                                                        <div class = 'user_prof_container'>\
                                                                            <div class = 'user_prof_img'>\
                                                                                "+ img +"\
                                                                            </div>\
                                                                            <div class = 'user_name' id = 'user_name'>\
                                                                                <span class = 'reviewed_by_name' id = 'reviewed_by_name'>"+ reviewerName +"</span><br>\
                                                                                <span class = 'reviewed_stars' id = 'reviewed_stars'>"+ starIcons +"</span><br>\
                                                                                <span class = 'reviewed_date' id = 'reviewed_date'>"+ value.REVIEW_DATE+"</span><br>\
                                                                                <span class = 'reviewed_comment' id = 'reviewed_comment'>"+ value.ASSET_REVIEW_COMMENT+"</span>\
                                                                            </div>\
                                                                        </div>\
                                                                    </div>");
                    });
                    overAllTotStars = (5000 / maxOverAllStars) * 5

                    totBar = (5000 / maxOverAllStars) * 100;
                   

                    overAllTotStars = roundNumber(overAllTotStars, 1);
                 
                    $(".tot_stars_wrapper > span").text(overAllTotStars + " Out Of " + 5);

                    $("#progress_container").css({"background-color":"#f1f1f1","width":"100%", "border-radius":"50px", 
                                                  "overflow":"hidden","position":"relative","overflow":"hidden","padding":"0"});
                    $("#progress_stars").css({"background-color":"yellow", "width":"" + totBar + "%", "height":"20px"});
                    $("#star_bars").css({"width":"100%", "height":"30px","position":"absolute", "top":"0"});

                }
            }
          });

       
    }

    function roundNumber(number, decimal_digit) {
        var powerOften = Math.pow( 10, decimal_digit );
        var result = Math.round( number * powerOften ) / powerOften;
        return result;
     }

    //rate section
    var isStar1Selected = false
    var isStar2Selected = false
    var isStar3Selected = false
    var isStar4Selected = false
    var isStar5Selected = false

    var iconLink = $("#rate_star_link").val();
    $("#rate_star1").click(function(){
        if (isStar1Selected == false) {
            $("#rateStar1").attr('src',iconLink+'selectedRateStar.png');
            isStar1Selected = true;
            starCount = 1;
        }
        else if (isStar1Selected == true) {
            if (isStar2Selected == true) {
                for(var i = 5; i > 1; i--){
                    $('#rateStar'+ i ).attr('src',iconLink+'unSelectedRateStar.png');
                }
                isStar2Selected = false;
                isStar3Selected = false;
                isStar4Selected = false;
                isStar5Selected = false;
                starCount = 1;
            }
           else {
                $('#rateStar1').attr('src',iconLink+'unSelectedRateStar.png');
                isStar1Selected = false;
                starCount = 0;
            }
        }
           
    });

    $("#rate_star2").click(function(){
            if (isStar2Selected == false) {
                
                for(var i = 1; i < 3; i++){
                    $('#rateStar'+ i ).attr('src',iconLink+'selectedRateStar.png');
                }
                isStar1Selected = true;
                isStar2Selected = true;
                starCount = 2;
            }
            else if (isStar2Selected == true) {
                if (isStar3Selected == true) {
                    for(var i = 5; i > 2; i--){
                        $('#rateStar'+ i ).attr('src',iconLink+'unSelectedRateStar.png');
                    }
                    isStar3Selected = false;
                    isStar4Selected = false;
                    isStar5Selected = false;
                    starCount = 2;
                }
                else {
                    $('#rateStar2').attr('src',iconLink+'unSelectedRateStar.png');
                    isStar2Selected = false;
                }
            }
    });

    $("#rate_star3").click(function(){

            if (isStar3Selected == false) {
                for(var i = 1; i < 4; i++){
                    $('#rateStar'+ i ).attr('src',iconLink+'selectedRateStar.png');
                }
                isStar1Selected = true;
                isStar2Selected = true;
                isStar3Selected = true;
                starCount = 3;
            }
            else if (isStar3Selected == true) {
                if (isStar4Selected == true) {
                    for(var i = 5; i > 3; i--){
                        $('#rateStar'+ i ).attr('src',iconLink+'unSelectedRateStar.png');
                    }
                    isStar4Selected = false;
                    isStar5Selected = false;
                    starCount = 3;
                }
                else {
                    $('#rateStar3').attr('src',iconLink+'unSelectedRateStar.png');
                    isStar3Selected = false;
                }
                
            }

    });

    $("#rate_star4").click(function(){

            if (isStar4Selected == false) {
                for(var i = 1; i < 5; i++){
                    $('#rateStar'+ i ).attr('src',iconLink+'selectedRateStar.png');
                }
                isStar1Selected = true;
                isStar2Selected = true;
                isStar3Selected = true;
                isStar4Selected = true;
                starCount = 4;
            }
            else if (isStar4Selected == true) {

                if (isStar5Selected == true) {
                    for(var i = 5; i > 4; i--){
                        $('#rateStar'+ i ).attr('src',iconLink+'unSelectedRateStar.png');
                    }
                    isStar5Selected = false;
                    starCount = 4;
                }
                else {
                    $('#rateStar4').attr('src',iconLink+'unSelectedRateStar.png');
                    isStar4Selected = false;
                }
            }

    });

    $("#rate_star5").click(function(){

            if (isStar5Selected == false) {
                for(var i = 1; i < 6; i++){
                    $('#rateStar'+ i ).attr('src',iconLink+'selectedRateStar.png');
                }
                isStar1Selected = true;
                isStar2Selected = true;
                isStar3Selected = true;
                isStar4Selected = true;
                isStar5Selected = true;
                starCount = 5;
            }
            else if (isStar5Selected == true) {
                $("#rateStar5").attr('src',iconLink+'unSelectedRateStar.png');
                isStar5Selected = false;
            }

    });


    
});