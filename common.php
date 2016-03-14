<?php
session_start();
include('php/db.php');
include('php/class.php');
if(!isset($_SESSION['id']))
{
    header("Location: index.php");
}
else{

$user_id = $_SESSION['id'];
}
if(isset($_GET['other_id'])){
    $other_id = $_GET['other_id'];
}
else{
    header("Location: index.php");
}
?>
<div class="container-fluid">
    <?php
    $array_people_you_may_know = $q->return_mutual_ids($user_id,$other_id);
     if(!empty($array_people_you_may_know)){
        foreach($array_people_you_may_know as $key => $value){
             ?>
            <div class="well"> <?php $q->show_glance($value); $q->no_of_mutual_frineds($user_id,$value); ?></div>
            <?php
        }
        }
        else{
            echo '<div class="well">Try to make friends first';
        }
        ?>
</div>