<?php
    require_once APPROOT . '/views/includes/header.php';
?>

<div class = "profile_container">
    
    <div class = "profile_wrapper">
        <div class = "profile_top_wrapper">
            <div class = "profile_img_wrapper">
                <div class = "profile_inner_wrapper">
                    <div class = "profile_img_holder">
                        <img class = "profile_img_uploaded" id = "profile_img_uploaded" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>defaultUserProf.png" alt="">
                    </div>
                    <div class = "profile_img_selector">
                        <form action="">
                            <img class = "profile_img" id = "profile_img" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>webcam.png" alt="">
                        </form>
                       
                    </div>
                </div>
                
            </div>
            <div class = "profile_cover_img_selector">
                 <img class = "profile_cover_img" id = "profile_cover_img" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>webcam.png" alt="">
            </div>
        </div>
        <div class = "profile_content">
            <div class = "profile_side_wrapper">

            </div>
        </div>
    </div>
</div>