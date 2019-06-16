<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <link rel="stylesheet" href="public/assets/bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="public/assets/global/css/layout.css" type="text/css">

    <title>T'Chat <?php echo $_GET['action'] ?></title>

</head>

<body>

<div class="container">

    <div class="jumbotron">
      <h1 class="display-4">Hello, <?php echo $user->getUsername(); ?>!</h1>
      <hr class="my-2">
      <p>This your space to talk with your friends.</p>
      <a class="btn btn-secondary" href="index.php?act=logout&ctrl=User" role="button">Logout</a>
    </div>

    <div class="row marketing">
        <div class="col-lg-8">
            <h4>Messages</h4>
            <div data-url="index.php?ctrl=Message&act=refresh" id="msgs">
                <?php
                foreach ($messages as $msg){
                    echo '<p data-id="'.$msg->getId().'"><span title="'.$msg->getDate()->format('d/m/Y H:i').'" class="username label label-success badge badge-secondary">'.$msg->getUser()->getUsername().'</span><span class="msg">'.$msg->getContenu().'</span></p>';
                }
                ?>
            </div>
            <div class="form">
                <form method="POST" id="formMsg" action="index.php?act=create&ctrl=Message">
                    <div class="form-group">
                        <textarea class="form-control" id="contenu" name="contenu" placeholder="Message" role="2"></textarea>
                        <input type="hidden" id="receiver" name="receiver"></input>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <h4>Ulisateurs en ligne</h4>
            <?php 
                echo '<a class="connected" id="null"><li class="list-group-item list-group-item-info mb-1">Broad<span class="badge badge-success ml-2">Online friends</span><span class="badge badge-light float-right mt-1">'.count($usersConnected).'</span></li></a>';
            ?>
            <ul id="usersConnected" data-url="index.php?ctrl=User&act=connected" class="list-group" style="height: 300px;overflow-y: auto;">
                <?php include_once 'list_users_connected.php'; ?>
            </ul>
            

        </div>
    </div>
</div>

<script type="text/javascript" src="public/assets/jquery/jquery.min.js"></script>
<script type="text/javascript" src="public/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="public/assets/global/js/layout.js"></script>
</body>
</html>
