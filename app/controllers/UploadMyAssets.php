<?php

namespace app\controllers;


class UploadMyAssets extends Controller {
    public $connection;

    public function __construct($conn){
        $this->assetModel = $this->model('AssetModel', $this->connection);
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

            $assets = [
                'asset_file_id' => rand(100000000,999999999),
                'asset_file_rar' => $_FILES['asset_file_rar'],
                'asset_img' => $_FILES['asset_img'],
                'asset_name' => trim($post['asset_name']),
                'asset_desc' => trim($post['asset_desc']),
                'asset_rar_ext' => '',
                'asset_img_ext' => '',
                'random_number_rar' => mt_rand(),
                'random_number_img' => mt_rand(),
                'uploader_id' => $_SESSION['user_id'],
                'uploader_name' => $_SESSION['user_fname'] & $_SESSION['user_mname'] &  $_SESSION['user_lname'],
                'uploaded_date' => date("Y-m-d H:i:s a"),
                'error_message' => ''
            ];


            $assetRar = $assets['asset_file_rar'];
            $assetImg = $assets['asset_img'];
            
            $assetRarFilName = $assetRar['name'];
            $assetImgFileName = $assetImg['name'];
		    $fileRarTmpName = $assetRar['tmp_name'];
		    $fileImgTmpName = $assetImg['tmp_name'];


            $explode_rar_file = explode('.', $assetRarFilName);
            $expload_img_file = explode('.', $assetImgFileName);
            $rarActualExt = strtolower(end($explode_rar_file));
            $imgActualExt = strtolower(end($expload_img_file));

            $assets['asset_rar_ext'] = $rarActualExt;
            $assets['asset_img_ext'] = $imgActualExt;

            
           //validatation starts here
           if (!$this->isProceedUpload($assets)) {
            return;
           }
           
           $movedRarFile = $assets['asset_name'] . $assets['random_number_rar']. "." . $rarActualExt;
           $moveImgFile = $assets['asset_name'] . $assets['random_number_img']. "." . $imgActualExt;
           $setPathForRarFileUpload = URLROOTADMINSIDE .'/public/uploadedAssets/'. basename($movedRarFile);
           $setPathForImgFileUpload = URLROOTADMINSIDE .'/public/uploadedAssets/'. basename($moveImgFile);
        

           $assets['random_number_rar'] = $movedRarFile;
           $assets['random_number_img'] = $moveImgFile;
                                                
           //move the file image to its respective path
           $movedRarFile = move_uploaded_file($fileRarTmpName, $setPathForRarFileUpload);
           $movedImgFile = move_uploaded_file($fileImgTmpName, $setPathForImgFileUpload);

           if(!$movedRarFile || !$movedImgFile){
            echo 'Moving the file failed';
            return;
            }

            if ($this->assetModel->chkExistingFile($this->connection, $assets)) {
                    echo 'File Already Exist';
                    return;
            }

            $isSave = $this->assetModel->fileUpload($this->connection, $assets);

            if ($isSave) {
                echo "File has been uploaded successfully";
            }
            else {
                echo "There was and error in uploading the file";
            }
           

        }
    }

    private function isProceedUpload($file){
        $returnVal;
        $assetRar = $file["asset_file_rar"];
        $assetImg = $file["asset_img"];
        
        $assetRarFilName = $assetRar['name'];
        $assetImgFileName = $assetImg['name'];
        $fileRarTmpName = $assetRar['tmp_name'];
        $fileImgTmpName = $assetImg['tmp_name'];
        $fileRarError = $assetRar['error'];
        $fileImgError = $assetImg['error'];
        $fileRarSize = $assetRar['size'];
        $fileImgSize = $assetImg['size'];
    
    
        $explode_rar_file = explode('.', $assetRarFilName);
        $expload_img_file = explode('.', $assetImgFileName);
        $rarActualExt = strtolower(end($explode_rar_file));
        $imgActualExt = strtolower(end($expload_img_file));
    
        $allowedRar = ['rar','zip'];
        $allowedIMG = ['jpg', 'jpeg', 'png', 'pdf'];
    
        $sizelimit = 90000000;
        $errorfile = 0;
    
        $valid_file_name = "/^[a-z A-Z 0-9]*$/";
        $limitDescription = 255;
    
        $returnVal = true;
    
            if(in_array($rarActualExt, $allowedRar)){
                
                if(in_array($imgActualExt, $allowedIMG)){
                    if($fileRarError == $errorfile){
                        if($fileImgError == $errorfile){
                            if($fileRarSize <= $sizelimit){
                                if($fileImgSize <= $sizelimit){
    
                                    if(!empty($file['asset_name']) && !empty($file['asset_desc'])){
                                        if(preg_match($valid_file_name, $file['asset_name'])){
                                            if (strlen($file['asset_desc']) < $limitDescription) {
                                                $returnVal = true;
                                            }
                                            else {
                                                echo "Description Is Too Long";
                                                $returnVal = false;
                                            }
                                        }
                                        else {
                                            echo "Please input valid name";
                                            $returnVal = false;
                                        }
                                    }
                                    else {
                                        echo "Please input name and description";
                                            $returnVal = false;
                                    }
                                }
                                else {
                                    echo "Please Impit Valid File Name";
                                    $returnVal = false;
                                }
                            }
                            else {
                                echo "Rar File Is Too big";
                                $returnVal = false;
                            }
                        }
                        else {
                            echo "Image File Error";
                            $returnVal = false;
                        }
                    }
                    else {
                        echo "Rar File Error";
                        $returnVal = false;
                    }
                }
                else {
                    echo "Please Input valid image file";
                    $returnVal = false;
                }
            }
            else {
                echo "Only Rar Files is allowed to upload";
                $returnVal = false;
            }
    
            return $returnVal;
       }
}