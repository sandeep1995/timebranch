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
$other_id=$user_id;
if(isset( $_GET['id']))
{
    $other_id = trim($_GET['id']);
}

?>
   
   <center><img class="img-responsive profile-pic" src="<?php
                if($q->is_property_exists($other_id,'profile_picture_path'))
                {
                    print($q->get_property_of($other_id,'profile_picture_path'));
                }
                else{
                    print("http://localhost/sandeep/img/demo.png");
                }
                ?>" width="100%"/>
                </center>