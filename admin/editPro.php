<?php 
// require_once '../core/admin.inc.php';
// require_once '../core/pro.inc.php';
// require_once '../core/cate.inc.php';
require_once '../include.php';
if(!isset($_SESSION)){
    session_start();
}

checkLogined();
$rows=getAllCate(); 

$id = $_REQUEST['id'];
$proInfo = getProById($id);
// print_r($proInfo);
// print_r($rows);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>添加商品</title>
<link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/kindeditor.js"></script>
<script type="text/javascript" charset="utf-8" src="../plugins/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id');
        });
        $(document).ready(function(){
        	$("#selectFileBtn").click(function(){
        		$fileField = $('<input type="file" name="thumbs[]"/>');
        		$fileField.hide();
        		$("#attachList").append($fileField);
        		$fileField.trigger("click");
        		$fileField.change(function(){
        		$path = $(this).val();
        		$filename = $path.substring($path.lastIndexOf("\\")+1);
        		$attachItem = $('<div class="attachItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
        		$attachItem.find(".left").html($filename);
        		$("#attachList").append($attachItem);		
        		});
        	});
        	$("#attachList>.attachItem").find('a').live('click',function(obj,i){
        		$(this).parents('.attachItem').prev('input').remove();
        		$(this).parents('.attachItem').remove();
        	});
        });
</script>
</head>
<body>
<h3>修改商品</h3>
<form  action="doAdminAction.php?act=editPro&id=<?php echo $proInfo[0]['id'] ?>" method="post" enctype="multipart/form-data">
<table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">商品名称</td>
		<td><input type="text" name="pName"  value="<?php echo $proInfo[0]['pName'] ?>"/></td>
	</tr>
	<tr>
		<td align="right">商品分类</td>
		<td>
		<select name="cId">
			<?php foreach($rows as $row): ?>
			<option value="<?php echo $row['id'];?>" <?php echo $row['cName']==$proInfo[0]['cName']?"selected='selected'":null;?>><?php echo $row['cName'];?></option>
			<?php endforeach; ?>
			
		</select>
		</td>
	</tr>
	<tr>
		<td align="right">商品货号</td>
		<td><input type="text" name="pSn"  value="<?php echo $proInfo[0]['pSn'] ?>"/></td>
	</tr>
	<tr>
		<td align="right">商品数量</td>
		<td><input type="text" name="pNum"  value="<?php echo $proInfo[0]['pNum'] ?>"/></td>
	</tr>
	<tr>
		<td align="right">商品市场价</td>
		<td><input type="text" name="mPrice"  value="<?php echo $proInfo[0]['mPrice'] ?>"/></td>
	</tr>
	<tr>
		<td align="right">商品慕课价</td>
		<td><input type="text" name="iPrice"  value="<?php echo $proInfo[0]['iPrice'] ?>"/></td>
	</tr>
	<tr>
		<td align="right">商品描述</td>
		<td>
			<textarea name="pDesc" id="editor_id" style="width:100%;height:150px;">
			<?php echo $proInfo[0]['pDesc'] ?>
			</textarea>
		</td>
	</tr>
	<tr>
		<td align="right">商品图像</td>
		<td>
			<a href="javascript:void(0)" id="selectFileBtn">添加附件</a>
			<div id="attachList" class="clear"></div>
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="编辑商品"/></td>
	</tr>
</table>
</form>
</body>
</html>