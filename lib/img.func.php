<?php
require_once 'string.func.php';

function verifyImg($type=2,$length=4){
	$width = 80;
	$height = 20;
	$image = imagecreatetruecolor($width, $height);
	$white = imagecolorallocate($image, 255, 255, 255);
	$black = imagecolorallocate($image, 0, 0, 0);

	imagefilledrectangle($image, 1, 1, $width-2, $height-2, $white);

	$chars = buildRandomString($type,$length);
	session_start();
	$session_name = "verify";
	$_SESSION[$session_name] = $chars;
	$fontfiles = array("simfang.ttf","simhei.ttf","BuxtonSketch.ttf","verdanai.ttf");
	for($i=0;$i<$length;$i++){
		$size = mt_rand(14,18);
		$angle = mt_rand(-15,15);
		$x = 5 + $i*$size;
		$y = 18;
		$color = imagecolorallocate($image, mt_rand(50,90), mt_rand(15,150), mt_rand(50,80));
		$fontfile = "../fonts/".$fontfiles[mt_rand(0,count($fontfiles)-1)];
		$text = substr($chars, $i,1);
		imagefttext($image, $size, $angle, $x, $y, $color, $fontfile, $text);

	}

	//绘制干扰线
	for($i=0;$i<3;$i++){
		$color_line = imagecolorallocate($image, rand(50,200), rand(50,200), rand(50,200));
		imageline($image,rand(0,$width-1),rand(0,$height-1),rand(0,$width-1),rand(0,$height-1),$color_line);
	}

	//绘制干扰点
	for($i=0;$i<55;$i++){
		$color_dot = imagecolorallocate($image, rand(15,150), rand(15,150), rand(15,150));
		imagesetpixel($image, rand(0,$width-1), rand(0,$height-1), $color_dot);
	}

	imagepng($image);
	imagedestroy($image);
}

/**
 * 生成缩略图
 * @param string $filename
 * @param string $destination
 * @param int $dst_w
 * @param int $dst_h
 * @param bool $isReservedSource
 * @param float $scale
 * @return string
 */
function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource=true,$scale=0.5){
	list($src_w,$src_h,$imagetype)=getimagesize($filename);
	if(is_null($dst_w)||is_null($dst_h)){
		$dst_w=ceil($src_w*$scale);
		$dst_h=ceil($src_h*$scale);
	}
	//$mime打印出来是image/jpeg、image/png等图片格式的字符串
	$mime=image_type_to_mime_type($imagetype);
	//利用mime的字符串得到函数imagecreatefromjpeg()
	$createFun=str_replace("/", "createfrom", $mime);
	//imagejpeg()
	$outFun=str_replace("/", null, $mime);
	$src_image=$createFun($filename);
	$dst_image=imagecreatetruecolor($dst_w, $dst_h);
	//重采样
	imagecopyresampled($dst_image, $src_image, 0,0,0,0, $dst_w, $dst_h, $src_w, $src_h);
	if($destination&&!file_exists(dirname($destination))){
		mkdir(dirname($destination),0777,true);
	}
	$dstFilename=$destination==null?getUniName().".".getExt($filename):$destination;
	$outFun($dst_image,$dstFilename);
	imagedestroy($src_image);
	imagedestroy($dst_image);
	//是否保存上传的原图
	if(!$isReservedSource){
		unlink($filename);
	}
	return $dstFilename;
}