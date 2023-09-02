<?php
declare(strict_types=1);

namespace app\controllers;
use App\libraries\Database as Conn;
class Controller
{
   
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function userPages($views){
        if(file_exists('../app/views/pages/' . $views . '.php')){
            return '../app/views/pages/' . $views . '.php';
        }
        else {
            die('Page does not exist');
        }
    }

    public function checkUserData($views, $data = []){
        if(file_exists('../app/views/Users/' . $views . '.php')){
            return '../app/views/Users/' . $views . '.php';
        }
        else {
            die('Page does not exist');
        }
    }

    public function sanitizingPost($post){
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        return $post;
    }   

}