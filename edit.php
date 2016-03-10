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
?>

<div class="container-fluid">
   
<div class="row">
    <div class="col-md-12" id="out">
        
    </div>
</div><div class="row"> <div class="col-md-12">
                   
                
                <!--------------------------------------------------------------------------------------------------->
                <form action="" method="post" id="edit-profile-form" class="form-horizontal">
                    
                     <div class="form-group">
                        <label for="profile_status" class="col-sm-3 control-label"><b>Status</b></label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control" id="profile_status" value="<?php echo $q->get_property_of($user_id,'profile_status');  ?>" name="profile_status" title="Your Status"></div>
                      </div>
                     
                     <div class="form-group">
                        <label for="mobile_no" class="col-sm-3 control-label"><b>Mobile No</b></label>
                        <div class="col-sm-9">
                           <input type="tel" class="form-control" id="mobile_no" value="<?php echo  $q->get_property_of($user_id,'mobile_no');  ?>" name="mobile_no" placeholder="10 digit number">
                        </div>
                      </div>
                     <div class="form-group">
                        <label for="hometown" class="col-sm-3 control-label"><b>Hometown</b></label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control" id="hometown" value="<?php echo  $q->get_property_of($user_id,'hometown');  ?>" name="hometown" placeholder="your sweet hometown">
                        </div>
                      </div>
                     <div class="form-group">
                        <label for="college_name" class="col-sm-3 control-label"><b>College</b></label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control" id="college_name" value="<?php echo  $q->get_property_of($user_id,'college_name');  ?>" name="college_name" placeholder="name of your college">
                        </div>
                      </div>
                     <div class="form-group">
                        <label for="school_name" class="col-sm-3 control-label"><b>School</b></label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control" id="school_name" value="<?php echo  $q->get_property_of($user_id,'school_name');  ?>" name="school_name" placeholder="name of your school">
                        </div>
                      </div>
                     <div class="form-group">
                        <label for="language_1st" class="col-sm-3 control-label"><b>Mother Tounge</b></label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control" id="language_1st" value="<?php echo  $q->get_property_of($user_id,'language_1st');  ?>" name="language_1st" placeholder="the language you speak most">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="language_2nd" class="col-sm-3 control-label"><b>Other Languages</b></label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control" id="language_2nd" value="<?php echo  $q->get_property_of($user_id,'language_2nd');  ?>" name="language_2nd" placeholder="any other language you know">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="language_3rd" class="col-sm-3 control-label"><b>Other Languages</b></label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control" id="language_3rd" value="<?php echo  $q->get_property_of($user_id,'language_3rd');  ?>" name="language_3rd" placeholder="any other language you know">
                        </div>
                      </div>
                       <div class="form-group">
                        <label for="relationship" class="col-sm-3 control-label"><b>Relationship</b></label>
                        <div class="col-sm-9">
                           <input type="text" class="form-control" id="relationship" value="<?php echo  $q->get_property_of($user_id,'relationship');  ?>" name="relationship" placeholder="relationship status">
                        </div>
                      </div>
                       <div class="form-group">
                        <div class="col-md-8"></div>
                        <button type="submit" value="Save" class="col-md-3 btn btn-primary"  id="btnSave">Save</button>
                       </div>
                      
                     
                </form>
                </div>
     
    </div></div>
   <script>           
            $('#btnSave').click(function(){
                var formData = $('#edit-profile-form').serialize();
            
                $.ajax({
                    url: 'php/edit-profile.php',
                    method : "POST",
                    data : formData,
                    success : function(returnData)
                    {
                         $('#out').html(returnData);
                    },
                    error : function() {alert('There is some problem');},
                    complete : function() {}
                    });
                return false;
                });
    </script>