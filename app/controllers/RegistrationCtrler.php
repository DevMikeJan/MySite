<?php

namespace app\controllers;
class RegistrationCtrler extends Controller {
    public $connection;

    public function __construct($conn){
        $this->userModel = $this->model('UserModel', $this->connection);
        $this->connection = $conn;
        
    }

    public function viewPage($view) {
        $datas = [
            'title' => 'Register page',
            'UID' => '',
            'user_fname' => '',
            'user_mname' => '',
            'user_lname' => '',
            'user_age' => '',
            'user_gender' => '',
            'user_address' => '',
            'user_uname' => '',
            'user_email' => '',
            'user_password' => '',
            'confirmedPassword' => '',
            'error_message' => '',
            'fname_error' => '',
            'mname_error' => '',
            'lname_error' => '',
            'age_error' => '',
            'gender_error' => '',
            'address_error' => '',
            'uname_error' => '',
            'email_error' => '',
            'pass_error' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);//sanitizing post data

            $datas = [
                'title' => 'Register page',
                'UID' => '',
                'user_fname' => trim($_POST['user_fname']),
                'user_mname' => trim($_POST['user_mname']),
                'user_lname' => trim($_POST['user_lname']),
                'user_age' => trim($_POST['user_age']),
                'user_gender' => trim($_POST['user_gender']),
                'user_address' => trim($_POST['user_address']),
                'user_uname' => trim($_POST['user_uname']),
                'user_email' => trim($_POST['user_email']),
                'user_password' => trim($_POST['user_password']),
                'confirmedPassword' => trim($_POST['confirmedPassword']),
                'fname_error' => '',
                'mname_error' => '',
                'lname_error' => '',
                'age_error' => '',
                'gender_error' => '',
                'address_error' => '',
                'uname_error' => '',
                'email_error' => '',
                'pass_error' => ''
            ];


            //validations
            $fullnameValidation = "/^[a-z A-Z]*$/";
            $usernameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

             //check first name
           if(empty($datas['user_fname'])) {
            $datas['fname_error'] = 'Empty field';
            }
            else if(!preg_match($fullnameValidation, $datas['user_fname'])) {
                    $datas['fname_error'] = 'Name must contain only letter';
            }

             //check middle name
           if(empty($datas['user_mname'])) {
            $datas['mname_error'] = 'Empty field';
            }
            else if(!preg_match($fullnameValidation, $datas['user_mname'])) {
                $datas['mname_error'] = 'Name must contain only letter';
            }

                //check last name
            if(empty($datas['user_lname'])) {
                    $datas['lname_error'] = 'Empty field';
            }
            else if(!preg_match($fullnameValidation, $datas['user_lname'])) {
                    $datas['lname_error'] = 'Name must contain only letter';
            }

             //check age
           if(empty($datas['user_age'])) {
                $datas['age_error'] = 'Empty field';
            }
            else if(!is_numeric($datas['user_age'])) {
                $datas['age_error'] = 'Age must be numeric';
            }

            //check address if empty
            if(empty($datas['user_address'])) {
                $datas['address_error'] = 'Empty field';
            }

            //check gender if empty
            if(empty($datas['user_gender'])) {
                $datas['gender_error'] = 'Empty field';
            }

            //check user name
           if(empty($datas['user_uname'])) {
            $datas['uname_error'] = 'Empty field';
            }
           else {
              //check if there is existing username
                if($this->userModel->chkExistingUser($this->connection,'UNAME', $datas['user_uname'], ':UNAME')) {
                    $datas['uname_error'] = 'Username already exist';
                }
            }

            //check email
           if(empty($datas['user_email'])) {
            $datas['email_error'] = 'Empty field';
            }
            else if(!filter_var($datas['user_email'], FILTER_VALIDATE_EMAIL)) {
                    $datas['email_error'] = 'Invalid email';
            }
            else {
                if($this->userModel->chkExistingUser($this->connection,'UNAME', $datas['user_email'], ':UNAME')) {
                        $datas['email_error'] = 'Email already exist';
                }
            }

              //check password
           if(empty($datas['user_password'])) {
            $datas['pass_error'] = 'Empty field';
            }
            else if(strlen($datas['user_password']) < 8) {
                    $datas['pass_error'] = 'Password must atleast 8 characters';
            }
            else if(preg_match($passwordValidation, $datas['user_password'])) {
                    $datas['pass_error'] = 'Password must have atleast one numeric';
            }
            else if($datas['user_password'] != $datas['confirmedPassword']) {
                    $datas['pass_error'] = 'Password not match';
            }
            else {
                    //check if the error messages are empty
                if(empty($datas['fname_error']) && empty($datas['mname_error']) && empty($datas['lname_error']) && 
                        empty($datas['age_error'] ) && empty($datas['address_error']) && empty($datas['gender_error']) &&
                        empty($datas['email_error']) && empty($datas['uname_error']) && empty($datas['pass_error'])){

                            //hashing the password 
                            $datas['user_password'] = password_hash($datas['user_password'], PASSWORD_DEFAULT);
                            $datas['UID'] = $this->generateUserID();

                            //register user
                            $userRegistered = $this->userModel->registerUser( $this->connection, $datas);

                            if($userRegistered) {
                                header('location: ' . URLROOT . '/');
                            }

                }
            }
        }

        require_once $this->checkUserData($view);
    }


    private function generateUserID() {
        $id;
        $subID = "USER" . date("Ym");
        $UserID = $subID .  "0000";

        $rows = $this->userModel->generateUserID($this->connection, 4);

        foreach($rows as $row) {
          $id = $row->USERID;

          if (is_null($id)){
            $returnVal = $UserID;

          }else {
            $returnVal = $this->generateNew($id,$subID,$id);

            $ifExist = $this->userModel->chkExistingUID($this->connection, $returnVal);

            while($ifExist) {
                $returnVal = $this->generateNew($id,$subID,$id);
                $ifExist = $this->userModel->chkExistingUID($this->connection, $returnVal);
            }
          }
        }

        return $returnVal;
    }

    private function generateNew($uid, $subUID, $UserID) {
        $returnVal;

        $returnVal = substr($uid,4,4);

            if ($returnVal != date("Y")) {
                $returnVal = $UserID;
            }else {
                $returnVal = substr($uid,10);

                $returnVal += 1;

                if (strlen($returnVal) == 1) {
                    $returnVal = $subUID ."000" .  $returnVal;
                }elseif (strlen($returnVal) == 2) {
                    $returnVal = $subUID ."00" .  $returnVal;
                }elseif (strlen($returnVal) == 3) {
                    $returnVal = $subUID . "0" .  $returnVal;
                }elseif (strlen($returnVal) == 4) {
                    $returnVal = $subUID . $returnVal;
                }
            }
            return $returnVal;
    }
}