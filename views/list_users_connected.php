
<?php
 
 foreach ($usersConnected as $user){
     echo '<a class="connected" id="'.$user->getId().'"><li class="list-group-item list-group-item-info mb-1">'.$user->getUserName().'<span class="badge badge-success ml-2 float-right mt-1">Online</span></li></a>';
 }
?>
