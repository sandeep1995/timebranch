<?php
include('db.php');
class FUNCTIONS {
    public function check_email($email)
    {
        $email = trim($email);   
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $regex = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^"; 
            if ( preg_match( $regex, $email )) {
                $this->is_email_exist($email);
            }
            else { 
            echo '<span style="color:red;">'.$email . " is an invalid email. Please try again.".'</span>';
            return false;
        }
        
    }
    
    public function is_email_exist($email)
    {
        global $conn;
        $table = "user";
        $sql = "select id from $table where email = ?";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$email);
        $query->execute();
        if($query->rowCount()>0)
        {
            echo '<span style="color:red;">' .$email . " already exists.</span>";
            return true;
        }
        else{
             echo '<span class="text-primary">Good to go. </span>';
            return false;
        }
    }
    
    public function complete_signup()
    {
        $email = trim($_POST['signupEmail']);
        if(!($this->is_email_exist($email)))
        {
                $fname = ucwords(trim($_POST['firstname']));
                $mname = ucwords(trim($_POST['middlename']));
                $lname = ucwords(trim($_POST['lastname']));
                $sex = $_POST['sex'];
                $password =  sha1($_POST['password']);
                global $conn;
                $table = 'user';
                $sql = "insert into $table (first_name,middle_name,last_name,email,password,joining_time_stamp,sex) values(?,?,?,?,?,?,?)";
                $query = $conn->prepare($sql);
                $query->bindParam(1, $fname);
                $query->bindParam(2, $mname);
                $query->bindParam(3, $lname);
                $query->bindParam(4, $email);
                $query->bindParam(5, $password);
                $time = time();
                $query->bindParam(6, $time);
                $query->bindParam(7, $sex);
                
                if($query->execute())
                    {       $user_id_may_be=$conn->lastInsertId();
                            echo '<p class="text-primary">Hello '.$fname.' You have been successfully signed up. Please Log In now.</p>'.' <button onclick="login();" class="btn btn-primary">Click here to login.</button>';
                            $path = "../uploads/$user_id_may_be";
                            mkdir($path);
                            $this->signup_email($email,'Welcome To Dost Factory',$fname);
                    }
                    else
                    {
                        echo "Sorry there is some problem.";
                    }
        }
        else
        {
            echo '<h1 style="color:red;">Try again. <a href="http://localhost/sandeep" class="btn btn-danger">Reload</a></h1>';
        }
    }
    
    public function login_complete($A,$B)
    {
        global $conn;
        $email = $A;;
         $password =  $B;
        if(isset($_POST['special_key']) && !isset($_COOKIE['A']) && !isset($_COOKIE['B']))
        {
                if($_POST['special_key']=="on")
                {
                    //create cookie
                    setcookie('A',$email,time()+(86400*30),"/");
                    setcookie('B',$password,time()+(86400*30),"/");
                }
        }
    
        if(!empty($_POST['loginPassword']))
        {
        
            $table = "user";
            $sql = "select id, password from $table where email = ?";
            $query = $conn->prepare($sql);
            $query->bindParam(1,$email);
            $query->execute();
            if($query->rowCount()>0)
            {
                $database_result  = $query->fetchObject();
                if($password == ($database_result->password))
                {
                    //login true
                    session_start();
                    $_SESSION['id'] = $database_result->id;
                     $conn=null;
                    ?>
                    <script>
                        window.location.href='http://localhost/sandeep/home';
                    </script>
                    <?php
                    exit;
                }
                else{
                    echo "Ooops! Not matched. Forgot Password? Try Again.";
                }
            }
            else{
                echo "You have done some mistake in your password or email";
            }
        }   
        else{
            echo "He He! You have not typed the password.";
        }
        
        
    }
    
    public function redirect($url)
    {
        if (!headers_sent())
        {    
            header('Location: '.$url);
            exit;
        }
        else
        {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
        exit;
        }
    }
    
      public function get_block_ids($user_id){
        global $conn;
        $table = "block_list";
        $sql = "select block_id from $table where user_id = ?";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$user_id);
        $query->execute();
        if($query->rowCount()){
            $i=0;
            $request[]="";
            while($r=$query->fetch(PDO::FETCH_OBJ))
            {
                $request[$i] = $r->block_id;
                $i++;
            }
            return $request;
        }else{
            $request[0] = 0;
            return $request;
        }
    }
    
    
     public function get_friend_ids($user_id){
        global $conn;
        $table = "friends";
        $sql = "select friend_id from $table where user_id = ?";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$user_id);
        $query->execute();
        if($query->rowCount()){
            $i=0;
            $request[]="";
            while($r=$query->fetch(PDO::FETCH_OBJ))
            {
                $request[$i] = $r->friend_id;
                $i++;
            }
            return $request;
        }else{
            $request[0] = 0;
            return $request;
        }
    }
    
    public function get_sent_friend_request_ids($user_id){
        global $conn;
        $table = "friend_requests";
        $sql = "select sent_to_id from $table where sent_from_id = ?";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$user_id);
        $query->execute();
        if($query->rowCount()){
            $i=0;
            $request[]="";
            while($r=$query->fetch(PDO::FETCH_OBJ))
            {
                $request[$i] = $r->sent_to_id;
                $i++;
            }
            return $request;
        }else{
            $request[0] = 0;
            return $request;
        }
    }
    
    public function reject_request_of($other_id,$user_id){
                global $conn;
                $sql1 = "delete from friend_requests where sent_to_id =? and sent_from_id =?";
                $query1 = $conn->prepare($sql1);
                $query1->bindParam(1, $user_id);
                $query1->bindParam(2, $other_id);
                if($query1->execute())
                    echo 1;
                else
                    echo 0;
    }
    
    public function unfriend($friend_id,$user_id){
                global $conn;
                $sql1 = "delete from friends where user_id =? and friend_id =?";
                $query1 = $conn->prepare($sql1);
                $query1->bindParam(1, $user_id);
                $query1->bindParam(2, $friend_id);
                $query1->execute();
                $sql = "delete from friends where user_id =? and friend_id =?";
                $query = $conn->prepare($sql1);
                $query->bindParam(1, $friend_id);
                $query->bindParam(2, $user_id);
                if($query->execute())
                    echo 1;
                else
                    echo 0;
    }
    
    public function add_to_block_list($other_id,$user_id){
                global $conn;
                $friends = $this->get_friend_ids($user_id);
                if(in_array($other_id,$friends)){
                    $this->unfriend($other_id,$user_id);
                }
                $table = "block_list";
                $sql = "insert into $table (user_id,block_id) values(?,?)";
                $query = $conn->prepare($sql);
                $query->bindParam(1, $user_id);
                $query->bindParam(2, $other_id);
                 $query->execute();
                 $query->bindParam(1, $other_id);
                $query->bindParam(2, $user_id);
                 if($query->execute())
                 echo 1;
                 else
                 echo 0;
    }
    
    public function accept_request_from($other_id,$user_id){
                global $conn;
                $time = time();
                $table = "friends";
                $sql1 = "delete from friend_requests where sent_to_id =? and sent_from_id =?";
                $query1 = $conn->prepare($sql1);
                $query1->bindParam(1, $user_id);
                $query1->bindParam(2, $other_id);
                $query1->execute();
                $sql = "insert into $table (user_id,friend_id,friend_since) values(?,?,?)";
                $query = $conn->prepare($sql);
                $query->bindParam(1, $user_id);
                $query->bindParam(2, $other_id);
                 $query->bindParam(3, $time);
                 $query->execute();
                 $query->bindParam(1, $other_id);
                $query->bindParam(2, $user_id);
                 $query->bindParam(3, $time);
                 if($query->execute())
                 echo 1;
                 else
                 echo 0;
    }
    
    public function get_incoming_requests($user_id){
        global $conn;
        $table = "friend_requests";
        $sql = "select sent_from_id from $table where sent_to_id = ?";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$user_id);
        $query->execute();
        if($query->rowCount()){
            $i=0;
            $request[]="";
            while($r=$query->fetch(PDO::FETCH_OBJ))
            {
                $request[$i] = $r->sent_from_id;
                $i++;
            }
            return $request;
        }
        else
        {
            $request[0] = 0;
            return $request;
        }
    }
    
    public function get_property_of($user_id,$parameter)
    {
        global $conn;
        $table = "user";
        $sql = "select $parameter from user where id = ?";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$user_id);
        $query->execute();
        if($query->rowCount()){
        $result = $query->fetchObject();
        return $result->$parameter;
        }
        else{
                return false;
        }
        
    }
    
    public function get_full_name($user_id){
        global $conn;
        $table = "user";
        $sql = "select first_name,middle_name,last_name from user where id = ?";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$user_id);
        $query->execute();
        if($query->rowCount()>0){
        $result = $query->fetchObject();
        $name = $result->first_name . ' '.$result->middle_name .' ' . $result->last_name;
        echo $name;
        }
        else{
            return false;
        }
    }
    public function nav()
    {
        ?>
                                <nav class="navbar navbar-default">
                      <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>
                          <a class="navbar-brand" href="home">tB</a>
                        </div>
                    
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        
                              <ul class="nav navbar-nav">
                    <li role="presentation"><a href="profile"><span class="glyphicon glyphicon-user"></span> <?php print($this->get_property_of($_SESSION['id'],"first_name"));?></a></li>
                    <li role="presentation"><a href="messages"><span class="glyphicon glyphicon-envelope"></span> Messages</a></li>
                    <li role="presentation"><a href="walk"><span class="glyphicon glyphicon-link"></span> Walking Zone</a></li>
                    <li role="presentation"><a href="notifications"><span class="glyphicon glyphicon-bell"></span> Notifications</a></li>
                    <li role="presentation"><a href="request"><span class="glyphicon glyphicon-star"></span> Requests <span class="badge"><?php if($_SESSION['incoming'][0]==0) echo 0;
                    else
                    echo count($_SESSION['incoming']);?></span></a></li>
                        </ul>
                                                   <ul class="nav navbar-nav navbar-right">
                                       
                                <form class="navbar-form navbar-right" method="post" action=""  role="search">
                            <div class="form-group">
                             
                              <input type="text" class="form-control" autocomplete="off" id="search" name="search" onkeyup="search_for(this.value);" placeholder="Search people..">
                           </div>
                            <div class="form-group">
                                <br>
                                <br>
                               
                                    <div class="dropdown">
                                        
                                <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="visibility: hidden; display: none;">
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" id="searchResult">
                                  
                                </ul>
                              </div>
                            </div>
                            <button type="submit" id="btnSearch" onclick="search_for($('#search').val()); return false;" class="btn btn-info"><span class="glyphicon glyphicon-search"></span></button>
                            
                                </form>
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-th"></span></a>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="settings"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
                                <li><a href="friends"><span class="glyphicon glyphicon-user"> Friends (<?php if($_SESSION['friends'][0]==0) echo 0;
                    else
                    echo count($_SESSION['friends']);?>)</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="logout"><span class="glyphicon glyphicon-trash"></span> Logout</a></li>
                              </ul>
                            </li>
                           
                          </ul>
                       

                        </div><!-- /.navbar-collapse -->
                      </div><!-- /.container-fluid -->
                    </nav>

                               
                <script>
                    $('#searchResult').hide();
                    function search_for(query){
                        if (query!="") {
                            $.ajax({
                            url : 'http://localhost/sandeep/php/search.php',
                            method : 'GET',
                            data : {'query' : query},
                            success :  function(result){
                                        $('#searchResult').slideDown('fast');
                                        $('#searchResult').html('<li>'+result+'</li>');
                                    },
                            error : function(){
                                        $('#searchResult').html('We are having some problem');
                                    },
                            complete : function(){
                                document.onclick= function(){
                                       $('#searchResult').slideUp(600);
                                    
                                }
                                
                            }
                        });
                        }
                     }
                    
                   
                    
                    
                </script>
            <?php
    }
    
    
    public function signup_email($to,$subject,$fname)
    {

            
            $message = "<h3>$fname</h3> ".' You have been successfulyy signed up';
            
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: <webmaster@example.com>' . "\r\n";
            
            mail($to,$subject,$message,$headers);

    }
    
    public function add($user_id,$property,$value)
    {
        global $conn;
        $table = "user";
        $sql = "update $table set $property = ? where id = ?";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$value);
        $query->bindParam(2,$user_id);
        $query->execute();
    }
    
    public function is_property_exists($user_id, $property)
    {
        global $conn;
        $table = "user";
        $sql = "select $property from $table where id = ?";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$user_id);
        $query->execute();
        if($query->rowCount()>0)
        {
            $result = $query->fetchObject();
            if(empty($result->$property))
            {
               return false; 
            }
            else
            {
                return true;
            }
        }
        
    }
    
    public function send_request_to($friend_id,$user_id){
                global $conn;
                $time = time();
                $table = "friend_requests";
                $sql = "insert into $table (sent_to_id,sent_from_id,sent_time) values(?,?,?)";
                $query = $conn->prepare($sql);
                $query->bindParam(1, $friend_id);
                $query->bindParam(2, $user_id);
                 $query->bindParam(3, $time);
                 if($query->execute())
                 echo 1;
                 else
                 echo 0;
    }
    
    public function cookie_login($A,$B)
    {
        global $conn;
            $email=$A;
            $password=$B;
            $table = "user";
            $sql = "select id, password from $table where email = ?";
            $query = $conn->prepare($sql);
            $query->bindParam(1,$email);
            $query->execute();
            if($query->rowCount()>0)
            {
                $database_result  = $query->fetchObject();
                if($password == ($database_result->password))
                {
                    //login true
                    session_start();
                    $_SESSION['id'] = $database_result->id;
                    
                    ?>
                    <script>
                        window.location.href='http://localhost/sandeep/home';
                    </script>
                    <?php
                    exit;
                }
                else{
                    echo "Ooops! Not matched. Forgot Password? Try Again.";
                }
            }
            else{
                echo "You have done some mistake in your password or email";
            }
        
        
    }
    
    public function live_search($search_term)
    {
            global $conn;
            $search_term = trim($search_term);
            if(!empty($search_term))
            {
                
                $terms = explode(" ",$search_term);
                $val = 0;
                foreach($terms as $k => $v)
                {
                    $val = $k + 1;     
                }
                
                if($val==1)
                {
                    $table= 'user';
                    $sql = "SELECT id FROM $table WHERE first_name REGEXP ? OR middle_name REGEXP ? OR last_name REGEXP ? OR email REGEXP ?";
                    $query = $conn->prepare($sql);
                    $query->bindParam(1,$terms[0]);
                    $query->bindParam(2,$terms[0]);
                    $query->bindParam(3,$terms[0]);
                    $query->bindParam(4,$terms[0]);
                    $query->execute();
                    if($query->rowCount()>0)
                    {
                        while($r=$query->fetch(PDO::FETCH_OBJ))
                        {
                            $this->show_glance($r->id);
                        }
                    }else
                    {
                        echo '<a class="bg-danger">Sorry! Nothing Found</a>';
                    }
                        
                }
                
                if($val==2)
                {
                    $table= 'user';
                    $sql = "SELECT id FROM $table WHERE first_name REGEXP ? OR last_name REGEXP ?";
                    $query = $conn->prepare($sql);
                    $query->bindParam(1,$terms[0]);
                    $query->bindParam(2,$terms[1]);
                    $query->execute();
                    if($query->rowCount()>0)
                    {
                     while($r=$query->fetch(PDO::FETCH_OBJ))
                        {
                            $this->show_glance($r->id);
                        }
                    }else
                    {
                        echo '<a class="bg-danger">Sorry! Nothing Found</a>';
                    }
                        
                }
                if($val==3)
                {
                    $table= 'user';
                    $sql = "SELECT id FROM $table WHERE first_name REGEXP ? OR middle_name REGEXP ? OR last_name REGEXP ?";
                    $query = $conn->prepare($sql);
                    $query->bindParam(1,$terms[0]);
                    $query->bindParam(2,$terms[1]);
                    $query->bindParam(3,$terms[2]);
                    $query->execute();
                    if($query->rowCount()>0)
                    {
                    while($r=$query->fetch(PDO::FETCH_OBJ))
                            {
                                $this->show_glance($r->id);
                            }
                    }
                    else{
                        echo '<a class="bg-danger">Sorry! Nothing Found</a>';
                    }
                }
             }
             else{
                echo '<a class="bg-danger">Type a name or email</a>';
             }
        
        
    }
    
    public function show_glance($user_id)
    {
        global $conn;
        $table= 'user';
        $sql = "select sex from $table where id=? limit 1";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$user_id);
        $query->execute();
        $user_info = $query->fetchObject();
        ?>
    
    <a class="bg-info" href="http://localhost/sandeep/profile?id=<?php echo $user_id; ?>"><?php $this->get_full_name($user_id); echo ' ('.ucwords($user_info->sex).')';  ?></a>
      <?php
    }
    
    public function is_member($id)
    {
         global $conn;
        $table= 'user';
        $sql = "select sex from $table where id=? limit 1";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$id);
        $query->execute();
        if($query->rowCount()>0)
        {
            return true;
        }
        else{
            return false;
        }
    }
    
    
    
    
}
$q = new FUNCTIONS;

?>