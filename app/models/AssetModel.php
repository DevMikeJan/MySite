<?php


class AssetModel {


    public function getUploadedAssets($conn) {
        $conn->query('SELECT * FROM ASSETS_UPLOAD LIMIT 20');

        $conn->execute();
        $row = $conn->rowCount();
        $fetch = $conn->fetchAll();

        return ($row > 0) ? $fetch : false;
    }

    public function getSpecificData($conn, $id) {
        $conn->query('SELECT DISTINCT A.* , B.REF_ASSET_NO 
                      FROM ASSETS_UPLOAD A LEFT JOIN ASSET_REVIEWS B
                      ON A.ASSETFILE_ID = B.REF_ASSET_NO 
                      WHERE A.ASSETFILE_ID = :ASSETFILE_ID');

        $conn->bind(':ASSETFILE_ID', $id);
        $conn->execute();
        $row = $conn->rowCount();
        $fetch = $conn->fetchAll();

        return ($row > 0) ? $fetch : false;
    }


    public function setReview($conn, $reviewData){
        $conn->query('INSERT INTO ASSET_REVIEWS(REF_ASSET_NO,ASSET_REVIEW_STARS,ASSET_REVIEW_COMMENT,
                                                REVIEW_BY_ID,REVIEW_BY_NAME,REVIEW_DATE,REVIEW_ASSET_UNIQUE_ID)
                                         VALUES(:REF_ASSET_NO,:ASSET_REVIEW_STARS,:ASSET_REVIEW_COMMENT,
                                                :REVIEW_BY_ID,:REVIEW_BY_NAME,:REVIEW_DATE,:REVIEW_ASSET_UNIQUE_ID)');

        $conn->bind(':REF_ASSET_NO', $reviewData['asset_ref_no']);
        $conn->bind(':ASSET_REVIEW_STARS', $reviewData['asset_review_stars']);
        $conn->bind(':ASSET_REVIEW_COMMENT', $reviewData['asset_review_comment']);
        $conn->bind(':REVIEW_BY_ID', $reviewData['review_by_id']);
        $conn->bind(':REVIEW_BY_NAME', $reviewData['review_by_name']);
        $conn->bind(':REVIEW_DATE', $reviewData['review_date']);
        $conn->bind(':REVIEW_ASSET_UNIQUE_ID', $reviewData['asset_id']);
        $inserted = $conn->execute();

        if($inserted){
            return true;
        }
        else {
            return false;
        }
    }

    public function getReviews($conn, $assetID) {
        $conn->query('SELECT A.*, B.* FROM ASSET_REVIEWS A LEFT JOIN USER_PROFILE_IMG B
                      ON A.REVIEW_BY_ID = B.USER_CONTROL_NO WHERE A.REF_ASSET_NO = :REF_ASSET_NO
                      ORDER BY REVIEW_DATE DESC');

        $conn->bind(':REF_ASSET_NO', $assetID);
        $conn->execute();
        $row = $conn->rowCount();
        $fetch = $conn->fetchAll();

        return ($row > 0) ? $fetch : false;
    }


    public function isAlreadyReviewed($conn, $assetID, $userID) {
        $conn->query('SELECT * FROM ASSET_REVIEWS WHERE REF_ASSET_NO = :REF_ASSET_NO AND REVIEW_BY_ID = :REVIEW_BY_ID');

        $conn->bind(':REF_ASSET_NO', $assetID);
        $conn->bind(':REVIEW_BY_ID', $userID);
        $conn->execute();
        $row = $conn->rowCount();
        $fetch = $conn->fetchAll();

        return ($row > 0) ? true : false;
    }

    public function chkIfIdExist($conn, $id) {
        $conn->query('SELECT * FROM ASSET_REVIEWS WHERE REVIEW_ASSET_UNIQUE_ID = :REVIEW_ASSET_UNIQUE_ID');

        $conn->bind(':REVIEW_ASSET_UNIQUE_ID', $id);
        $conn->execute();
        $row = $conn->rowCount();
        $fetch = $conn->fetchAll();

        return ($row > 0) ? true : false;
    }

    public function chkExistingFile($conn, $data) {
        $conn->query('SELECT * FROM ASSETS_UPLOAD WHERE ASSET_RAR_RAN_NUM = :ASSET_RAR_RAN_NUM
                      OR ASSET_IMG_RAN_NUM = :ASSET_IMG_RAN_NUM OR ASSETFILE_ID = :ASSETFILE_ID');

        $conn->bind(':ASSET_RAR_RAN_NUM', $data['random_number_rar']);
        $conn->bind(':ASSET_IMG_RAN_NUM', $data['random_number_img']);
        $conn->bind(':ASSETFILE_ID', $data['asset_file_id']);
        $conn->execute();
            
        //check if the email is already taken
        return ($conn->rowCount() > 0) ? true : false;
    }

    public function fileUpload($conn, $data) {
        $conn->query('INSERT INTO ASSETS_UPLOAD(ASSETFILE_ID, ASSET_NAME, ASSET_DESC, ASSET_FILE_NAME, ASSET_RAR_FILE_EXT,
                                                ASSET_IMG_FILE_EXT, ASSET_RAR_RAN_NUM, ASSET_IMG_RAN_NUM,ASSET_DEVELOPER_ID,
                                                ASSET_DEVELOPER_BY, ASSET_UPLOADED_DATE)
                                        VALUES (:ASSETFILE_ID, :ASSET_NAME, :ASSET_DESC, :ASSET_FILE_NAME, :ASSET_RAR_FILE_EXT,
                                                :ASSET_IMG_FILE_EXT, :ASSET_RAR_RAN_NUM, :ASSET_IMG_RAN_NUM, :ASSET_DEVELOPER_ID,
                                                :ASSET_DEVELOPER_BY, :ASSET_UPLOADED_DATE)');

        $conn->bind(':ASSETFILE_ID', $data['asset_file_id']);
        $conn->bind(':ASSET_NAME', $data['asset_name']);
        $conn->bind(':ASSET_DESC', $data['asset_desc']);
        $conn->bind(':ASSET_FILE_NAME', $data['asset_name']);
        $conn->bind(':ASSET_RAR_FILE_EXT', $data['asset_rar_ext']);
        $conn->bind(':ASSET_IMG_FILE_EXT', $data['asset_img_ext']);
        $conn->bind(':ASSET_RAR_RAN_NUM', $data['random_number_rar']);
        $conn->bind(':ASSET_IMG_RAN_NUM', $data['random_number_img']);
        $conn->bind(':ASSET_DEVELOPER_ID', $data['uploader_id']);
        $conn->bind(':ASSET_DEVELOPER_BY', $data['uploader_name']);
        $conn->bind(':ASSET_UPLOADED_DATE', $data['uploaded_date']);
        $inserted = $conn->execute();

        if($inserted){
            return true;
        }
        else {
            return false;
        }
    }

}