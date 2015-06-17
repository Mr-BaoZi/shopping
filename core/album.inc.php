<?php 

function addAlbum($arr){
	$mysql_insert_id = insert("album",$arr);
	return $mysql_insert_id;
}

/**
 * 根据商品id得到商品图片
 * @param int $id
 * @return array
 */
function getProImgById($id){
	$sql="select albumPath from album where pid={$id} limit 1";
	// connect();
	$row=fetchOne($sql);
	return $row;
}

function getProImgsById($id){
	$sql="select albumPath from album where pid={$id} ";
	// connect();
	$row=fetchAll($sql);
	return $row;
}
