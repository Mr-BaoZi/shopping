<?php

if(!isset($_SESSION)){
    session_start();
}


function checkAdmin($sql){
	return fetchOne($sql);
}

// function checkAdmin(){
// 	connect();
// 	$s = "select * from admin";
// 	print_r(fetchOne($s));
// }

// checkAdmin();

function checkLogined(){
	if(!isset($_SESSION['adminId']) && !isset($_COOKIE['adminId'])){
		alertMes("请先登录！","../admin/login.php");
	}
}

function logout(){
	$_SESSION['adminId']="";
	$_SESSION=array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(),"",time()-1);
	}
	if(isset($_COOKIE['adminId'])){
		setcookie("adminId","",time()-1);
	}
	if(isset($_COOKIE['adminName'])){
		setcookie("adminName","",time()-1);
	}
	
	session_destroy();
	header("location:login.php");
}

function addAdmin(){
	$arr = $_POST;
	connect();
	if(insert("admin",$arr)){
		$mes = "添加成功！<br/><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员</a>";
	}else{
		$mes = "添加失败！<br/><a href='addAdmin.php'>重新添加</a>";
	}
	return $mes;
}

function getAllAdmin(){

	$sql = "select id ,username, email from admin";
	connect();
	$rows = fetchAll($sql);
	return $rows;
}

function editAdmin($id){
	$arr = $_POST;
	connect();
	if(update("admin",$arr,"id={$id}")){
		$mes = "编辑成功 <br/><a href='listAdmin.php'>查看管理员列表</a>";
	}else{
		$mes = "编辑失败 <br/><a href='listAdmin.php'>查看管理员列表</a>";
	}
	return $mes;
}

function delAdmin($id){
	connect();
	if(delete("admin","id={$id}")){
		$mes = "删除成功 <br/><a href='listAdmin.php'>查看管理员列表</a>";
	}else{
		$mes = "删除失败 <br/><a href='listAdmin.php'>查看管理员列表</a>";
	}
	return $mes;
}