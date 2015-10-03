<?php
include('class.php');
$q->login_complete(trim($_POST['loginEmail']),sha1($_POST['loginPassword']));
?>