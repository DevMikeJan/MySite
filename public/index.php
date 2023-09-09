<?php 

require __DIR__ . '/../vendor/autoload.php';
require_once '../app/config/Config.php';
require_once '../app/helpers/session.php';
use App\libraries\Database;
use App\libraries\Routes;
use App\controllers\Controller;
use App\controllers\HomeCtrler;
use App\controllers\RegistrationCtrler;
use App\controllers\LoginCtrler;
use App\controllers\LogoutCtrler;
use App\controllers\AssetsCtrler;
use App\controllers\AccountCtrler;

//echo rand(100000000,999999999);




Routes::get('/', function(){
    $database = new Database();
    $home = new HomeCtrler($database);
    $home->homeView('index');
});

Routes::get('Register', function(){
    $database = new Database();
    $login = new RegistrationCtrler($database);
    $login->viewPage('register');
});

Routes::get('Login', function(){
    $database = new Database();
    $login = new LoginCtrler($database);
    $login->viewPage('login');
});

Routes::get('Logout', function(){
    $database = new Database();
    $logout = new LogoutCtrler($database);
    $logout->logout();
});

Routes::get('Asset', function(){
    $database = new Database();
    $assets = new AssetsCtrler($database);
    $assets->viewPage('assets');
});

Routes::get('AssetInfo', function(){
    $database = new Database();
    $assetInfo = new AssetsCtrler($database);
    $assetInfo->loadAssetInfo();
});

Routes::get('RateAsset', function(){
    $database = new Database();
    $rateAsset = new AssetsCtrler($database);
    $rateAsset->setReview();
});

Routes::get('Reviews', function(){
    $database = new Database();
    $getReviews = new AssetsCtrler($database);
    $getReviews->getReviews();
});

Routes::get('CheckReviewed', function(){
    $database = new Database();
    $chckIfReviewed = new AssetsCtrler($database);
    $chckIfReviewed->chckIfReviewed();
});


Routes::get('Profile', function(){
    $database = new Database();
    $viewProfile = new AccountCtrler($database);
    $viewProfile->viewProfile('accountProfile');
});

Routes::get('UploadProfilePic', function(){
    $database = new Database();
    $viewProfile = new AccountCtrler($database);
    $viewProfile->uploadProfilePicAndCover(PROFILEPIC);
});

Routes::get('UploadCoverPhoto', function(){
    $database = new Database();
    $viewProfile = new AccountCtrler($database);
    $viewProfile->uploadProfilePicAndCover(PROFILECOVER);
});






