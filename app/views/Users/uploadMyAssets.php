<?php
    require_once APPROOT . '/views/includes/userAccess.php';
?>

<?php
    require_once APPROOT . '/views/includes/header.php';
?>


<div class = "manage_assets_container">
    <div class = "manage_my_asset_wrapper">
        <div class = "manage_my_asset_close_form_container">
            <span>
                <a href="<?php echo URLROOT . $_SESSION['PREVIOUSPAGE'] ?>">Back</a>
            </span>
        </div>
        <div class = "manage_my_asset_header">
            <h3>Upload Assets</h3>
        </div>
        <div class = "manage_my_asset_form_container">
            <form action="" class = "manage_asset_form" id = "manage_asset_form" method = "POST" enctype="multipart/form-data">
                <div class = "manage_my_asset_img_wrapper">
                    <div class = "upload_asset_img_prev">
                        <img src="<?php echo URLROOTADMINSIDE; ?>/public/icons/image.png" alt="Image Preview" class = "manage_asset_img_src_ph" id ="manage_asset_img_src_ph">
                    </div>
                    <div class = "upload_asset_btn_container">
                        <div class = "manage_assets_rar">
                            <span>File</span>
                            <br>
                            <input id = "manage_uploadAssetsLink" type="hidden" value = "<?php echo URLROOT . '/ProceedUpload';?>">
                            <input class = "manage_asset_file" id = "manage_asset_file" type="file" name = "manage_asset_file">
                        </div>
                        <div class = "manage_assets_img">
                            <span>Image</span>
                            <br>
                            <input class = "manage_asset_file_img" id = "manage_asset_file_img" type="file" name = "manage_asset_file_img">
                        </div>
                    </div>
                </div>
                <div class = "upload_asset_user_input">
                    <input type="text" placeholder = "Asset Name" name = "manage_asset_name" class = "manage_asset_name" id = "manage_asset_name">
                    <input type="text" placeholder = "Asset Description" name = "manage_asset_desc" class = "manage_asset_desc" id = "manage_asset_desc">
                    <button class = "upload_manage_asset_btn" id = "" type = "submit" name = "upload_manage_asset_btn">Upload</button>
                    <span class = "manage_asset_process_msg" id = "manage_asset_process_msg">
                </div>
            </form>
        </div>
    </div>
</div>