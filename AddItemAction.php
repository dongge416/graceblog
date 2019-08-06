<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers:x-requested-with,content-type');   
header("content-type:text/html;charset=utf-8");
date_default_timezone_set('Asia/Shanghai');

include "ApiUtils.php";
include "RStringUtil.php";
require("MySqliteUtil.php");



$itemType = $_GET['itemType'];
$itemId = $_GET['itemId'];
$tableName = $itemType."_product";
$activityId = $_GET['activityId'];
$itemTitle = $_GET['itemTitle'];
$itemPriceDesc = $_GET['itemPriceDesc'];
$itemDesc = $_GET['itemDesc'];




$filePath = dirname(__FILE__);

$db = new MySqliteUtil($filePath.'\haodanku.db');

if(!$db){
	echo "数据库打开失败\n".$db->lastErrorMsg();
	exit();
} else {

	$sql = "SELECT count(*) as itemcount from ".$tableName." where itemid = '".$itemId."'";
	$queryResults = $db->query($sql);
	$rows = $queryResults->fetchArray();
	$itemcount = $rows['itemcount'];
	if ($itemcount==1) {
		# 更新
		$sql = "update ".$tableName." SET activityid = '".$activityId."' where itemid = '".$itemId."'";
		$queryResults = $db->exec($sql);
		if ($queryResults) {
			echo "更新成功";
		}else{
			echo "更新失败";
		}

	}else{
		#插入
		$sql = "insert into ".$tableName." (itemid,itemshorttitle,itemdesc,activityid,itempricedesc) values ('".$itemId."','".$itemTitle."','".$itemDesc."','".$activityId."','".$itemPriceDesc."') ";

		$queryResults = $db->exec($sql);

		if ($queryResults) {
			echo "插入成功";
		}else{
			echo "插入失败";
		}
	}



}
$db->close();


?>