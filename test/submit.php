<?php

$act = $_REQUEST['act'];

if(isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
}

if($act=="logout"){
	logout();
}elseif ($act=="addAdmin") {
	$mes = addAdmin();
}elseif($act=="editAdmin"){
	$mes = editAdmin($id);
}elseif($act=="delAdmin"){
	$mes = delAdmin($id);
}elseif ($act=="addCate") {
	$mes = addCate();
}elseif ($act=="delCate") {
	$mes = delCate($id);
}elseif ($act=="editCade") {
	$mes = editCate($id);
}elseif ($act=="addPro") {
	$mes="addPro";
	//$mes = addPro();
}

$arr="";
for($i=0;$i<9;$i++){
	$arr[].=$i;
}

var_dump($arr);

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	if($mes){
		print_r($mes);
		print_r($_REQUEST);
	}
?>
</body>
</html>