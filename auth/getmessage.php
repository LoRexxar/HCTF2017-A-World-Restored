<?php
require('./class/class.php');

if(!isset($_SESSION['user']))
{
  echo "<script nonce='{$random}'>alert('you need login first!')</script>";
  echo "<script nonce='{$random}'>window.location.href='./login.php'</script>";
  exit; 
}

$user = $_SESSION['user'];

$query="select * from users where username = '{$user}'";
$result = $db->query($query);
$num_results = $result->num_rows;

if($num_results<0)
{
	echo "<script nonce='{$random}'>alert('The username does't exited!')</script>";
	echo "<script nonce='{$random}'>window.location.href='./register.php'</script>";
	exit;

}else{
	$row=$result->fetch_assoc();

	$email = $row['email'];
	$message = $row['message'];
}

$user = htmlspecialchars($user);
$email = htmlspecialchars($email);
$message = htmlspecialchars($message);

$re = array('user' => $user, 'email' => $email, 'message' => $message);

if(isset($_GET['callback'])){
	$callback = htmlspecialchars(trim($_GET['callback']));
}

exit($callback."('".json_encode($re)."');");
