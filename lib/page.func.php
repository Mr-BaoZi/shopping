<?php
// require_once "../lib/mysql.func.php";
// require_once '../include.php';
// connect();
// $pageSize = 5;

// $sql = "select * from admin ";

// $totalRows = getResultNum($sql);
// // echo $totalRows;


// $totalPages = ceil($totalRows/$pageSize);


// $page=$_REQUEST?(int)$_REQUEST['page']:1;
// if($page<1||$page==null|!is_numeric($page)){
//     $page = 1;
// }
// if($page>$totalPages){
//     $page = $totalPages;
// }

// $offset = ($page-1)*$pageSize;

// $sql = "select * from admin limit {$offset},{$pageSize}";
// $rows = fetchAll($sql);
// print_r($rows);
// foreach ($rows as $row) {
// 	echo "编号：".$row['id']."<br/>";
// 	echo "名称：".$row['username']."<hr/>";
// }
// echo $page;
function showPage($page,$totalPages,$keywords=null,$order=null,$where=null,$sep="&nbsp;"){
	$where=($where==null)?null:"$".$where;
	$url = $_SERVER['PHP_SELF'];
	$index=($page==1)?"首页":"<a href='{$url}?page=1{$where}'>首页</a>";
	$last=($page==$totalPages)?"尾页":"<a href='{$url}?page={$totalPages}{$where}'>尾页</a>";
	$prev=($page==1)?"上一页":"<a href='{$url}?page=".($page-1)."{$where}'>上一页</a>";
	$next=($page==$totalPages)?"下一页":"<a href='{$url}?page=".($page+1)."{$where}'>下一页</a>";
	$p="";
	for($i=1;$i<=$totalPages;$i++){
		//当前页不链接
		if($page == $i){
			$p.= "[{$i}]";
		}else{
			$p.= "<a href='{$url}?page={$i}'>[{$i}]</a>";
		}
		
	}
	$pageStr = $index.$sep.$prev.$sep.$p.$sep.$next.$sep.$last;
	return $pageStr;
}

