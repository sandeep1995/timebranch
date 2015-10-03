<?php
session_start();
if(isset($_POST['friend_id'])){
$user_id = $_SESSION['id'];
$friend_id = $_POST['friend_id'];
include("class.php");
$q->add_to_block_list($friend_id,$user_id);
}
?>