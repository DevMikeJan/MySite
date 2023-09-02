<?php 

declare(strict_types=1);

namespace app\libraries;

    class Routes {

       public static function get($routes, $function)
       {
            $url = self::getUrl();

            //check if the url is not empty
            if(empty($url[0])){
                //set the url to home page
                $url[0] = '/';
            }
            
            if($url[0] == $routes){
                //call_user_func($function);
                $function->__invoke();
            }
       }

       public static function getUrl(){
        //check if the url is set
        if(isset($_GET['url'])){
            //remove the forward slash at the end of url
            $url = rtrim($_GET['url']. '/');

            //this should not allowing special characters that the url should not have
            $url = filter_var($url, FILTER_SANITIZE_URL);

            //breaking it into an array
            $url = explode('/', $url);

            
            return $url;
            }
        }

    }