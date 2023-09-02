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
        $conn->query('SELECT * FROM ASSETS_UPLOAD WHERE ASSETFILE_ID = :ASSETFILE_ID');

        $conn->bind(':ASSETFILE_ID', $id);
        $conn->execute();
        $row = $conn->rowCount();
        $fetch = $conn->fetchAll();

        return ($row > 0) ? $fetch : false;
    }


    public function setReview($conn, $reviewData){
        $conn->query('INSERT INTO ASSET_REVIEWS(REF_ASSET_NO,ASSET_REVIEW_STARS,ASSET_REVIEW_COMMENT,
                                                REVIEW_BY_ID,REVIEW_BY_NAME,REVIEW_DATE)
                                         VALUES(:REF_ASSET_NO,:ASSET_REVIEW_STARS,:ASSET_REVIEW_COMMENT,
                                                :REVIEW_BY_ID,:REVIEW_BY_NAME,:REVIEW_DATE)');

        $conn->bind(':REF_ASSET_NO', $reviewData['asset_ref_no']);
        $conn->bind(':ASSET_REVIEW_STARS', $reviewData['asset_review_stars']);
        $conn->bind(':ASSET_REVIEW_COMMENT', $reviewData['asset_review_comment']);
        $conn->bind(':REVIEW_BY_ID', $reviewData['review_by_id']);
        $conn->bind(':REVIEW_BY_NAME', $reviewData['review_by_name']);
        $conn->bind(':REVIEW_DATE', $reviewData['review_date']);
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
}