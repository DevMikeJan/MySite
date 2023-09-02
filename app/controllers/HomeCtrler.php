<?php
declare(strict_types=1);

namespace app\controllers;

    class HomeCtrler extends Controller{
        public $conString;

        public function __construct($conn){
            $this->userModel = $this->model('HomePage');
            $this->connection = $conn;
        }

        public function homeView($view) {
            require_once $this->userPages($view);
        }

        
    }