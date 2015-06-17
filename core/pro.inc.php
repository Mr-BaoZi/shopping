<?php 
 
function addPro(){
	$arr=$_POST;
	$arr['pubTime']=time();
	
	$path="./uploads";//存放源文件地址
	$uploadFiles = uploadFile($path);
	// print_r($uploadFiles);
	//多个文件
	if(is_array($uploadFiles)&&$uploadFiles){
		foreach ($uploadFiles as $uploadFile) {
			thumb($path."/".$uploadFile['name'],"../img/img_50/".$uploadFile['name'],50,50);
			thumb($path."/".$uploadFile['name'],"../img/img_220/".$uploadFile['name'],220,220);
			thumb($path."/".$uploadFile['name'],"../img/img_350/".$uploadFile['name'],350,350);
			thumb($path."/".$uploadFile['name'],"../img/img_800/".$uploadFile['name'],800,800);
		}
	}
	connect();
	$pid = insert("product",$arr);

	if($pid){
		foreach ($uploadFiles as  $uploadFile) {
			$arr_album['pid'] = $pid;
			$arr_album['albumPath'] = $uploadFile['name'];
			addAlbum($arr_album);
		}
		$mes="<p>添加成功!</p><a href='addPro.php' target='mainFrame'>继续添加</a>|<a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}else{//如果上传不成功，删除图片
		foreach ($uploadFiles as $uploadFile) {
			if(file_exists("../img/img_820/".$uploadFile['name'])){
				unlink("../img/img_820/".$uploadFile['name']);
			}
			if(file_exists("../img/img_50/".$uploadFile['name'])){
				unlink("../img/img_50/".$uploadFile['name']);
			}
			if(file_exists("../img/img_220/".$uploadFile['name'])){
				unlink("../img/img_220/".$uploadFile['name']);
			}
			if(file_exists("../img/img_350/".$uploadFile['name'])){
				unlink("../img/img_350/".$uploadFile['name']);
			}
		}
		$mes="<p>添加失败!</p><a href='addPro.php' target='mainFrame'>重新添加</a>";
	}
	return $mes;

}
/**
 * 编辑/修改商品信息
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function editPro($id){
	$arr=$_POST;
	// $arr['pubTime']=time();
	
	$path="./uploads";//存放源文件的地址
	$uploadFiles = uploadFile($path);
	// print_r($uploadFiles);
	//多个文件
	if(is_array($uploadFiles)&&$uploadFiles){
		foreach ($uploadFiles as $uploadFile) {
			thumb($path."/".$uploadFile['name'],"../img/img_50/".$uploadFile['name'],50,50);
			thumb($path."/".$uploadFile['name'],"../img/img_220/".$uploadFile['name'],220,220);
			thumb($path."/".$uploadFile['name'],"../img/img_350/".$uploadFile['name'],350,350);
			thumb($path."/".$uploadFile['name'],"../img/img_800/".$uploadFile['name'],800,800);
		}
	}
	connect();
	$where = "id={$id}";
	$res = update("product",$arr,$where);

	if($res){
		if(is_array($uploadFiles)&&$uploadFiles){
			foreach ($uploadFiles as  $uploadFile) {
				$arr_album['pid'] = $id;
				$arr_album['albumPath'] = $uploadFile['name'];
				addAlbum($arr_album);
			}
		}
		$mes="<p>修改成功!</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}else{//如果上传不成功，删除图片
		if(is_array($uploadFiles)&&$uploadFiles){
			foreach ($uploadFiles as $uploadFile) {
				if(file_exists("../img/img_820/".$uploadFile['name'])){
					unlink("../img/img_820/".$uploadFile['name']);
				}
				if(file_exists("../img/img_50/".$uploadFile['name'])){
					unlink("../img/img_50/".$uploadFile['name']);
				}
				if(file_exists("../img/img_220/".$uploadFile['name'])){
					unlink("../img/img_220/".$uploadFile['name']);
				}
				if(file_exists("../img/img_350/".$uploadFile['name'])){
					unlink("../img/img_350/".$uploadFile['name']);
				}
			}
		}
		$mes="<p>没有数据改动？!</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}
	return $mes;
}

function delPro($id){
	//删除文件
	$proImages = getAllImgByProId($id);
	if($proImages&&is_array($proImages)){
		foreach ($proImages as $img) {
			if(file_exists("./uploads/".$img['albumPath']))
				unlink("./uploads/".$img['albumPath']);
			if(file_exists("../img/img_350/".$img['albumPath']))
				unlink("./img/img_350/".$img['albumPath']);
			if(file_exists("./img/img_220/".$img['albumPath']))
				unlink("./img/img_220/".$img['albumPath']);
			if(file_exists("./img/img_50/".$img['albumPath']))
				unlink("./img/img_50/".$img['albumPath']);
			if(file_exists("./img/img_800/".$img['albumPath']))
				unlink("./img/img_800/".$img['albumPath']);
		}
	}
	connect();
	//删除product表中数据
	$where = "id={$id}";
	$res = delete("product",$where);

	//删除album表中数据
	$where_album="pid={$id}";
	$res_album = delete("album",$where_album);

	if($res&&$res_album){
		print_r($res);
		print_r($res_album);
		$mes = "<p>删除成功</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}else{
		$mes = "<p>删除失败</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}
	return $mes;
}
/**
 * 获取图片路径
 * @param  [int] $id [description]
 * @return [array]     [description]
 */
function getAllImgByProId($id){
	$sql = "select albumPath from album where pid={$id}";
	connect();
	$rows = fetchAll($sql);
	return $rows;
}

/**
 * 根据ID获取商品信息
 * @param  [int] $id [description]
 * @return [array]     [description]
 */
function getProById($id){
	$sql = "select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName from product  p join cate  c on p.cId=c.id where p.id={$id}";	
	connect();
	$row = fetchAll($sql);
	return $row;
}
/**
 * 检查分类下是否有产品
 * @param  [type] $cid [description]
 * @return [type]      [description]
 */
function checkProExist($cid){
	$sql = "select * from product where cId={$cid}";
	connect();
	$rows=fetchAll($sql);
	return $rows;
}

/**
 *根据cid得到4条产品
 * @param int $cid
 * @return Array
 */
function getProsByCid($cid){
	$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from product p join cate c on p.cId=c.id where p.cId={$cid} limit 4";
	$rows=fetchAll($sql);
	return $rows;
}
