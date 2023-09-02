<?php

namespace app\controllers;

class AssetsCtrler extends Controller {
    public $connection;

    public function __construct($conn){
        $this->assetModel = $this->model('AssetModel', $this->connection);
        $this->connection = $conn;
        
    }


    public function viewPage($view) {

        // $myArr = array("John", "Mary", "Peter", "Sally");

        // $myJSON = json_encode($myArr);

        // echo $myJSON;


        $assetList = $this->showUploadedAssets();
        require_once $this->userPages($view);
    }

    public function showUploadedAssets(){
        $fetchAssets = $this->assetModel->getUploadedAssets($this->connection);

        return $fetchAssets;
    }

    public function loadAssetInfo(){
        $assets = [
            'asset_id' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){  
            $post = $this->sanitizingPost($_POST);

            $assets = [
                'asset_id' =>  $post['asset_id']
            ];

            $getSpecificData = $this->assetModel->getSpecificData($this->connection,$assets['asset_id']);

            echo json_encode($getSpecificData);
        }
    }

    public function setReview() {
        $reviews = [
            'asset_ref_no' => '',
            'asset_review_stars' => '',
            'asset_review_comment' => '',
            'review_by_id' => '',
            'review_by_name' => '',
            'review_date'=> '',
            'response_msg'=>''
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
            $post = $this->sanitizingPost($_POST);

            $assets = [
                'asset_ref_no' =>  $post['asset_ref_no'],
                'asset_review_stars' => $post['asset_review_stars'],
                'asset_review_comment' => $post['asset_review_comment'],
                'review_by_id' => $post['review_by_id'],
                'review_by_name' => $post['review_by_name'],
                'review_date'=> date("Y-m-d H:i:s a"),
                'response_msg'=>''
            ];

            $isSave = $this->assetModel->setReview($this->connection,$assets);
                    
            if ($isSave) {
                echo 'Thanks For Rating Us';
            }
        }
    }

    public function getReviews() {

        $reviews = [
            'asset_ref_no' => '',
            'response_msg'=>''
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
            $post = $this->sanitizingPost($_POST);

            $assets = [
                'asset_ref_no' =>  $post['asset_ref_no'],
                'response_msg'=>''
            ];
            $getReview =  $this->assetModel->getReviews($this->connection,$assets['asset_ref_no']);
            echo json_encode($getReview);
        }
       
    }


}