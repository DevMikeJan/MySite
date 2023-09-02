<?php
    require_once APPROOT . '/views/includes/header.php';
?>

 <?php
    require APPROOT . '/views/includes/navigation.php';
?>


<div class = "signup_container">
    <div class = "signup_wrapper">
        <h2>Sign up</h2>

        <form action="<?php echo URLROOT; ?>/Register" method = "POST">
            <input type="text" placeholder = "Firstname" name = "user_fname">
            <span class = "error_message">
                <?php echo $datas['fname_error']; ?>
            </span>
            <input type="text" placeholder = "Middlename" name = "user_mname">
            <span class = "error_message">
                <?php echo $datas['mname_error']; ?>
            </span>
            <input type="text" placeholder = "Lastname" name = "user_lname">
            <span class = "error_message">
                <?php echo $datas['lname_error']; ?>
            </span>
            <select name="user_gender" id="gender">
                <option value="">Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <span class = "error_message">
                <?php echo $datas['gender_error']; ?>
            </span>
            <input type="text" placeholder = "Age" name = "user_age">
            <span class = "error_message">
                <?php echo $datas['age_error']; ?>
            </span>
            <input type="text" placeholder = "Address" name = "user_address">
            <span class = "error_message">
                <?php echo $datas['address_error']; ?>
            </span>
            <input type="email" placeholder = "Email" name = "user_email">
            <span class = "error_message">
                <?php echo $datas['email_error']; ?>
            </span>
            <input type="text" placeholder = "Username" name = "user_uname">
            <span class = "error_message">
                <?php echo $datas['uname_error']; ?>
            </span>
            <input type="password" placeholder = "Password" name = "user_password">
            <input type="password" placeholder = "Confirm Password" name = "confirmedPassword">
            <span class = "error_message">
                <?php echo $datas['pass_error']; ?>
            </span>
            <div>
            </div>
            <button type = "submit" value = "submit">Sign up</button>
            
        </form>
        
        <p class = "reminder">Already have an account? <a href="<?php echo URLROOT; ?> /Login">Sign in</a></p>
      </div>
</div>