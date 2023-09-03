<?php
    require_once APPROOT . '/views/includes/header.php';
?>

<div class = "asset_detail_container">
    <div class = "asset_detail_wrapper">
        <div class = "asset_img_wrapper">
            <img class = "asset_img_src" id = "asset_img_src" src="<?php echo URLROOTADMINSIDE . '/public/uploadedAssets/45230759469.jpg';?>" alt="">
        </div>
        <div class = "asset_desc_info_wrapper">
            <div class = "asset_desc_close_wrapper">
                <img class = "close_asset_dtl" id = "close_asset_dtl" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>close.png" alt="">
            </div>
            <div class = "asset_info_section">
                <span class = "asset_name" id = "asset_name">M16</span><br>
                <span class = "asset_desc" id = "asset_desc">Use To Shoot Rebel</span>
            
                <span class = "php_msg" id = "php_msg"></span>
                <input type="hidden" class = "asset_id" id = "asset_id" value = '' name = 'asset_id'>
                <input type="hidden" class = "asset_review_id" id = "asset_review_id" value = '' name = 'asset_review_id'>
                <input type="hidden" class = "user_id_reviewer" id = "user_id_reviewer" value = '<?php  echo (isLoggedIn()) ? $_SESSION['user_id'] : "none" ?>' name = 'user_id_reviewer'>
                <input type="hidden" class = "user_name_reviewer" id = "user_name_reviewer" value = '<?php  echo (isLoggedIn()) ? $_SESSION['user_fname'] : "none" ?>' name = 'user_name_reviewer'>
                <input type="hidden" class = "get_specific_asset_info" id = "get_specific_asset_info" value = '' name = 'get_specific_asset_info'>
                <input type="hidden" class = "file_link" id = "file_link" value = '<?php echo URLROOTADMINSIDE . '/public/uploadedAssets/';?>' name = 'file_link'>
            </div>

            <div class = "asset_action_container">
                <form action=""class = "asset_action_form" id = "asset_action_form">
                    <button>Download Asset</button>
                    <input type="hidden" class = "isLoggedIn" id = "isLoggedIn" value = '<?php  echo isLoggedIn();?>' name = 'isLoggedIn'>
                    <input type="hidden" class = "isAlreadyRated" id = "isAlreadyRated" value = '<?php echo URLROOT . '/CheckReviewed';?>' name = 'isAlreadyRated'>
                    <input type="hidden" class = "chkIfReviewed" id = "chkIfReviewed" value = '' name = 'chkIfReviewed'>
                    <span class = "set_rate" id = "set_rate">Rate</span>
                </form>
            </div>
        </div>
        <div class = "asset_rate_container">
            <div class = "asset_rate_wrapper">
                <form action=""  method = "POST" class = "asset_rate_form" id = "asset_rate_form">
                    <div class = "rate_stars_container">
                        <span>Rate Stars: </span>
                        <input type="hidden" class = "rate_star_link" id = "rate_star_link" value = "<?php echo URLROOTADMINSIDE . '/public/icons/';?>">
                        <div class = "rate_star1" id = "rate_star1">
                            <img class = "rateStar1" id = "rateStar1" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>unSelectedRateStar.png" alt="">
                        </div>
                        <div class = "rate_star2" id = "rate_star2">
                            <img class = "rateStar2" id = "rateStar2" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>unSelectedRateStar.png" alt="">
                        </div>
                        <div class = "rate_star3" id = "rate_star3">
                            <img class = "rateStar3" id = "rateStar3" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>unSelectedRateStar.png" alt="">
                        </div>
                        <div class = "rate_star4" id = "rate_star4">
                            <img class = "rateStar4" id = "rateStar4" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>unSelectedRateStar.png" alt="">
                        </div>
                        <div class = "rate_star5" id = "rate_star5">
                            <img class = "rateStar5" id = "rateStar5" src="<?php echo URLROOTADMINSIDE . '/public/icons/';?>unSelectedRateStar.png" alt="">
                        </div>
                    </div>
                    <div class = "rate_input_container">
                        <span>Comment:</span><br>
                        <input id = "asset_rate_link" type="hidden" value = "<?php echo URLROOT . '/RateAsset';?>">
                        <input type="text" class = "rate_comment" id = "rate_comment" name = "rate_comment"><br>
                        <input type="hidden" class = "get_reviews" id = "get_reviews" name = "get_reviews"><br>
                        <button class = "submit_rate" id = "submit_rate" name = "submit_rate">Submit</button>
                        <span class = "response_msg" id = "response_msg"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class = "asset_comment_sect_container" id="asset_comment_sect_container">
            <input id = "profile_img_src" type="hidden" value = '<?php echo URLROOTADMINSIDE . '/public/icons/';?>'>
        <div class = 'asset_ratings' id = "asset_ratings">
            <h5>Asset Ratings</h5>
        </div>
    </div>
</div>

<?php
        require APPROOT . '/views/includes/navigation.php';
?>

<div class = "asset_container">
    <div class = "asset_inner_wrapper">
        <?php if($assetList): ?>
            <?php foreach($assetList as $list): ?>
                <div class = "asset_info_holder">
                    <div class = "asset_img_holder">
                        <img src="<?php echo URLROOTADMINSIDE . '/public/uploadedAssets/'.$list->ASSET_IMG_RAN_NUM;?>" alt="">
                    </div>
                    <div class = "asset_desc_holder">
                        <span class = "asset_id_holder" id = "asset_id_holder"><?php echo $list->ASSETFILE_ID;  ?></span>
                        <span>Name:<?php echo $list->ASSET_NAME;  ?></span>
                        <span>Desc:<?php echo $list->ASSET_DESC;  ?></span>
                        <input id = "assetLink" type="hidden" value = "<?php echo URLROOT . '/AssetInfo';?>">
                        <input id = "reviewsLink" type="hidden" value = "<?php echo URLROOT . '/Reviews';?>">
                        <span class = "view_dtl" id = "view_dtl">View Detail</span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>



<?php
    require_once APPROOT . '/views/includes/footer.php';
?>

