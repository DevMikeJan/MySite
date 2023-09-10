<?php

namespace app\controllers;


class UploadMyAssets extends Controller {
    public $connection;

    public function __construct($conn){
        $this->userModel = $this->model('UserModel', $this->connection);
        $this->connection = $conn;
    }

    public function viewPage($view){
        require_once $this->checkUserData($view);
    }

    public function uploadAsset(){
        $assets = [
            'asset_file_id' => '',
            'asset_file_rar' => '',
            'asset_img' => '',
            'asset_name' => '',
            'asset_desc' => '',
            'asset_rar_ext' => '',
            'asset_img_ext' => '',
            'random_number_rar' => '',
            'random_number_img' => '',
            'uploader_id' => '',
            'uploader_name' => '',
            'uploaded_date' => '',
            'process_msg' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){  
            $post = $this->sanitizingPost($_POST);
         
            if(empty($_FILES['asset_file_rar']) || empty($_FILES['asset_img'])) {
                //check if the files is undefined
                $assets['process_msg'] = "Please Select File";
                echo $assets["process_msg"];
                return;
            }

        }
    }
}