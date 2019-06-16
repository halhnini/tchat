<?php
namespace Controller;

use Repository\MessageRepository;
use Repository\UserRepository;

class AppController extends DefaultController
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
    }

    public function home(){
        $user = $this->getUser();
        $usersConnected = UserRepository::findConnected($user);
        $usersNonConnected = UserRepository::findNonConnected($user);
        $messages = MessageRepository::findBy(array('id_receiver' => null),['date_created'=>'DESC'],50,0);
        require_once 'views/layout.php';
    }

    public function error404(){
        require_once 'views/404.html';
    }

}