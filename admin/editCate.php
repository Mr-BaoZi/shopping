<?php
// require_once "../lib/mysql.func.php";
require_once '../include.php';
$id = $_GET['id'];
$sql = "select cName from cate where id={$id}";
connect();
$row = fetchOne($sql);
//print_r($row);
?>

<!DOCTYPE html>
<html>
<head>
	<title> </title>
</head>
<body>
<h3>添加管理员</h3>
	<form action="doAdminAction.php?act=editCade&id=<?php echo $id?>" method="post">
		<table width="60%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
			<tr>
				<td align="right">
					分类名称
				</td>
				<td>
					<input type="text" name="cName" placeholder="<?php echo $row['cName'];?>" />
				</td>
			</tr>
		
			<tr>
				<td colspan="2">
					<input type="submit" value="编辑分类" />
				</td>
			</tr>
		</table>
	</form>

</body>
</html>