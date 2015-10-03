<?php
session_start();
include('db.php');
include('class.php');
if(!isset($_SESSION['id']))
{
    header("Location: index.php");
}
else{

$user_id = $_SESSION['id'];
}

if(isset($_FILES['pic']['tmp_name']))
{
    
    
    if($_FILES['pic']['type']=="image/png" || $_FILES['pic']['type']=="image/jpg" || $_FILES['pic']['type']=="image/jpeg")
    {
        $target_user_file = $q->get_property_of($user_id,'id');
        
        $target = "../uploads/$target_user_file/";
        
        $actual_path = "http://localhost/sandeep/uploads/".$target_user_file."/".$_FILES['pic']['name'];
        
        $up = "uploads/".$_FILES['pic']['name'];
        
        move_uploaded_file($_FILES['pic']['tmp_name'],$target.$_FILES['pic']['name']);
        
        echo '<br><p class="alert alert-success" style="padding:5px;">Successfully Uploaded Your Picture</p>';
        
        echo '<img class="img-responsive img-rounded" src='.$actual_path.'>';
        
        $q->add($user_id,'profile_picture_path',$actual_path);
        
    }
    else
    {
        echo '<p class="alert alert-danger" style="padding:5px;"><b>Warning!</b> We do not support this format</p>';
    }

}
else{
    echo '<p class="alert alert-danger" style="padding:5px;"><b>Warning!</b> Are you kidding? Please choose a image</p>';
}

?>