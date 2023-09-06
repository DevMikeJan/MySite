<?php
    require_once APPROOT . '/views/includes/userAccess.php';
?>



<?php
    require_once APPROOT . '/views/includes/header.php';
?>

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
                        <form action=""  method = "POST" class = "uploadProfileImg"  id = "uploadProfileImg" enctype="multipart/form-data" >
                            <input id = "profile_user_id" type="hidden" value = "<?php echo $_SESSION['user_id'];?>">
                            <input id = "profile_path_link" type="hidden" value = "<?php echo URLROOTADMINSIDE . '/public/profilePics/';?>">
                            <input id = "uploadProfilePicLink" type="hidden" value = "<?php echo URLROOT . '/UploadProfilePic';?>">
                            <input class = "profile_choose_img" id = "profile_choose_img" type="file" name = "profile_choose_img">
                            <img class = "profile_img" id = "profile_img" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>webcam.png" alt="">
                            <input class = "profile_uploaded_img" id = "profile_uploaded_img" type="hidden" val = '' name = "profile_uploaded_img">
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