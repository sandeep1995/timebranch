<?php
session_start();
if(isset($_POST['status'])){
$status = $_POST['status'];
$user_id = $_SESSION['id'];
include("class.php");
$q->post_status($user_id,$status);
}
?>