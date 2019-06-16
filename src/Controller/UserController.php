<?php
namespace Controller;

use Repository\UserRepository;

class UserController extends DefaultController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
    }
    
    public function login(){
        if($_SERVER['REQUEST_METHOD'] === 'GET')
            require_once 'views/login.php';
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user = UserRepository::login(htmlspecialchars($_POST['username']),htmlspecialchars($_POST['password']));
            if($user){
                $_SESSION['userId'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
                UserRepository::makeOnLine($user);
                header("location:index.php");
            }else{
                $error_msg = 'Mot de passe incorrect !!';
                require_once 'views/login.php';
            }
        }
    }
    public function logout(){
        if($this->getUser()){
            UserRepository::makeOffLine($this->getUser());
            session_destroy();
        }
        header("location:index.php?ctrl=user&act=login");
    }
    public function connected(){
        $users = UserRepository::findConnected($this->getUser());
        $result = [];
        foreach ($users as $user){
            $result[] = $user->getUsername();
        }
        header('Content-Type: application/json');
        echo json_encode([
            'code' => 1,
            'users' => $result
        ]);
    }

    public function nonConnected(){
        $users = UserRepository::findConnected($this->getUser());
        $result = [];
        foreach ($users as $user){
            $result[] = $user->getUsername();
        }
        header('Content-Type: application/json');
        echo json_encode([
            'code' => 1,
            'users' => $result
        ]);
    }
}