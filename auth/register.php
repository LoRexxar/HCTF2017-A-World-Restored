<?php
require('./class/header.php');

if(!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['email']) && !empty($_POST['message'] && !empty($_POST['csrftoken']))){

	$csrftoken = trim($_POST['csrftoken']);
	if($csrftoken != $_SESSION['csrftoken']){
		die("what's up? hacker!!");
	}


	$user=filter(trim($_POST['user']));
	$pass=md5(trim($_POST['pass']));
	$email=trim($_POST['email']);
	$message=trim($_POST['message']);

	if(!get_magic_quotes_gpc()) { 
	        $user = addslashes($user);
	        $pass = addslashes($pass);
	        $email = addslashes($email);
	        $message = addslashes($message);
	}

	$query="select * from users where username = '{$user}'";
	$result = $db->query($query);
	$num_results = $result->num_rows;

	if($num_results>0)
	{
		echo "<script nonce='{$random}'>alert('This Username is exited!')</script>";
		echo "<script nonce='{$random}'>window.location.href='./register.php'</script>";
		exit;

	}else{
		
		$query = "insert into users (username, password, email, message) values ('{$user}', '{$pass}', '{$email}', '{$message}')";
		$result = $db->query($query);

		if($result){
			echo "<script nonce='{$random}'>alert('Register success...')</script>";
			echo "<script nonce='{$random}'>window.location.href='./login.php'</script>";
			exit;
		}else{
			echo "<script nonce='{$random}'>alert('something error...')</script>";
		}
	}

	$db->close();

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
	        Register pages for <strong>A World Restored</strong>!
	      </p>
	  	
<div class="back box is-half is-offset-one-fifth">

<form id="reg" method="post" class="form-signin" action="register.php">

<div class="field">
  <label class="label">Username</label>
  <div class="control">
    <input id="user" class="input" type="text" placeholder="name" name="user" autofocus>
  </div>
</div>

<div class="field">
  <label class="label">Password</label>
  <div class="control">
    <input id="pass" class="input" type="password" placeholder="password" name="pass" value="">
  </div>
</div>

<div class="field">
  <label class="label">Email</label>
  <div class="control">
    <input id="email" class="input" type="email" placeholder="email" name="email" value="">
  </div>
</div>

<div class="field">
  <label class="label">Message</label>
  <div class="control">
    <textarea id="mess" class="textarea" placeholder="Message" name="message"></textarea>
    <input class="input" type="hidden" name="csrftoken" value="<?=$csrftoken?>">
  </div>
</div>

<div class="field is-grouped">
  <div class="control">
    <button id="reg-btn" class="button is-link">Submit</button>
  </div>
  <div class="control">
    <button id="cancel-btn" class="button is-text">Cancel</button>
  </div>
</div>

</form>
 
</div>

</div>
</div>
</section>

<script nonce='<?=$random?>'>

document.getElementById("reg-btn").addEventListener("click", function(e){
	e.preventDefault();
	e.stopPropagation();
	document.getElementById("reg").submit();
	return false;
});

document.getElementById("cancel-btn").addEventListener("click", function(e){
	e.preventDefault();
	e.stopPropagation();
	location.href = 'http://messbox.2017.hctf.io/';
	return false;
});


</script>


</body>


<?php
	require('./class/footer.php');
?>
