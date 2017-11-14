<?php
require('./class/header.php');

if(!empty($_POST['user']) && !empty($_POST['pass'] && !empty($_POST['csrftoken']))){

	$user=trim($_POST['user']);
	$pass=md5(trim($_POST['pass']));
	$csrftoken = trim($_POST['csrftoken']);
	
	if($csrftoken != $_SESSION['csrftoken']){
		die("what's up? hacker!!");
	}

	if(!get_magic_quotes_gpc()) { 
        $user = addslashes($user);
        $pass = addslashes($pass);
    } 
	
	$query="select password from users where username = '{$user}'";
	$result=$db->query($query);
	$result_num=$result->num_rows;

	if($result_num==0)
	{
		echo "<script nonce='{$random}'>alert('username or password is wrong!')</script>";
		echo "<script nonce='{$random}'>window.location.href='./login.php'</script>";
		exit;	
	}

	else
	{
		$row=$result->fetch_assoc();
		$password=$row['password'];
		if($pass==$password)
		{
			$_SESSION['user'] = $user;
		}
		else
		{
		echo "<script nonce='{$random}'>alert('username or password is wrong!')</script>";
		echo "<script nonce='{$random}'>window.location.href='./login.php'</script>";
		exit;	
		}
	}
}
function GetIP(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif(!empty($_SERVER["REMOTE_ADDR"])){
		$cip = $_SERVER["REMOTE_ADDR"];
	}
	else{
		$cip = "NULL";
	}
	 return $cip;
}

if(!empty($_SESSION['user'])){

	$usertoken = CreateToken($_SESSION['user']);

	if(!empty($_GET['n_url'])){
		$n_url = trim($_GET['n_url']);
		// header("location: ".$n_url."?token=".$usertoken);
		$file  = 'it51zlog_l1nk3e23.log';
		$content = sprintf("ip: %s , user: %s \r\nlink: %s\r\n--------------\r\n", GetIP(), $user, $n_url);
		$f  = file_put_contents($file, $content,FILE_APPEND);


		echo "<script nonce='{$random}'>window.location.href='".$n_url."?token=".$usertoken."'</script>";
		exit;
	}else{
		// header("location: http://messbox.hctf.com?token=".$usertoken);
		echo "<script nonce='{$random}'>window.location.href='http://messbox.2017.hctf.io?token=".$usertoken."'</script>";
		exit;
	}
}


$csrftoken = substr(md5(createRandomStr(16)),4,8);
$_SESSION['csrftoken'] = $csrftoken;
	
?>

 <body>
  <section class="hero is-medium is-primary is-bold">
    <div class="hero-body">
    	<div class="container">
	      <h1 class="title">
	        Hello World, Welcome to A World Restored.
	      </h1>
	      <p class="subtitle">
	        Login pages for <strong>A World Restored</strong>!
	      </p>

	    <div class="box back">
            <form id="login" method="post" class="form-signin" action="login.php<?php if(!empty($_GET['n_url'])){echo "?n_url=".urlencode($_GET['n_url']);} ?>">
              <div class="field">
                <div class="control">
                  <input class="input is-large" type="text" placeholder="Username" name="user" autofocus="">
                </div>
              </div>

              <div class="field">
                <div class="control">
                  <input class="input is-large" type="password" placeholder="Password" name="pass">
                </div>
              </div>

              <input class="input is-large" type="hidden" name="csrftoken" value=<?=$csrftoken?>>

              <div class="columns">
              	<div class="column">
              		<a id="login-btn" class="button is-block is-info">Login</a>
              	</div>
              	<div class="column">
              		<a class="button is-block is-info" href="register.php">Register</a>
        	  	</div>
              	

              </div>
            </form>
          </div>
	  	</div>
    </div>
  </section>
<script nonce="<?=$random?>">
document.getElementById("login-btn").addEventListener("click", function(e){
	e.preventDefault();
	e.stopPropagation();
	document.getElementById("login").submit();
	return false;
});


</script>
</body>

<?php
	require('./class/footer.php');
?>
