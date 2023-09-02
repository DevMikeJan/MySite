<?php
    require_once APPROOT . '/views/includes/header.php';
?>

<?php
    require APPROOT . '/views/includes/navigation.php';
?>


<div class = "login_Container">
    <div class = "login_Wrapper">
        <h2>Sign in</h2>
        <form action="<?php echo URLROOT; ?>/Login" method = "POST">
            <input type="text" placeholder = "Username/E-mail" name = "user_uname_email">
            
            <input type="password" placeholder = "Password" name = "user_password">
            
            <button type = "submit" value = "submit">Sign in</button>
        </form>
        <span class = "error_message">
            <?php echo $datas['error_message']; ?>
        </span>

        <p class = "reminder">Not Registered yet? <a href="<?php echo URLROOT; ?> /Register">Sign up</a></p>
    </div>

</div>