<?php

namespace app\controllers;


class AccountCtrler extends Controller {
    public $connection;

    public function __construct($conn){
        $this->userModel = $this->model('UserModel', $this->connection);
        $this->connection = $conn;
    }

    public function viewProfile($view){
        $getAllRecentActitives = $this->userModel->getActitivites($this->connection, $_SESSION['user_id']);
        require_once $this->checkUserData($view);
    }

    public function uploadProfilePicAndCover($trans){
        $user_data = [
            'user_id' => '',
            'img' => '',
            'acctFile' => '' ,
            'dateUpload' => '',
            'randomNum' => ''
            ];

            if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
                $post = $this->sanitizingPost($_POST);

                $user_data = [
                    'user_id' => $post['user_id'],
                    'img' => $_FILES['img'],
                    'acctFile' => '' ,
                    'dateUpload' => date("Y-m-d H:i:s a") ,
                    'randomNum' => mt_rand()
                    ];

                    $fileImg = $user_data['img'];

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

                                IF ($trans === PROFILEPIC) {
                                    $setPathForFileUpload = OUTSIDEPROJ .'/MySiteAdminSide/public/profilePics/'. basename($fileToMove);
                                }
                                ELSEIF ($trans === PROFILECOVER) {
                                    $setPathForFileUpload = OUTSIDEPROJ .'/MySiteAdminSide/public/coverPhoto/'. basename($fileToMove);
                                }
                               
                                $movedImgFile = move_uploaded_file($fileTmpName, $setPathForFileUpload);

                                if ($movedImgFile){

                                    IF ($trans === PROFILEPIC) {
                                        $isExist = $this->userModel->chkExistingProfile($this->connection, 'USER_PROFILE_IMG', $user_data);
                                    
                                        if (!$isExist) {
                                            $isUploaded = $this->userModel->uploadProfilePic($this->connection, $user_data);
                                        }
                                        else {
                                            $isUploaded = $this->userModel->uptDateProfilePic($this->connection, $user_data);
                                        }
                                    }
                                    ELSEIF ($trans === PROFILECOVER) {
                                        $isExist = $this->userModel->chkExistingProfile($this->connection, 'USER_COVER_PHOTO', $user_data);

                                        if (!$isExist) {
                                            $isUploaded = $this->userModel->uploadProfileCover($this->connection, $user_data);
                                        }
                                        else {
                                            $isUploaded = $this->userModel->uptDateProfileCover($this->connection, $user_data);
                                        }
                                    }
                                   
                                    IF ($isUploaded) {
                                        IF ($trans === PROFILEPIC) {
                                            $getUploaded = $this->userModel->getProfilePic($this->connection,$user_data['user_id']);
                                            $_SESSION['profile_pic'] = $getUploaded->PROFILE_IMG;
                                            echo $getUploaded->PROFILE_IMG;
                                        }
                                        ELSEIF ($trans === PROFILECOVER) {
                                            $getUploaded = $this->userModel->getCoverPic($this->connection,$user_data['user_id']);
                                            $_SESSION['cover_pic'] = $getUploaded->COVER_IMG;
                                            echo $getUploaded->COVER_IMG;
                                        }
                                       
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