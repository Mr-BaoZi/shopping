<?php
function buildRandomString($type = 1,$length = 4){

	if($type==1){
		$chars=join("",range(0,9));
	}elseif ($type==2) {
		$chars=join("",array_merge(range("a","z"),range("A","Z")));
	}elseif ($type=3) {
		$chars=join("",array_merge(range("a","z"),range("A","Z"),range(0,9)));
	}

	if($length > strlen($chars)){
	exit("字符串长度不够");
	}
	//乱序
	$chars = str_shuffle($chars);
	return substr($chars,0,$length);
}

/**
 * 生成唯一字符串
 * @return string (unique)
 */
function getUniqName(){
	return md5(uniqid(microtime(true),true));
}
// echo getUniqName();
/**
 * 得到文件扩展名
 * @param  文件名 
 * @return 扩展名
 */
function getExt($filename){
	return strtolower(end(explode(".", $filename)));
}
