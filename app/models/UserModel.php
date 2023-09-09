<?php


class UserModel  {
    public function chkExistingUser($conn, $whereData, $userData, $placeholder){
        $conn->query('SELECT * FROM USER_LOGIN_CREDENTIALS WHERE '. $whereData . '=' .$placeholder);

        $conn->bind($placeholder, $userData);
        $conn->execute();
            
        //check if the email is already taken
        return ($conn->rowCount() > 0) ? true : false;
    }

    public function chkExistingUID($conn, $USER_ID){
        $conn->query('SELECT * FROM USER_INFO WHERE USER_ID = :USER_ID');

        $conn->bind(':USER_ID', $USER_ID);
        $conn->execute();
        return ($conn->rowCount() > 0) ? true : false;
    }

    public function registerUser($con, $data) {
        $pdo = $con->openCon("MYSITE_USERS");
        $dateJoined  = date("Y-m-d H:i:s a");

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();


            $userInfo = 'INSERT INTO USER_INFO (USER_ID, FNAME, MNAME, LNAME, AGE, GENDER, ADDRESS, Date_Joined)
                                        VALUES (:USER_ID, :FNAME, :MNAME, :LNAME, :AGE, :GENDER, :ADDRESS, :Date_Joined)';

       
        $statement = $pdo->prepare($userInfo);
        $statement->bindValue(":USER_ID", $data['UID'],PDO::PARAM_STR);
        $statement->bindValue(":FNAME", $data['user_fname'],PDO::PARAM_STR);
        $statement->bindValue(":MNAME", $data['user_mname'],PDO::PARAM_STR);
        $statement->bindValue(":LNAME", $data['user_lname'],PDO::PARAM_STR);
        $statement->bindValue(":AGE", $data['user_age'],PDO::PARAM_INT);
        $statement->bindValue(":GENDER", $data['user_gender'],PDO::PARAM_STR);
        $statement->bindValue(":ADDRESS", $data['user_address'],PDO::PARAM_STR);
        $statement->bindValue(":Date_Joined", $dateJoined,PDO::PARAM_STR);
        $statement->execute();

       // $lastInsertedID = $pdo->lastInsertId();

       
        $userLoginInfo = 'INSERT INTO USER_LOGIN_CREDENTIALS (USER_ID, EMAIL, UNAME, UPASS, ACTIVE, USER_ACCESS)
                                                      VALUES (:USER_ID, :EMAIL, :UNAME, :UPASS, :ACTIVE, :USER_ACCESS)';

        $statement2 = $pdo->prepare($userLoginInfo);
        $statement2->bindValue(":USER_ID", $data['UID'],PDO::PARAM_STR);
        $statement2->bindValue(":EMAIL", $data['user_email'],PDO::PARAM_STR);
        $statement2->bindValue(":UNAME", $data['user_uname'],PDO::PARAM_STR);
        $statement2->bindValue(":UPASS", $data['user_password'],PDO::PARAM_STR);
        $statement2->bindValue(":ACTIVE", 1,PDO::PARAM_BOOL);
        $statement2->bindValue(":USER_ACCESS", 2,PDO::PARAM_INT);
        $statement2->execute();
        $pdo->commit();

        }catch (PDOException $e) {
             $pdo->rollback();
             echo $e->getMessage();
        }
    }

    public function login($con, $data, $userPassword){
        $con->query('SELECT A.*, B.* FROM USER_INFO A 
                     INNER JOIN USER_LOGIN_CREDENTIALS B
                     ON A.USER_ID = B.USER_ID
                     WHERE B.UNAME = :user_uname_email 
                     OR B.EMAIL = :user_uname_email');

            $con->bind(':user_uname_email', $data);
            $con->execute();
            $row = $con->single();
            
            $dehashedPass = $row->UPASS;
            
            //check if password match
            return (password_verify($userPassword, $dehashedPass)) ? $row : false;
    }

    public function generateUserID($con, $len) {
        $con->query('SELECT MAX(USER_ID) AS USERID FROM USER_INFO ORDER BY USER_ID DESC');
        $con->execute();

        $rows = $con->fetchAll();
        return $rows;
    }

    public function uptStatActive($con, $data){
        $con->query('UPDATE USER_LOGIN_CREDENTIALS SET ACTIVE = :ACTIVE WHERE UNAME = :user_uname_email OR EMAIL = :user_uname_email');
        $con->bind(':user_uname_email', $data['user_uname_email']);  
        $con->bind(':ACTIVE', $data['user_status']);

        return ($con->execute()) ? true : false;
    }


    public function uploadProfilePic($con, $data){
        $con->query('INSERT INTO USER_PROFILE_IMG(USER_CONTROL_NO, PROFILE_IMG, UPLOADED_DATE)
                                           VALUES(:USER_CONTROL_NO, :PROFILE_IMG, :UPLOADED_DATE)');

        $con->bind(':USER_CONTROL_NO', $data['user_id']);    
        $con->bind(':PROFILE_IMG', $data['acctFile']);   
        $con->bind(':UPLOADED_DATE', $data['dateUpload']);      
        
        $inserted = $con->execute();

        if($inserted){
            return true;
        }
        else {
            return false;
        }
    }

    public function uploadProfileCover($con, $data){
        $con->query('INSERT INTO USER_COVER_PHOTO(USER_CONTROL_NO, COVER_IMG, UPLOADED_DATE)
                                           VALUES(:USER_CONTROL_NO, :COVER_IMG, :UPLOADED_DATE)');

        $con->bind(':USER_CONTROL_NO', $data['user_id']);    
        $con->bind(':COVER_IMG', $data['acctFile']);   
        $con->bind(':UPLOADED_DATE', $data['dateUpload']);      
        
        $inserted = $con->execute();

        if($inserted){
            return true;
        }
        else {
            return false;
        }
    }

    public function uptDateProfilePic($con, $data){
        $con->query('UPDATE USER_PROFILE_IMG SET PROFILE_IMG = :PROFILE_IMG, UPLOADED_DATE = :UPLOADED_DATE
                     WHERE USER_CONTROL_NO = :USER_CONTROL_NO');

        $con->bind(':USER_CONTROL_NO', $data['user_id']);    
        $con->bind(':PROFILE_IMG', $data['acctFile']);   
        $con->bind(':UPLOADED_DATE', $data['dateUpload']);      
        
        $inserted = $con->execute();

        if($inserted){
            return true;
        }
        else {
            return false;
        }
    }

    public function uptDateProfileCover($con, $data){
        $con->query('UPDATE USER_COVER_PHOTO SET COVER_IMG = :COVER_IMG, UPLOADED_DATE = :UPLOADED_DATE
                     WHERE USER_CONTROL_NO = :USER_CONTROL_NO');

        $con->bind(':USER_CONTROL_NO', $data['user_id']);    
        $con->bind(':COVER_IMG', $data['acctFile']);   
        $con->bind(':UPLOADED_DATE', $data['dateUpload']);      
        
        $inserted = $con->execute();

        if($inserted){
            return true;
        }
        else {
            return false;
        }
    }



    public function getProfilePic($con, $data){
        $con->query('SELECT * FROM USER_PROFILE_IMG WHERE USER_CONTROL_NO = :USER_CONTROL_NO');

        $con->bind(':USER_CONTROL_NO', $data); 
        $con->execute();     
        $rows = $con->single();
        return $rows;                
    }

    public function getCoverPic($con, $data){
        $con->query('SELECT * FROM USER_COVER_PHOTO WHERE USER_CONTROL_NO = :USER_CONTROL_NO');

        $con->bind(':USER_CONTROL_NO', $data); 
        $con->execute();     
        $rows = $con->single();
        return $rows;                
    }
    

    public function chkExistingProfile($con, $table, $data){
        $con->query('SELECT * FROM '. $table .' WHERE USER_CONTROL_NO = :USER_CONTROL_NO');

        $con->bind(':USER_CONTROL_NO', $data['user_id']); 
        $con->execute();   
        $row = $con->rowCount();

        return ($row > 0) ? true : false;
    }
}