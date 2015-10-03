<?php
if(isset($_POST['signupEmail'])){
include("class.php");
$email = $_POST['signupEmail'];
$q->check_email($email);}
?>