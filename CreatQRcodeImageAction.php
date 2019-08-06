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


$result = ApiUtils::getItemDetail4DTK($itemId);
$a = $result['data']['total_num'];
if ($a>=1) {
	$resultData = $result['result'];
	$itemtitle = $resultData['Title'];
	$itemshorttitle = $resultData['D_title'];
	$itemdesc = $resultData['Introduce'];
	$itemprice = $resultData['Org_Price'];
	$itemendprice = $resultData['Price'];
	$itempic_copy = $resultData['Pic'];
	$activityId = $resultData['Quan_id'];
	$taowords;
	$hightCommissionResult = ApiUtils::getHighCommission3($itemId,$hdkKey,$pid,$activityId);
	$hightCommissionResult = json_decode($hightCommissionResult,true);
	if ($hightCommissionResult['code']==1) {
		$click_url = $hightCommissionResult['data']['coupon_click_url'];
		$taowords = ApiUtils::creatTaoWords($tbKey,$tbSecret,$click_url,$itemtitle,"");

		if (RStringUtil::isKouLing($taowords)) {
			$taowords = str_replace("￥", "", $taowords);
			$productUrl = "http://wx.tshtts.cn/common/index.html?number=".$taowords."aa";
			$picUrl = $itempic_copy;
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



	}else{
		echo "转换高佣金失败".$hightCommissionResult['msg'];
		exit();

	}

}else{
	echo "获取单品信息失败,退出程序".$result['msg'];
	exit();
}






?>