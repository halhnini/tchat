<?php
namespace Repository;

use Config\Connection;
use Entity\User;

class UserRepository
{
    /**
     * @param $username
     * @return User|null
     */
    public static function findByUsername($username){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindValue(':username', $username);
        $query->execute();
        if($query->rowCount() > 0){
            $data = (array)$query->fetchObject();
            $user = new User();
            $user->setUsername($data['username']);
            $user->setPassword($data['password']);
            $user->setId($data['id']);
            return $user;
        }else
            return null;
    }
    /**
     * @param $username
     * @param $password
     * @return User|null
     */
    public static function login($username,$password){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $query->bindValue(':username', $username);
        $query->bindValue(':password', $password);
        $query->execute();
        if($query->rowCount() > 0){
            $data = (array)$query->fetchObject();
            $user = new User();
            $user->setUsername($data['username']);
            $user->setPassword($data['password']);
            $user->setId($data['id']);
            return $user;
        }else{
            if(self::findByUsername($username))
                return null;
            else{
                return self::signUp($username,$password);
            }
        }
    }
    /**
     * @param $username
     * @param $password
     * @return User|null
     */
    public static function signUp($username,$password){
        if(self::findByUsername($username))
            return null;
        try{
            $pdo = Connection::getInstance();
            $query = $pdo->prepare("INSERT INTO `users` (`username`, `password`) VALUES (:username, :password)");
            $query->bindValue(':username', $username);
            $query->bindValue(':password', $password);
            $pdo->beginTransaction();
            $query->execute();
            $id = $pdo->lastInsertId();
            $result = $pdo->commit();
            if($id and $result){
                $user = new User();
                $user->setId($id);
                $user->setUsername($username);
                $user->setPassword($password);
                return $user;
            }
            return null;
        }catch (\PDOException $e){
            $pdo->rollBack();
        }
    }
    /**
     * @param $username
     */
    public static function makeOnLine(User $user){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("UPDATE users SET online = '1' WHERE id = ?");
        $query->execute([$user->getId()]);
    }
    /**
     * @param $username
     */
    public static function makeOffLine(User $user){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("UPDATE users SET online = '0' WHERE id = ?");
        $query->execute([$user->getId()]);
    }
    /**
     * @param User $curentUser
     * @return array
     */
    public static function findConnected(User $curentUser){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("SELECT * FROM users WHERE online = '1' AND id <> ?");
        $query->execute([$curentUser->getId()]);
        $users = [];
        foreach($query->fetchAll() as $row) {
            $user = new User();
            $user->setUsername($row['username']);
            $user->setId($row['id']);
            $users[] = $user;
        }
        return $users;
    }

    /**
     * @param User $curentUser
     * @return array
     */
    public static function findNonConnected(User $curentUser){
        $pdo = Connection::getInstance();
        $query = $pdo->prepare("SELECT * FROM users WHERE online = '0' AND id <> ?");
        $query->execute([$curentUser->getId()]);
        $users = [];
        foreach($query->fetchAll() as $row) {
            $user = new User();
            $user->setUsername($row['username']);
            $user->setId($row['id']);
            $users[] = $user;
        }
        return $users;
    }
    
}