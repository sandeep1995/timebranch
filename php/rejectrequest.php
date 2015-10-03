<?php
session_start();
if(isset($_POST['friend_id'])){
$user_id = $_SESSION['id'];
$friend_id = $_POST['friend_id'];
include("class.php");
$q->reject_request_of($friend_id,$user_id);
}
?>