<?php
namespace Repository;

use Config\Connection;
use Entity\Message;
use Entity\User;

class MessageRepository
{
    /**
     * @param array $criteria
     * @param array $order
     * @param null $limit
     * @param null $offset
     * @param null $lastShown
     * @return array
     */
    public static function findBy(array $criteria,array $order,$limit = null,$offset = null,$lastShown = null){
        $pdo = Connection::getInstance();
        $sql = "SELECT m.*,u.username AS USER FROM message AS m,users AS u WHERE m.id_user = u.id";
        if($lastShown)
            $sql.= " AND m.id > $lastShown";
        if(!empty($criteria)){
            foreach ($criteria as $key => $value){
                $sql.= " AND $key = :$key";
            }
        }
        if(!empty($order)){
            $first = true;
            foreach ($order as $key => $value){
                $sql.= $first ? ' ORDER BY' : ',';
                $sql.= " $key $value";
                $first = false;
            }
        }
        if(!is_null($limit) and !is_null($offset))
            $sql.= " LIMIT $limit OFFSET $offset";
        $query = $pdo->prepare($sql);
        foreach ($criteria as $key => $value){
           $query->bindValue(":$key",$value);
        }
        $query->execute();
        $messages = [];
        foreach($query->fetchAll() as $line) {
            $message = new Message();
            $message->setDateCreated(new \DateTime($line['date_created']));
            $message->setContent($line['content']);
            $message->setId($line['id']);
            $user = new User();
            $user->setId($line['id_user']);
            $user->setUsername($line['USER']);
            $message->setUser($user);
            $messages[] = $message;
        }
        return array_reverse($messages);
    }
    /**
     * @param User $user
     * @param $content
     * @return User|null
     */
    public static function add(User $user,$receiver,$content){
        try{
            $pdo = Connection::getInstance();
            $query = $pdo->prepare("INSERT INTO `message` (`id_user`, `id_receiver`, `content`) VALUES (:userid, :receiverid, :content)");
            $query->bindValue(':userid', $user->getId());
            $query->bindValue(':receiverid', $receiver);
            $query->bindValue(':content', $content);
            $pdo->beginTransaction();
            $query->execute();
            $id = $pdo->lastInsertId();
            $result = $pdo->commit();
            if($id and $result){
                $message = new Message();
                $message->setId($id);
                $message->setContent($content);
                $message->setUser($user);
                return $message;
            }
            return null;
        }catch (\PDOException $e){
            $pdo->rollBack();
        }
    }
    
}