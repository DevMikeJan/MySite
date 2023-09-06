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
}