<?php
// require_once '../core/admin.inc.php';
// require_once '../core/cate.inc.php';
// require_once '../core/pro.inc.php';
require_once '../include.php';
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
	$mes = addPro();
}elseif ($act=="editPro") {
	$mes = editPro($id);
}elseif ($act=="delPro") {
	$mes = delPro($id);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	if($mes){
		// echo $id;
		print_r($mes);
	}
?>
</body>
</html>