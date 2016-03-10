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
$other_id=$user_id;
if(isset( $_GET['id']))
{
    $other_id = trim($_GET['id']);
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
    <style>
        .profile-pic:hover{
            cursor: pointer;
        }
        
    </style>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    
  
    
              
    <div class="container" id="main_page">
        <!-- ---------------------------------------//////////////////////////////////////////////////////-------------------- -->
        
               <?php $q->nav();
             ?>
               
               
                      <?php if($other_id==$user_id) {?>
        <!-- -------------------------------------///////////////////////////////////////////////////////////---------------------- -->
        
              <!-- Modal -->
          <div class="modal fade" id="<?php echo $user_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header"  style="background: #efefef;">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title" id="myModalLabel">Profile Picture of <?php print($q->get_full_name($user_id)); ?></h3>
                    </div>
                    <div class="modal-body">
                     </div>
                    <div class="modal-footer"  style="background: #efefef;">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          
          <div class="modal fade" id="edit-profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header" style="background: #efefef;">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title" id="myModalLabel">Edit your profile</h3>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                        <div class="modal-footer" style="background: #efefef;">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              
                   <div class="modal fade" id="changephoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header" style="background: #efefef;">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title" id="myModalLabel">Change Profile Picture</h3>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                        <div class="modal-footer" style="background: #efefef;">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              
              
        
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-primary">
               <div class="panel-heading"><h3><?php print($q->get_full_name($user_id)); ?></h3>
               <p><?php
                   if($q->is_property_exists($user_id,'profile_status'))
                            {
                                print($q->get_property_of($user_id,'profile_status'));
                            }
                            else{
                                    print('<p class="text-default">I am awesome.</p>');
                            }
                  ?></p>
               </div>
               <div class="panel-body">
                <center id="div-pic"><img class="img-responsive profile-pic" src="<?php
                if($q->is_property_exists($user_id,'profile_picture_path'))
                {
                    print($q->get_property_of($user_id,'profile_picture_path'));
                }
                else{
                    print("http://localhost/sandeep/img/demo.png");
                }
                ?>"
                width="80%" data-toggle="modal" data-target="<?php echo '#'.$user_id; ?>" type="button" /><br>
                
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#changephoto" type="button" >Change Pic</button>
                        <a class="btn btn-success btn-sm" id="profile_cust" data-toggle="modal" data-target="#edit-profile" type="button"><span class="glyphicon glyphicon-edit"></span> Edit Profile</a>
                
                </center>
                <br>
                    <ul class="list-group">
                        
                        <li class="list-group-item">Email: <?php print($q->get_property_of($user_id,'email')); ?></li>
                        <li class="list-group-item">Sex: <?php print($q->get_property_of($user_id,'sex')); ?></li>
                        <li class="list-group-item">Mobile: <?php
                        if($q->is_property_exists($user_id,'mobile_no'))
                            {
                                print($q->get_property_of($user_id,'mobile_no'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                          <li class="list-group-item">Hometown: <?php
                        if($q->is_property_exists($user_id,'hometown'))
                            {
                                print($q->get_property_of($user_id,'hometown'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                            <li class="list-group-item">School: <?php
                        if($q->is_property_exists($user_id,'school_name'))
                            {
                                print($q->get_property_of($user_id,'school_name'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                              <li class="list-group-item">College: <?php
                        if($q->is_property_exists($user_id,'college_name'))
                            {
                                print($q->get_property_of($user_id,'college_name'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                              
                           <li class="list-group-item">Mother Tounge: <?php
                        if($q->is_property_exists($user_id,'language_1st'))
                            {
                                print($q->get_property_of($user_id,'language_1st'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                           
                             <li class="list-group-item">Other Language Known (1): <?php
                        if($q->is_property_exists($user_id,'language_2nd'))
                            {
                                print($q->get_property_of($user_id,'language_2nd'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                        <li class="list-group-item">Other Language Known (2): <?php
                        if($q->is_property_exists($user_id,'language_3rd'))
                            {
                                print($q->get_property_of($user_id,'language_3rd'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                         <li class="list-group-item">Relationship: <?php
                        if($q->is_property_exists($user_id,'relationship'))
                            {
                                print($q->get_property_of($user_id,'relationship'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li> 
                          
                       
                    </ul>
               </div>
                <div class="panel-footer">
                </div>
                </div>
            </div>
            <div class="col-md-8">
                <div>
               <?php
               $q->news_feed($user_id, true);
               ?>
                  
                </div>
            </div>
        </div>
            
        <script>
                $('<?php echo '#'.$user_id; ?>').on('show.bs.modal', function (event) {
  var modal = $(this);
  modal.find('.modal-body').load('http://localhost/sandeep/php/photo.php?id=<?php echo $user_id; ?>');
});
        </script>
        
    
    <?php } else {
        // this part is of another person/////////////////////////////////////////////////////////////////////////////////////
        //important
        
         if(in_array($other_id,$_SESSION['block_list']))
                    {   //if id is in the block list
                        ?>
                            <script>
                                window.location.href="http://localhost/sandeep/profile";
                            </script>
                          
                        <?php
                          die();
                    }
        
        if(is_numeric($other_id))
        {
                          if(!($q->is_member($other_id)))
                                {
                                   echo '<div class="jumbotron">
                <h1>Hey! Are you kidding?</h1>
                </div>';
                                    die();
                                }
                                   
            
            ?>
             <div class="modal fade" id="<?php echo $other_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header"  style="background: #efefef;">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title" id="myModalLabel">Profile Picture of <?php print($q->get_full_name($other_id)); ?></h3>
                    </div>
                    <div class="modal-body">
                     </div>
                    <div class="modal-footer"  style="background: #efefef;">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
        
              
              
              
        
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-primary">
               <div class="panel-heading"><h3><?php print($q->get_full_name($other_id)); ?></h3>
               <p><?php
                   if($q->is_property_exists($other_id,'profile_status'))
                            {
                                print($q->get_property_of($other_id,'profile_status'));
                            }
                            else{
                                    print('<p class="text-default">I am awesome.</p>');
                            }
                  ?></p>
               </div>
               <div class="panel-body">
                <center id="div-pic"><img class="img-responsive profile-pic" src="<?php
                if($q->is_property_exists($other_id,'profile_picture_path'))
                {
                    print($q->get_property_of($other_id,'profile_picture_path'));
                }
                else{
                    print("http://localhost/sandeep/img/demo.png");
                }
                ?>"
                width="80%" data-toggle="modal" data-target="<?php echo '#'.$other_id; ?>" type="button" />
                <br>
                <?php if(in_array($other_id,$_SESSION['incoming']))
                {   //if id is in the friend request array
                    ?>
                        <button class="btn btn-sm btn-success" id="acceptRequest">Accept</button>
                        <button class="btn btn-sm btn-danger" id="rejectRequest">Reject</button>
                    <?php
                }
                else if(in_array($other_id,$_SESSION['request']))
                {   //if id is in the sent request array
                    ?>
                    <button class="btn btn-sm btn-default" id="cancelRequest">Friend request sent</button>
                    <?php
                }
                else
                { 
                    if(in_array($other_id,$_SESSION['friends']))
                    {   //if id is user id's friend
                        echo '<p class="bg-primary" id="friend-status">Friend</p>';
                        echo '<button class="btn btn-sm btn-danger" id="unfriend">Unfriend</button>';
                        
                    }
                    else
                    {   //if not friend
                    ?>
                        
                        <button class="btn btn-sm btn-warning" id="addFriend">Add friend</button>
                    <?php
                    }
                } ?>
                <button class="btn btn-sm btn-default" id="block">Block</button>
                </center>
                <br>
                    <ul class="list-group">
                        
                        <li class="list-group-item">Email: <?php print($q->get_property_of($other_id,'email')); ?></li>
                        <li class="list-group-item">Sex: <?php print($q->get_property_of($other_id,'sex')); ?></li>
                        <li class="list-group-item">Mobile: <?php
                        if($q->is_property_exists($other_id,'mobile_no'))
                            {
                                print($q->get_property_of($other_id,'mobile_no'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                          <li class="list-group-item">Hometown: <?php
                        if($q->is_property_exists($other_id,'hometown'))
                            {
                                print($q->get_property_of($other_id,'hometown'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                            <li class="list-group-item">School: <?php
                        if($q->is_property_exists($other_id,'school_name'))
                            {
                                print($q->get_property_of($other_id,'school_name'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                              <li class="list-group-item">College: <?php
                        if($q->is_property_exists($other_id,'college_name'))
                            {
                                print($q->get_property_of($other_id,'college_name'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                              
                           <li class="list-group-item">Mother Tounge: <?php
                        if($q->is_property_exists($other_id,'language_1st'))
                            {
                                print($q->get_property_of($other_id,'language_1st'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                           
                             <li class="list-group-item">Other Language Known (1): <?php
                        if($q->is_property_exists($other_id,'language_2nd'))
                            {
                                print($q->get_property_of($other_id,'language_2nd'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                        <li class="list-group-item">Other Language Known (2): <?php
                        if($q->is_property_exists($other_id,'language_3rd'))
                            {
                                print($q->get_property_of($other_id,'language_3rd'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li>
                         <li class="list-group-item">Relationship: <?php
                        if($q->is_property_exists($other_id,'relationship'))
                            {
                                print($q->get_property_of($other_id,'relationship'));
                            }
                            else{
                                    print('<p class="text-danger">Not Shared</p>');
                            }
                        
                        ?></li> 
                          
                    
                        
                    </ul>
               </div>
</div>
            </div>
         <div class="col-md-8">
                <div>
                        <?php
               $q->news_feed($other_id,true);
               ?>
                       
                </div>
            </div>      
        </div>

        <script>
            $('#addFriend').click(function(){
                $.ajax({
                    url : 'php/sendrequest.php',
                    method : 'POST',
                    data : {friend_id : <?php echo $other_id;?>},
                    success : function(data){
                        if (data==1) {
                                $('#addFriend').removeClass('btn-warning');
                                $('#addFriend').addClass('btn-default');
                                $('#addFriend').html('Friend request sent');
                            }
                        },
                    error : function(){alert('Something happened');},
                    complete : function(){console.log('complete');}
                    });
                
                });
            
             $('#unfriend').click(function(){
                $.ajax({
                    url : 'php/unfriend.php',
                    method : 'POST',
                    data : {friend_id : <?php echo $other_id;?>},
                    success : function(data){
                        if (data==1) {
                                $('#friend-status').fadeOut();
                                $('#unfriend').removeClass('btn-danger');
                                $('#unfriend').addClass('btn-warning');
                                $('#unfriend').html('Add friend');
                            }
                        },
                    error : function(){alert('Something happened');},
                    complete : function(){console.log('complete');}
                    });
                
                });
            
                $('#block').click(function(){
                $.ajax({
                    url : 'php/blockuser.php',
                    method : 'POST',
                    data : {friend_id : <?php echo $other_id;?>},
                    success : function(data){
                        console.log(data);
                        if (data==1) {
                                window.location.href="http://localhost/sandeep/profile";   
                            }
                        },
                    error : function(){alert('Something happened');},
                    complete : function(){
                        window.location.href="http://localhost/sandeep/profile";
                    }
                    });
                });
            
                $('#rejectRequest').click(function(){
                $.ajax({
                    url : 'php/rejectrequest.php',
                    method : 'POST',
                    data : {friend_id : <?php echo $other_id;?>},
                    success : function(data){
                        console.log(data);
                        if (data==1) {
                                $('#acceptRequest').fadeOut();
                                $('#rejectRequest').removeClass('btn-danger');
                                $('#rejectRequest').addClass('btn-warning');
                                $('#rejectRequest').html('Add friend');    
                            }
                        },
                    error : function(){alert('Something happened');},
                    complete : function(){console.log('complete');}
                    });
                });
            
            $('#acceptRequest').click(function(){
                $.ajax({
                    url : 'php/acceptrequest.php',
                    method : 'POST',
                    data : {friend_id : <?php echo $other_id;?>},
                    success : function(data){
                        console.log(data);
                        if (data==1) {
                                $('#acceptRequest').removeClass('btn-warning');
                                $('#acceptRequest').removeClass('btn-sm');
                                $('#acceptRequest').removeClass('btn');
                                $('#acceptRequest').replaceWith('<p class="bg-primary" id="friend-status">Friend</p><button class="btn btn-sm btn-danger" id="unfriend">Unfriend</button>');
                                $('#rejectRequest').fadeOut();
                            }
                        },
                    error : function(){alert('Something happened');},
                    complete : function(){console.log('complete');}
                    });
                
                });
            
        </script>
        
                <script>
                            $('<?php echo '#'.$other_id; ?>').on('show.bs.modal', function (event) {
  var modal = $(this);
  modal.find('.modal-body').load("http://localhost/sandeep/php/photo.php?id=<?php echo $other_id;?>");
});
                </script>
         
       <?php }
        else{
            echo '<div class="jumbotron">
                <h1 class="alert alert-danger">Hey! We are tracking your ip and location. So be careful before typing anything.</h1>
                </div>';
        }
        ?>
         <?php } ?>
    </div>
        
        
 <script>
    
    
     $('#edit-profile').on('show.bs.modal', function (event) {
  var modal = $(this);
  modal.find('.modal-body').load('http://localhost/sandeep/edit.php');
});
   $('#changephoto').on('show.bs.modal', function (event) {
  var modal = $(this);
  modal.find('.modal-body').load('http://localhost/sandeep/changephoto.php');
});  
   
     $('#edit-profile').on('hidden.bs.modal', function (event) {
        $("#div-pic>img").attr('href').val('<?php print($q->get_property_of($user_id,'profile_picture_path')); ?>');
}); 
    </script>
  </body>
</html>