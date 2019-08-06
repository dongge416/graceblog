<?php


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers:x-requested-with,content-type');   
header("content-type:text/html;charset=utf-8");
include "ApiUtils.php";
include "RStringUtil.php";
date_default_timezone_set('Asia/Shanghai');


require("wp_mysql_class.php");
require("MySqliteUtil.php");
require("RLogUtil.php");
include("CreatImageUtil.php");


$hdkKey;
$tbKey;
$tbSecret;
$pid;

$itemId = $_GET['itemid'];
$uservalue = $_GET['uservalue'];
$imageType = $_GET['imagetype'];

// $itemId = "533038449570";
// $uservalue = "gui_ling";



$db = new MySqliteUtil('./haodanku.db');

if(!$db){
	echo "数据库打开失败\n".$db->lastErrorMsg();
	exit();
} else {
	$sql = "select * from user where userid='".$uservalue."'";
	$queryResults = $db->query($sql);
	while($rows = $queryResults->fetchArray(SQLITE3_ASSOC)) {
			# code...
		$hdkKey = $rows['hdkkey'];
		$tbKey = $rows['tbkey'];
		$tbSecret = $rows['tbsecret'];
		$pid = $rows['pid'];
		
	}

	
	
}
$db->close();


$result = ApiUtils::getItemInfo($itemId);
$picUrl = $result->pict_url;
$itemtitle = $result->title;
$itemendprice = $result->zk_final_price;
// $kouLing = str_replace("￥", "", $kouLing);
// $productUrl = "http://wx.tshtts.cn/common/index.html?number=".$kouLing."aa";
// $qrcodeImageAddress= ApiUtils::creatImage($picUrl,$productUrl,$itemId);
// echo $qrcodeImageAddress;


$taowords;
$hightCommissionResult = ApiUtils::getHighCommission3($itemId,$hdkKey,$pid,$activityId);
$hightCommissionResult = json_decode($hightCommissionResult,true);
if ($hightCommissionResult['code']==1) {

	$click_url = $hightCommissionResult['data']['coupon_click_url'];
	$item_url = $hightCommissionResult['data']['item_url'];
	if (empty($item_url)) {
		$taowords = ApiUtils::creatTaoWords($tbKey,$tbSecret,$click_url,$itemtitle,$picUrl);
	}else{
		$taowords = ApiUtils::creatTaoWords($tbKey,$tbSecret,$item_url,$itemtitle,$picUrl);
	}


	if (RStringUtil::isKouLing($taowords)) {
		$taowords = str_replace("￥", "", $taowords);
		$productUrl = "http://wx.tshtts.cn/common/index.html?number=".$taowords."aa";

		if ($imageType==1) {
				# 竖图
			$qrcodeImageAddress= ApiUtils::creatImage($picUrl,$productUrl,$itemId);
			echo $qrcodeImageAddress;

		}else{
				#横图
			$itemtitle = substr($itemtitle, 0,27);
			$qrcodeImageAddress= ApiUtils::creatImage02($picUrl,$productUrl,$itemId,$itemtitle,$itemprice,$itemendprice);
			echo $qrcodeImageAddress;
		}

	}
}


?>