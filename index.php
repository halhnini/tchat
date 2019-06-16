<?php
session_start();
require_once "autoload.php";
use Controller\UserController;
use Controller\AppController;
use Controller\MessageController;


if (isset($_GET['ctrl']) && isset($_GET['act'])) {
    $controller = $_GET['ctrl'];
    $action     = $_GET['act'];
} else {
    $controller = 'App';
    $action     = 'home';
}
if(!isset($_SESSION['username'])){
    $controller = 'User';
    $action     = 'login';
}
function call($controller, $action) {
    require_once('src/Controller/' . $controller . 'Controller.php');
    switch($controller) {
        case 'User':
            $controller = new UserController();
            break;
        case 'App':
            $controller = new AppController();
            break;
        case 'Message':
            $controller = new MessageController();
            break;
    }
    $controller->{ $action }();
}
$controllers = [
    'App' => ['home', 'error404'],
    'User' => ['login', 'logout','connected'],
    'Message' => ['create','refresh']
    ];

if (array_key_exists($controller, $controllers) AND in_array($action, $controllers[$controller]))
    call($controller, $action);
else
    call('App', 'error404');