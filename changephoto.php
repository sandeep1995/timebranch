<style>
    #upload-chooser{
        border: 2px dashed #ccc;
        padding: 12px 24px;
        clear: both;
        color: green;
        cursor: pointer;
        width: 100%;
        }
</style>
<div class="row">
    <div class="col-md-12" id="out">
        
    </div>
</div><div class="row">
    <div class="col-md-12">
    <div class="progress" style="display: none;">
                    <div id="progressBar" class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                      <span class="sr-only">0% Complete (success)</span>
                    </div>
                    </div>
                <form action="http://localhost/sandeep/php/upload.php" method="post" class="form-horizontal" id="upload-form" enctype="multipart/form-data">
                
                     <label id="upload-chooser">
                    Pick up a picture of you
                    <input type="file" accept="image/*" name="pic" id="pic" style="display: none;">
                    </b></label><br>
                    <input type="hidden" value="<?php echo $user_id; ?>" name="user_id" id="user_id"> 
                <button type="submit" onclick="uploadFile();" value="Upload Your Image" id="btn-img-upload" name="submit" class="btn btn-success btn-block">
               <span class="glyphicon glyphicon-open"></span>
               Upload Your Image </button>
                </form>
</div>
</div>
 <script src="js/form.min.js"></script>
    <script>
            $('#upload-form').ajaxForm({
                 beforeSend:function(){
                    var pic = $('#pic').val();
                    if (pic=='') {
                        $('#out').html('<p class="alert alert-danger" style="padding:5px;"><b>Warning!</b> Are you kidding? Please choose a image</p>');
                    }
                    else{
                    $('.progress').slideToggle('fast');
                    }
                    },
                uploadProgress:function(event,position,total,percentComplete){
                    $('.progress-bar').width(percentComplete+'%');
                    $('.progress-bar').html('<b>'+percentComplete+'%</b>');
                    },
                success:function(){
                    $('.progress').fadeOut('slow');
                    },
                complete:function(res){
                        $('#out').html(res.responseText);
                    },
                });
    </script>