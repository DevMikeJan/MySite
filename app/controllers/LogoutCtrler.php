<?php

namespace app\controllers;

class LogoutCtrler extends Controller{

    public $connection;

    public function __construct($conn){
        $this->userModel = $this->model('UserModel');
        $this->connection = $conn;
    }

    public function logout(){
        $data = [
            'user_uname_email' => $_SESSION['user_uname'],
            'user_status' => 0
        ];

        $updateStatus = $this->userModel->uptStatActive($this->connection, $data);

        if($updateStatus) {
            unset($_SESSION['user_id']);
            unset($_SESSION['active_stat']);
            unset($_SESSION['user_uname']);
            unset($_SESSION['user_fname']);
            unset($_SESSION['user_lname']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_type']);
    
            
            header('location:' . URLROOT . '/');
        }
    }
}