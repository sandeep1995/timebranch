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
                $fname = ucwords(strtolower(trim($_POST['firstname'])));
                $mname = ucwords(strtolower(trim($_POST['middlename'])));
                $lname = ucwords(strtolower(trim($_POST['lastname'])));
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
		window.location.href = 'http://localhost/sandeep/home';
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

    public function post_status($user_id,$status) {
        global $conn;
        $status = trim($status);
        $table = "posts";
        $time = time();
        $sql = "insert into $table (user_id,status,posted_at) values(?,?,?)";
        $query = $conn->prepare($sql);
        $query->bindParam(1,$user_id);
        $query->bindParam(2,$status);
        $query->bindParam(3,$time);
        if($query->execute()){
            return 1;
        }
        else{
            return 0;
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

						<form class="navbar-form navbar-right" method="post" action="" role="search">
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


				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->
		</nav>


		<script>
			$('#searchResult').hide();

			function search_for(query) {
				if (query != "") {
					$.ajax({
						url: 'http://localhost/sandeep/php/search.php',
						method: 'GET',
						data: {
							'query': query
						},
						success: function(result) {
							$('#searchResult').slideDown('fast');
							$('#searchResult').html('<li>' + result + '</li>');
						},
						error: function() {
							$('#searchResult').html('We are having some problem');
						},
						complete: function() {
							document.onclick = function() {
								$('#searchResult').slideUp(600);

							}

						}
					});
				}
			}
		</script>
		<?php
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
				window.location.href = 'http://localhost/sandeep/home';
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

				<a style="text-decoration: none; color: #1f99f3;" href="http://localhost/sandeep/profile?id=<?php echo $user_id; ?>"><?php $this->get_full_name($user_id); ?></a>
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


    public function news_feed($user_id, $flag=true){
        if($flag){
            $fried_ids[0]= $user_id;
        }else{
                $fried_ids = $this->get_friend_ids($user_id);
                global $conn;

                if($fried_ids[0]==0){
                    $fried_ids[0]= $user_id;
                }
                else{
                  array_push($fried_ids, $user_id);
                }
        }
        global $conn;
        $table = "posts";
       // print_r($fried_ids);
        $total_question_marks = count($fried_ids);
       // echo $total_question_marks;
        $question_mark_array = array_fill(0, $total_question_marks, '?');
      //  print_r($question_mark_array);
        $str = implode(",",$question_mark_array);
      //  echo $str;
        $sql = "select * from $table where user_id in ($str) order by posted_at desc";
      //  echo $sql;
        $query = $conn->prepare($sql);
        foreach($fried_ids as $k => $v){
            @$query->bindParam($k+1,trim($v));
        }
        $query->execute();
        while($result = $query->fetch(PDO::FETCH_OBJ)){
            ?><div style=" border: 1px solid #ccc; box-shadow: 1px 1px 1px #ccc; margin-bottom: 20px; padding: 20px;">
                <h4><?php $this->show_glance($result->user_id);?></h4>
                <p class="lead">
                    <?php echo $result->status; ?>
                </p>
                <small>
                    <hr>
                    <?php echo $this->time_elapsed($result->posted_at); ?>
                </small>
            </div>
            <?php
        }

    }


    public function time_elapsed($time){
    $secs = time() - $time;
    if($secs < 90){
        return 'just now';
    }

    if($secs < 3600*24*3){
    $ret[] = "";
    $bit = array(
        ' year'        => $secs / 31556926 % 12,
        ' week'        => $secs / 604800 % 52,
        ' day'        => $secs / 86400 % 7,
        ' hour'        => $secs / 3600 % 24,
        ' minute'    => $secs / 60 % 60,
        ' second'    => $secs % 60
        );

    foreach($bit as $k => $v){
        if($v > 1)$ret[] = $v . $k . 's';
        if($v == 1)$ret[] = $v . $k;
        }
    array_splice($ret, count($ret)-1, 0, 'and');
    $ret[] = 'ago.';
    return join(' ', $ret);
    }
    else {
        $ts = $time;
        $date = new DateTime("@$ts");
        echo $date->format('H:i d/m/Y') . "\n";
    }
    }

    public function people_you_may_know_of($user_id){
        $friends= $this->get_friend_ids($user_id);
        global $conn;
        $table= 'user';
        $total_question_marks = count($friends);
        $question_mark_array = array_fill(0, $total_question_marks, '?');
        $str = implode(",",$question_mark_array);
        $sql = "select id from $table where id not in ($str) order by rand() limit 10";
        $query = $conn->prepare($sql);
        foreach($friends as $k => $v){
            @$query->bindParam($k+1,trim($v));
        }
        $query->execute();
        $user_info = $query->fetchAll(PDO::FETCH_OBJ);
        $array_people_you_may_know = array();
        foreach($user_info as $k => $v){
            if(($v->id)!= $user_id){
                array_push($array_people_you_may_know,$v->id);
            }
        }
        if(!empty($array_people_you_may_know)){
        foreach($array_people_you_may_know as $key => $value){
             ?>
            <div class="well"> <?php $this->show_glance($value); $this->no_of_mutual_frineds($user_id,$value); ?></div>
            <?php
        }
        }
        else{
            echo '<div class="well">Try to make friends first';
        }
    }

    public function no_of_mutual_frineds($user_id, $other_id){
        $user_friends = $this->get_friend_ids($user_id);
        if(count($user_friends) == 1){
            echo '<div class="small">[ 0 common ]</div>';
        }
        else{
            $i = 0;
             $other_friends = $this->get_friend_ids($other_id);
             foreach($other_friends as $key => $val){
                if(in_array($val,$user_friends)){
                    $i++;
                }
             }
             echo '<div class="small">[ '.$i.' common ]</div>';
        }
    }

    public function return_mutual_ids($user_id, $other_id){
        $return_array = array();
        $user_friends = $this->get_friend_ids($user_id);
        if(count($user_friends) == 1){
            return $return_array;
        }
        else{
            $i = 0;
             $other_friends = $this->get_friend_ids($other_id);
             foreach($other_friends as $key => $val){
                if(in_array($val,$user_friends)){
                    $return_array[$i] = $val;
                    $i++;
                }
             }
             return $return_array;
        }
    }    
}

$q = new FUNCTIONS;

?>
