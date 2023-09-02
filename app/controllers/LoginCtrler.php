<?php

namespace app\controllers;


class LoginCtrler extends Controller {
    public $connection;

    public function __construct($conn){
        $this->userModel = $this->model('UserModel', $this->connection);
        $this->connection = $conn;
        
    }

    public function viewPage($view){
        $datas = [
            'user_uname_email' => '',
            'user_password' => '',
            'user_status' => '',
            'error_message' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] ==  'POST'){ 
            $datas = [
                'title' => 'Login page',
                'user_uname_email' => trim($_POST['user_uname_email']),
                'user_password' => trim($_POST['user_password']),
                'user_status' => 1,
                'error_message' => ''
            ];

            if(!empty($datas['user_uname_email']) || !empty($datas['user_password'])) { 
                $chkExistingUname = $this->userModel->chkExistingUser($this->connection, 'UNAME', $datas['user_uname_email'], ':UNAME');
                $chkExistingEmail = $this->userModel->chkExistingUser($this->connection, 'EMAIL', $datas['user_uname_email'], ':EMAIL');

                IF ($chkExistingUname || $chkExistingEmail) {

                    $getLoginCredentials = $this->userModel->login($this->connection, $datas['user_uname_email'],$datas['user_password']);

                    if ($getLoginCredentials){
                        $activeStat = $this->userModel->uptStatActive($this->connection, $datas);

                        $this->createUserSession($getLoginCredentials);
                    }
                    else {
                        $datas['error_message'] = 'Invalid Password';
                    }
                }
                else {
                    $datas['error_message'] = 'Invalid Username/E-mail';
                }
            }
            else {
                $datas['error_message'] = 'Empty Field';
            }
        }

        require_once $this->checkUserData($view);
    }

    private function createUserSession($user){
        $_SESSION['user_id'] = $user->USER_ID;
        $_SESSION['active_stat'] = $user->ACTIVE;
        $_SESSION['user_uname'] = $user->UNAME;
        $_SESSION['user_fname'] = $user->FNAME;
        $_SESSION['user_mname'] = $user->MNAME;
        $_SESSION['user_lname'] = $user->LNAME;
        $_SESSION['user_email'] = $user->EMAIL;
        $_SESSION['user_type'] = $user->USER_ACCESS;

        if($user->user_type != '1')
            header('location:' . URLROOT . '/');
        else 
            header('location:' . URLROOT . '/Logout');
    }
}