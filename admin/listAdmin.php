<?php 
// require_once '../core/admin.inc.php';
// require_once '../lib/page.func.php';
require_once '../include.php';
//分页显示，每页5条记录
$pageSize = 5;

$sql = "select * from admin ";
connect();
$totalRows = getResultNum($sql);
// echo $totalRows;


$totalPages = ceil($totalRows/$pageSize);

$page=$_REQUEST?(int)$_REQUEST['page']:1;

if($page<1||$page==null|!is_numeric($page)){
    $page = 1;
}
if($page>$totalPages){
    $page = $totalPages;
}

$offset = ($page-1)*$pageSize;

$sql = "select * from admin limit {$offset},{$pageSize}";
$rows = fetchAll($sql);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>2</title>
<link rel="stylesheet" href="styles/backstage.css">
</head>
<body>
<div class="details">
                    <div class="details_operation clearfix">
                        <div class="bui_select">
                            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addAdmin()">
                        </div>
                            
                    </div>
                    <!--表格-->
                    <table class="table" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="15%">编号</th>
                                <th width="25%">管理员名称</th>
                                <th width="30%">管理员邮箱</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($rows as $row):?>
                            <tr>
                                <!--这里的id和for里面的c1 需要循环出来-->
                                <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
                                <td><?php echo $row['username'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td align="center"><input type="button" value="修改" class="btn" onclick="editAdmin(<?php echo $row['id']; ?>)"><input type="button" value="删除" class="btn" onclick="delAdmin(<?php echo $row['id'];?>)" ></td>
                            </tr>
                           
                            <?php endforeach;?>
                            <?php if($rows>$pageSize): ?>
                            <tr>
                            	<td colspan="4"><?php echo showPage($page,$totalPages);?> </td>
                            </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
<script type="text/javascript">
	function editAdmin(id){
		window.location="editAdmin.php?id="+id;
	}
	function delAdmin(id){
		if(window.confirm("您确定要删除吗？删除之后不能恢复哦！！！")){
			window.location="doAdminAction.php?act=delAdmin&id="+id;
		}
	}
	function addAdmin(){
		window.location="addAdmin.php";
	}
</script>
</body>
</html>