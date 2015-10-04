<?php
session_start();
$user_id = $_SESSION['id'];
include("class.php");
$q->news_feed($user_id,false);
?>