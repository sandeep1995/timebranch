<?php
session_start();
session_destroy();
session_unset();
$b='';
setcookie('A',$b,time()+(86400*30),"/");
setcookie('B',$b,time()+(86400*30),"/");
header("Location: index");
?>