<?php
require('./class/header.php');

if(!isset($_SESSION['user']))
{
	echo "<script nonce='{$random}'>alert('you need login first!')</script>";
	echo "<script nonce='{$random}'>window.location.href='http://auth.2017.hctf.io/login.php?n_url='+document.URL</script>";
	exit;	
}

$user = $_SESSION['user'];

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

if(!empty($_POST['csrftoken']) && !empty($_POST['link']) && !empty($_POST['code'])){

	$link = trim($_POST['link']);
	$code = trim($_POST['code']);

	$csrftoken = trim($_POST['csrftoken']);
	if($csrftoken != $_SESSION['csrftoken']){
		die("what's up? hacker!!");
	}
	
	if(substr(md5($code),0,6) != $_SESSION['captcha']){
		echo "<script nonce='{$random}'>alert('Verification Code error...')</script>";
		echo "<script nonce='{$random}'>window.location.href='./report.php'</script>";
		exit;
	}

	if(!get_magic_quotes_gpc()) {
        $link = addslashes($link);
	}

	if(((strcasecmp(substr($link,0,25), "http://auth.2017.hctf.io/")) != 0) && ((strcasecmp(substr($link,0,28), "http://messbox.2017.hctf.io/")) != 0)){
		echo "<script nonce='{$random}'>alert('No,No,No!!! Only from hctf...')</script>";
		echo "<script nonce='{$random}'>window.location.href='./report.php'</script>";
		exit;
	}


	$query = "insert into records (link) values ('{$link}')";
	$result = $db->query($query);

	if($result){
		$file  = 'it51zlog_link23.log';
		$content = sprintf("ip: %s , link: %s \r\n", GetIP(), $link);
		$f  = file_put_contents($file, $content,FILE_APPEND);


		echo "<script nonce='{$random}'>alert('report success...')</script>";
		echo "<script nonce='{$random}'>window.location.href='./index.php'</script>";
		exit;
	}else{
		echo "<script nonce='{$random}'>alert('database error, please Contact administrator...')</script>";
	}
}

$captcha=substr(md5(rand(1000000,9999999)),0,6);
$_SESSION['captcha']=$captcha;

$csrftoken = substr(md5(createRandomStr(16)),4,8);
$_SESSION['csrftoken'] = $csrftoken;

?>


<section class="hero is-info is-large">
  <div class="hero-head">
    <nav class="navbar">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item">
            <h3>HCTF2017</h3>
          </a>
          <span class="navbar-burger burger" data-target="navbarMenuHeroB">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </div>
        <div id="navbarMenuHeroB" class="navbar-menu">
          <div class="navbar-end">
            <a class="navbar-item" href="index.php">
              Home
            </a>
            <a class="navbar-item" href="user.php">
              User
            </a>
            <a class="navbar-item">
              Loading
            </a>
            <a class="navbar-item is-active" href="report.php">
              Report Bug
            </a>
		    <span class="navbar-item">
		      <h3><?=$user?></h3>
		      <a class="button is-success is-outlined" style="margin-left: 10px" href="http://auth.2017.hctf.io/logout.php">  logout</a>
		    </span>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <div class="hero-body" style="padding-top: 20px">
    <div class="container has-text-centered">

    	<h1 class="title">
        	Hello World, Welcome to A World Restored.
      	</h1>
      	<p class="subtitle">
        	Report pages to report bug for <strong>A World Restored</strong>!
      	</p>

      <div class="box back">
            <form id="report" method="post" class="form-signin" action="report.php">
              <div class="field">
                <div class="control">
                  <input class="input" type="text" placeholder="Link" name="link" autofocus="">
                </div>
              </div>

              <div class="field">
                <div class="control">
                	<h4 class="black">substr(md5($code),0,6) == '<?=$captcha?>'</h4>
                 	<input class="input" type="text" placeholder="code" name="code">
                </div>
              </div>

              <input class="input" type="hidden" name="csrftoken" value=<?=$csrftoken?> >

              <div class="columns">
              	<div class="column">
              		<a id="report-btn" class="button is-block is-info">Report</a>
              	</div>
              	<div class="column">
        	  	</div>

              </div>
            </form>
          </div>
    </div>
  </div>
</section>

<script nonce='<?=$random?>'>

document.getElementById("report-btn").addEventListener("click", function(e){
	e.preventDefault();
	e.stopPropagation();
	document.getElementById("report").submit();
	return false;
});

</script>


<?php
  require('./class/footer.php');
?>
