<?php
namespace Controller;

use Repository\MessageRepository;

class MessageController extends DefaultController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
    }
    public function create(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' and isset($_POST['contenu']) and isset($_POST['receiver'])){
            $message = MessageRepository::add($this->getUser(), $_POST['receiver'],htmlspecialchars($_POST['contenu']));
            header('Content-Type: application/json');
            if($message){
                echo json_encode(['code' => 1]);
            }else{
                echo json_encode(['code' => 0]);;
            }
        }else
            header("location:index.php");
    }
    public function refresh(){
        if($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' and isset($_GET['lastShown'])) {
            $lastShown = $_GET['lastShown'];
            $messages = MessageRepository::findBy(array('id_receiver' => 0),['date_created'=>'DESC'],null,null,$lastShown);
            $result =[];
            foreach ($messages as $msg){
                $result[] =[
                    'id'=>$msg->getId(),
                    'contenu' => $msg->getcontent(),
                    'date' => $msg->getdateCreated()->format('d/m/Y H:i'),
                    'user' => $msg->getUser()->getUsername()
                ];
            }
            header('Content-Type: application/json');
            echo json_encode([
                'code' => 1,
                'messages' => $result
            ]);
        }
    }

    public function refreshConversation(){
        if($_SERVER['REQUEST_METHOD'] === 'GET' and isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' and isset($_GET['lastShown']) and isset($_POST['sender'])) {
            $lastShown = $_GET['lastShown'];
            $messages = MessageRepository::findBy(array('id_user' => $_POST['sender'], 'id_receiver' => $_SESSION['userId']),['date_created'=>'DESC'],null,null,$lastShown);
            $result =[];
            foreach ($messages as $msg){
                $result[] =[
                    'id'=>$msg->getId(),
                    'contenu' => $msg->getcontent(),
                    'date' => $msg->getdateCreated()->format('d/m/Y H:i'),
                    'user' => $msg->getUser()->getUsername()
                ];
            }
            header('Content-Type: application/json');
            echo json_encode([
                'code' => 1,
                'messages' => $result
            ]);
        }
    }
}