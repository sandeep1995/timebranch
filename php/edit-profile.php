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

if(isset($_POST['mobile_no'])){
    $mobile_no=trim($_POST['mobile_no']);
$q->add($user_id,'mobile_no',$mobile_no);
}

if(isset($_POST['hometown'])){
$hometown = ucwords(trim($_POST['hometown']));
$q->add($user_id,'hometown',$hometown);
}

if(isset($_POST['school_name'])){
$school_name = ucwords(trim($_POST['school_name']));
$q->add($user_id,'school_name',$school_name);
}

if(isset($_POST['college_name'])){
$college_name =ucwords(trim($_POST['college_name']));
$q->add($user_id,'college_name',$college_name);
}

if(isset($_POST['language_1st'])){
$langugae_1st= ucwords(trim($_POST['language_1st']));
$q->add($user_id,'language_1st',$langugae_1st);
}

if(isset($_POST['language_2nd'])){
$langugae_2nd= ucwords(trim($_POST['language_2nd']));
$q->add($user_id,'language_2nd',$langugae_2nd);
}

if(isset($_POST['language_3rd']))
{
$langugae_3rd= ucwords(trim($_POST['language_3rd']));
$q->add($user_id,'language_3rd',$langugae_3rd);
}
if(isset($_POST['relationship']))
{
$relationship = ucwords(trim($_POST['relationship']));
$q->add($user_id,'relationship',$relationship);
}

$q->add($user_id,'profile_status',$_POST['profile_status']);


    echo '<br><p class="alert alert-success" style="padding:5px;">Successfully Updated Your Profile</p>';
?>