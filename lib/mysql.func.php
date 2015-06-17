<?php
// require_once '../configs/configs.php';
// require_once '../include.php';
function connect(){
	$link = mysql_connect("localhost","root","") or die("error".mysql_errno());
	mysql_set_charset(DB_CHARSET);
	mysql_select_db(DB_DBNAME) or die("指定数据库打开失败");
	return $link;
}

function insert($table,$array){
	$keys=join(",",array_keys($array));
	$vals="'".join("','",array_values($array))."'";
	$sql="insert {$table}($keys) values({$vals})";
	mysql_query($sql);
	return mysql_insert_id();
}
function update($table,$arr,$where=null){
	$str="";
	foreach ($arr as $key => $value) {
	 	if($str==null)
	 		$sep="";
	 	else
	 		$sep=",";

	 	$str.= $sep.$key." = '".$value."'";

	}

	$sql="update {$table} set {$str} ".($where==null?null:" where ".$where);
		$result=mysql_query($sql);
		// var_dump($result);
		// var_dump(mysql_affected_rows());exit;
		
		if($result){
			return mysql_affected_rows();
		}else{
			return false;
		}
}

function fetchOne($sql,$result_type=MYSQL_ASSOC){
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result,$result_type);
	return $row;
}

function fetchAll($sql,$result_type=MYSQL_ASSOC){
	$result=mysql_query($sql);
	$rows="";
	if($result){
		while($row=mysql_fetch_array($result,$result_type)){
			$rows[]=$row;
		}
	}
	return $rows;
}

function delete($table,$where=null){
	$where=$where==null?null:" where ".$where;
	$sql="delete from {$table} {$where}";
	mysql_query($sql);
	return mysql_affected_rows();
}

function getResultNum($sql){
	$result = mysql_query($sql);
	return mysql_num_rows($result);
}
