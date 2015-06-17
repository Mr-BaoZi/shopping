<?php
// require_once '../lib/common.func.php';
// require_once '../core/admin.inc.php';
// require_once '../lib/mysql.func.php';
require_once '../include.php';
if(!isset($_SESSION)){
    session_start();
}

$username=$_POST['username'];
//$username=addslashes($username);
$password=$_POST['password'];
$verify=$_POST['verify'];

if(isset($_POST['autoFlag'])){
	$autoFlag=$_POST["autoFlag"];
}else{
	$autoFlag = 0;
}


$verify1=$_SESSION['verify'];

if($verify==$verify1){
	$link = connect();
	$sql="select * from admin where username='{$username}' and password='{$password}'";
	// $sql="select * from admin";
	$row=checkAdmin($sql);
	// var_dump($row);
	if($row){
		if($autoFlag){
			setcookie("adminId",$row['id'],time()+7*24*3600);
			setcookie("adminName",$row['username'],time()+7*24*3600);
		}
		$_SESSION['adminId']=$row['id'];
		$_SESSION['adminName']=$row['username'];
		alertMes("登陆成功","index.php");
	}else{
		alertMes("登陆失败，重新登陆","login.php");
	}
}else{
	alertMes("验证码错误","login.php");
	// echo "post :";
	// print($verify);
	// echo '  session ';
	// print($verify1);
	//print_r($_POST["autoFlag"]);
}