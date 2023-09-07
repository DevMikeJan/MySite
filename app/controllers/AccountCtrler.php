<?php

namespace app\controllers;


class AccountCtrler extends Controller {
    public $connection;

    public function __construct($conn){
        $this->userModel = $this->model('UserModel', $this->connection);
        $this->connection = $conn;
        
    }

    public function viewProfile($view){

        require_once $this->checkUserData($view);
    }

    public function uploadProfilePic(){
        $user_data = [
            'user_id' => '',
            'profilePic' => '',
            'acctFile' => '' ,
            'dateUpload' => '',
            'randomNum' => ''
            ];

            if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
                $post = $this->sanitizingPost($_POST);

                $user_data = [
                    'user_id' => $post['user_id'],
                    'profilePic' => $_FILES['profilePic'],
                    'acctFile' => '' ,
                    'dateUpload' => date("Y-m-d H:i:s a") ,
                    'randomNum' => mt_rand()
                    ];

                    $fileImg = $user_data['profilePic'];

                    $profileFileName = $fileImg['name'];
                    $fileTmpName = $fileImg['tmp_name'];
                    $fileError = $fileImg['error'];
                    $fileSize = $fileImg['size'];

                    

                    $explode_file = explode('.', $profileFileName);
                    $actualExt = strtolower(end($explode_file));

                    $allowedIMG = ['jpg', 'jpeg', 'png', 'pdf'];
                
                    $sizelimit = 90000000;
                    $errorfile = 0;

                    $user_data['acctFile'] =  $user_data['user_id'] . $user_data['randomNum']. "." . $actualExt;
                
                    $valid_file_name = "/^[a-z A-Z 0-9]*$/";
        
                    if(in_array($actualExt, $allowedIMG)){
                        if($fileError == $errorfile){
                            if($fileSize <= $sizelimit){

                                $fileToMove = $user_data['acctFile'];
                                $setPathForFileUpload = OUTSIDEPROJ .'/MySiteAdminSide/public/profilePics/'. basename($fileToMove);
                                $movedImgFile = move_uploaded_file($fileTmpName, $setPathForFileUpload);

                                if ($movedImgFile){

                                    $isExist = $this->userModel->chkExistingProfile($this->connection, $user_data);
                                    
                                    if (!$isExist) {
                                        $isUploaded = $this->userModel->uploadProfilePic($this->connection, $user_data);
                                    }
                                    else {
                                        $isUploaded = $this->userModel->uptDateProfilePic($this->connection, $user_data);
                                    }
                                    
                                    IF ($isUploaded) {
                                        echo json_encode($this->userModel->getProfilePic($this->connection, $user_data));
                                    }
                                }
                            }
                            else {
                                echo 'File is too large';
                            }
                        }
                        else {
                            echo 'File Error';
                        }
                    }
                    else {
                        echo 'Please input valid image';
                    }
            }
    }

}