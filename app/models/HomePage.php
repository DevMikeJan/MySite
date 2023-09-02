<?php

class HomePage {
    public function getBanner($conn){
        $pdo = $conn->openCon("MYSITE_USERS");

        try {
            $pdo->settAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
        }catch (PDOException $e) {
            
        }
        
    }
}