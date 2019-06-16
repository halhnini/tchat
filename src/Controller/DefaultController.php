<?php
namespace Controller;

use Repository\UserRepository;
use Entity\User;

class DefaultController
{
    /**
     * @return User|null
     */
    public function getUser(){
        if(!isset($_SESSION['username']))
            return null;
        else
            return UserRepository::findByUsername($_SESSION['username']);
    }
}