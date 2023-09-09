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
            <div class = "Home_button">
                <span><a href='<?php echo URLROOT . '/';?>'>Hone</a></span>
            </div>
            <div class = "profile_img_wrapper">
                <div class = "profile_inner_wrapper">
                    <div class = "profile_img_holder">
                        <?php if(is_null($_SESSION['profile_pic'])): ?>
                            <img class = "profile_img_uploaded" id = "profile_img_uploaded" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>defaultUserProf.png" alt="">
                        <?php else: ?>
                            <img class = "profile_img_uploaded" id = "profile_img_uploaded" src="<?php echo URLROOTADMINSIDE . '/public/profilePics/'.$_SESSION['profile_pic'];?>" alt="">
                        <?php endif; ?>
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
            <div class = "profile_cover_container">
            
                <div class = "profile_cover_wrapper">
                        <?php if(is_null($_SESSION['cover_pic'])): ?>
                            <img class = "profile_cover_act_img" id = "profile_cover_act_img" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>defaultUserProf.png" alt="">
                        <?php else: ?>
                            <img class = "profile_cover_act_img" id = "profile_cover_act_img" src="<?php echo URLROOTADMINSIDE . '/public/coverPhoto/'.$_SESSION['cover_pic'];?>" alt="">
                        <?php endif; ?>
                </div>
            </div>
            <div class = "profile_cover_img_selector">
                 <img class = "profile_cover_img" id = "profile_cover_img" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>webcam.png" alt="">
                 <form action="" method = "POST" class = "uploadProfileCover"  id = "uploadProfileCover" enctype="multipart/form-data">
                    <input class = "profile_choose_cover" id = "profile_choose_cover" type="file" name = "profile_choose_cover">
                    <input id = "profileCover_path_link" type="hidden" value = "<?php echo URLROOTADMINSIDE . '/public/coverPhoto/';?>">
                    <input id = "uploadProfileCoverLink" type="hidden" value = "<?php echo URLROOT . '/UploadCoverPhoto';?>">
                    <input class = "profile_uploaded_cover" id = "profile_uploaded_cover" type="hidden" val = '' name = "profile_uploaded_cover">
                 </form>
            </div>
        </div>
        <div class = "profile_content">
            <div class = "profile_user_name_holder">
                <div class = "profile_user_name_wrapper">
                    <span><?php echo $_SESSION['user_fname'] .' '. $_SESSION['user_mname'] .' '. $_SESSION['user_lname']; ?></span>
                </div>
                <div class = "profile_edit_button_holder">
                    <span class = "edit_profile">Edit Profile</span>
                </div>
            </div>
            <div class = "profile_asset_button_container">
                <div class = "profile_asset_button_wrapper">
                    
                </div>
            </div>
        </div>
    </div>
</div>