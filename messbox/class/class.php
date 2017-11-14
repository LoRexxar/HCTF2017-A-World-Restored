<?php
require('config.php');

function filter($string){
	$safe = array('select', 'insert', 'update', 'delete', 'where');
 	$safe = '/' . implode('|', $safe) . '/i';
 	$string = preg_replace($safe, '', $string);

	$xsssafe = array('img','script','on','svg','link');
	$xsssafe = '/' . implode('|', $xsssafe) . '/i';
	return preg_replace($xsssafe, '', $string);
		

}

function createRandomStr($length){ 
	$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$strlen = 62; 
	while($length > $strlen){ 
		$str .= $str; 
		$strlen += 62; 
	} 
	$str = str_shuffle($str); 

	return substr($str,0,$length); 
} 


function select($user){
	global $db;

	$query = "select * from users where username = '{$user}'";
	$result = $db->query($query);

	$req = $result->fetch_assoc();

	return $req;
}

function CreateToken($user){
	global $secret;

	$token = substr(sha1($user.$secret),6,16);

	return base64_encode($token."|".base64_encode($user));
}

function CheckToken($token){
	global $secret;

	$arr = explode("|", base64_decode($token));
	$token = $arr[0];
	$user = base64_decode($arr[1]);

	if($token === substr(sha1($user.$secret),6,16)){
		$_SESSION['user'] = $user;
		return True;
	}else{
		return False;
	}
}

ini_set('date.timezone','Asia/Shanghai');
ini_set("session.cookie_httponly", 1);
session_start();

$random = substr(md5(createRandomStr(12)),8,18);

header("Content-Security-Policy: default-src 'self' http://auth.2017.hctf.io http://messbox.2017.hctf.io; script-src 'nonce-{$random}' http://auth.2017.hctf.io http://messbox.2017.hctf.io 'unsafe-eval'; style-src 'self' https://maxcdn.bootstrapcdn.com 'unsafe-inline'; font-src https://maxcdn.bootstrapcdn.com");

$flag = "hctf{xs5_iz_re4lly_complex34e29f}";
$flag2 = "hctf{mayb3_m0re_way_iz_best_for_ctf}";
#$flag2 = "test";

if(!empty($_SESSION['user'])){
        if($_SESSION['user'] === 'hctf_admin_LoRexxar2e23322'){
                setcookie("flag", $flag, time()+3600*48," ","messbox.2017.hctf.io", 0, true);
        }
                
        if($_SESSION['user'] === 'hctf_admin_LoRexxar2e23322' && $_GET['check']=="233e"){
                setcookie("flag2", $flag2, time()+3600*48," ",".2017.hctf.io");
        }
}


if(!empty($_GET['token'])){
  if(!CheckToken(trim($_GET['token']))){
    die("What's are you doing? hakcer!");
  }
}
?>
