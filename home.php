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
$_SESSION['request'] = $q->get_sent_friend_request_ids($user_id);
$_SESSION['incoming'] = $q->get_incoming_requests($user_id);
$_SESSION['friends'] = $q->get_friend_ids($user_id);
$_SESSION['block_list'] = $q->get_block_ids($user_id);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Sandeep Acharya">
    <link rel="icon" href="img/favicon.ico">

    <title>timeBranch | Make new Friends | Make it large | Make in INDIA</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/home.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container" id="main_page">
        <!-- ---------------------------------------//////////////////////////////////////////////////////-------------------- -->
         <?php $q->nav(); ?>
        <!-- -------------------------------------///////////////////////////////////////////////////////////---------------------- -->
        <div class="row">
            <div class="col-md-6">
                <form class="form-horizontal" method="post" id="status-update-form">
                      <div class="form-group">
                      <div class="col-sm-8">
                       <textarea class="form-control" rows="2" name="status" id="status" placeholder="Anything special to share?"></textarea>
                      </div>
                      <div class="col-sm-4">
                      <button type="submit" class="btn btn-success btn-block btn-lg" style="padding: 13.4px;">Post</button> 
                      </div>
                    </div>
                    
                </form>
            </div>
            <div class="col-md-6">
                
            </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>