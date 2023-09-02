<?php
    session_start();

    function isLoggedIn() {
        if (isset($_SESSION['user_id'])) {
            IF ($_SESSION['active_stat'] == 1){
                return true;
            }
            ELSE {
                return true;
            }
            
        } else {
            return false;
        }
    }