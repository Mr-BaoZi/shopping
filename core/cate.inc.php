<?php
 
function addCate(){
	$arr = $_POST;
	connect();
	if(insert("cate",$arr)){
		$mes="添加成功！<br/><a href='addCate.php'>继续添加</a>|<a href='listCate.php'>查看分类</a>";
	}else{
		$mes="添加失败！ <br/><a href='addCate.php'>重新添加</a>|<a href='listCate.php'>查看分类</a>";
	}
	return $mes;
}

function delCate($id){
	$res=checkProExist($id);
	connect();

	if(!$res){
		if(delete("cate","id={$id}")){
			$mes = "删除成功 <br/><a href='listCate.php'>查看分类列表</a>";
		}else{
			$mes = "删除失败 <br/><a href='listCate.php'>查看分类列表</a>";
		}
	}else{
		$mes = "该分类下有商品，不能删除 <br/><a href='listPro.php'>查看该分类下商品列表</a>|<a href='listCate.php'>查看分类列表</a>";
	}
	return $mes;
}

function editCate($id){
	$arr = $_POST;
	connect();
	if(update("cate",$arr,"id={$id}")){
		$mes = "编辑成功 <br/><a href='listCate.php'>查看分类列表</a>";
	}else{
		$mes = "编辑失败 <br/><a href='listCate.php'>查看分类列表</a>";
	}
	return $mes;
}

/**
 * 得到所有商品分类
 * @return 商品分类名称
 */
function getAllCate(){
	$sql = "select id,cName from cate";
	connect();
	$rows = fetchAll($sql);
	return $rows;
}

