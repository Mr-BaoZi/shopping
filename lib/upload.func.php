<?php

header("content-type:text/html;charset=utf-8");

/**
 * 构建上传文件信息
 * @return array
 */
function buildInfo(){
	if(!$_FILES){
		return ;
	}
	$i=0;
	foreach($_FILES as $v){
		//单文件
		if(is_string($v['name'])){
			$files[$i]=$v;
			$i++;
		}else{
			//多文件
			foreach($v['name'] as $key=>$val){
				$files[$i]['name']=$val;
				$files[$i]['size']=$v['size'][$key];
				$files[$i]['tmp_name']=$v['tmp_name'][$key];
				$files[$i]['error']=$v['error'][$key];
				$files[$i]['type']=$v['type'][$key];
				$i++;
			}
		}
	}
	return $files;
}

/**
 * 上传文件
 * @param  string  $path     [文件保存路径]
 * @param  array   $allowExt [允许上传文件格式]
 * @param  integer $maxSize  [文件最大字节数]
 * @return [array]            [文件信息]
 */
function uploadFile($path="uploads",$allowExt=array("gif","jpeg","png","jpg","wbmp"),$maxSize=2097152){
	if(!file_exists($path)){
		mkdir($path,0777,true);
	}
	$i=0;
	$files=buildInfo();
	if(!($files&&is_array($files))){
		return ;
	}
	foreach($files as $file){
		if($file['error']===UPLOAD_ERR_OK){
			$ext=getExt($file['name']);
			//检测文件的扩展名
			if(!in_array($ext,$allowExt)){
				exit("非法文件类型");
			}
			//校验是否是一个真正的图片类型
			
			if(!getimagesize($file['tmp_name'])){
				exit("不是真正的图片类型");
			}
			
			//上传文件的大小
			if($file['size']>$maxSize){
				exit("上传文件过大");
			}
			if(!is_uploaded_file($file['tmp_name'])){
				exit("不是通过HTTP POST方式上传上来的");
			}
			$filename=getUniqName().".".$ext;
			$destination=$path."/".$filename;
			if(move_uploaded_file($file['tmp_name'], $destination)){
				$file['name']=$filename;
				unset($file['tmp_name'],$file['size'],$file['type']);
				$uploadedFiles[$i]=$file;
				$i++;
			}
		}else{
			switch($file['error']){
					case 1:
						$mes="超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
						break;
					case 2:
						$mes="超过了表单设置上传文件的大小";			//UPLOAD_ERR_FORM_SIZE
						break;
					case 3:
						$mes="文件部分被上传";//UPLOAD_ERR_PARTIAL
						break;
					case 4:
						$mes="没有文件被上传1111";//UPLOAD_ERR_NO_FILE
						break;
					case 6:
						$mes="没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
						break;
					case 7:
						$mes="文件不可写";//UPLOAD_ERR_CANT_WRITE;
						break;
					case 8:
						$mes="由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
						break;
				}
				echo $mes;
			}
	}
	return $uploadedFiles;
}

//服务器端进行的配置 php.inc
//1)file_uploads = On,支持通过HTTP POST方式上传文件
//2)upload_tmp_dir =临时文件保存目录
//3)upload_max_filesize = 2M默认值是2M，上传的最大大小2M
//4)post_max_size = 8M，表单以POST方式发送数据的最大值，默认8M
//客户端进行配置
//<input type="hidden" name="MAX_FILE_SIZE" value="1024"  />
//<input type="file" name="myFile" accept="文件的MIME类型,..."/>
?>