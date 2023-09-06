<?php
    //check if the admin users is logged-in
    //redirect to login-page if not logged-in
    if(isset($_SESSION['user_id'])){
        if($_SESSION['user_type'] === 1) 
            header('location:' . URLROOT . '/app/admin/');
    }
    else {
        header('location:' . URLROOT . '/Login');
    }

?>