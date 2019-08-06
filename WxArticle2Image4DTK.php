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

// $serverName = "139.199.219.164";
// $userName = "root";
// $userPassword = "82702083a";
// $dbName = "wp";

$serverName = "127.0.0.1";
$userName = "root";
$userPassword = "82702083a";
$dbName = "haodanku";

$hdkKey;
$tbKey;
$tbSecret;
$pid;


function coverDescribe($itemtitle,$itemshorttitle,$itemdesc,$itemprice,$itemendprice,$itempic_copy,$taowords){
	$describe = "<hr/><img src=\"".$itempic_copy."\"/>"."<br/>"
	."<hr/>"
	."<span style=\"font-size: 15px;\">".$itemshorttitle."</span><br/>"
	."<span style=\"font-size: 15px;\">原价【".$itemprice."元】</span> "
	."<span style=\"color: rgb(255, 41, 65);font-size: 15px;\">券后价【".$itemendprice."元】</span><br/>"
	// ."<span style=\"font-size: 12px;\">".$itemtitle."</span><br/>"
	."<span style=\"font-size: 13px;\">【推荐理由】".$itemdesc."</span><br/><br/>"
	."<span style=\"background-color: rgb(255, 215, 213); color: rgb(255, 41, 65); font-size: 15px;\">长按复制红色这段口令文字"
	.$taowords."打开【手机淘宝】领券</span><br/>"
	."<br/><br/><hr/>";
	return $describe;
}

function coverDescribe02($itemshorttitle,$pircedesc,$itemdesc,$qrcodeImageAddress){
	$describe = "<section align=\"center\" >
			<section style=\"padding: 1px;display: inline-block;width: 90%;vertical-align: top;border-width: 0.5px;border-style: solid;border-color: rgb(177, 177, 177);background-color: rgb(255, 255, 255);box-shadow: rgb(177, 177, 177) 0px 0px 6px;\" align=\"center\">

				<img style=\"width: 90%;\" src=\"".$qrcodeImageAddress."\"/>
				
				<p style=\"width: 90%;color: rgb(89,89,89);font-size: 14px;margin-left: 13px;padding-bottom: 5px;\" align=\"left\">".$itemshorttitle."</p>
				<p style=\"width: 90%;color: rgb(255,57,154);font-size: 14px;font-weight: bold;margin-left: 13px;padding-bottom: 5px;\" align=\"left\">".$pircedesc."</p>
				<hr style=\"color: rgb(89,89,89);margin-right: 13px;margin-left: 13px;\"/>
				<p style=\"width: 90%;color: rgb(89,89,89);font-size: 14px;margin-left: 13px;padding-top: 5px;\" align=\"left\">".$itemdesc."</p><br/>
			</section>
		</section><br/><br/><br/>";



	return $describe;
}

// $uservalue = $_GET['value'];
// $cid = $_GET['cid'];
// $syncWeb = $_GET['syncweb'];

$uservalue = "gui_ling";
$cid = "1";
$syncWeb = "0";

$db = new MySqliteUtil('./haodanku.db');

if(!$db){
	echo "数据库打开失败\n".$db->lastErrorMsg();
	exit();
} else {
	$sql = "select * from user where userid='".$uservalue."'";
	$queryResults = $db->query($sql);
	
	// echo "sql:".$sql;
	while($rows = $queryResults->fetchArray(SQLITE3_ASSOC)) {
			# code...
		$hdkKey = $rows['hdkkey'];
		$tbKey = $rows['tbkey'];
		$tbSecret = $rows['tbsecret'];
		$pid = $rows['pid'];
		
	}

	$itemSql = "select itemid from rx_product";
	$itemResult = $db->query($itemSql);
	$itemArray = array();
	while ($rows = $itemResult -> fetchArray(SQLITE3_ASSOC)) {
		$itemArray[] = $rows['itemid'];
	}
	
}
$db->close();




$article;;
$itemCount = count($itemArray);
for ($i=0; $i < $itemCount; $i++) { 
	$itemid = $itemArray[$i];
	$result = ApiUtils::getItemDetail4DTK($itemid);
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

		// $hightCommissionResult = ApiUtils::getHighCommission2($itemid,$hdkKey,$pid);

		$taowords;
		$hightCommissionResult = ApiUtils::getHighCommission3($itemid,$hdkKey,$pid,$activityId);
		$hightCommissionResult = json_decode($hightCommissionResult,true);
		if ($hightCommissionResult['code']==1) {
			$click_url = $hightCommissionResult['data']['coupon_click_url'];
			$taowords = ApiUtils::creatTaoWords($tbKey,$tbSecret,$click_url,$itemtitle,"");
			
			if (RStringUtil::isKouLing($taowords)) {

				$taowords = str_replace("￥", "", $taowords);
				$productUrl = "http://wx.tshtts.cn/common/index.html?number=".$taowords."aa";
				$picUrl = $itempic_copy;
				$qrcodeImageAddress= ApiUtils::creatImage($picUrl,$productUrl,$itemid);
				if (!strstr($qrcodeImageAddress,"error")) {
					//获取地址成功!
					$pircedesc = "原价【".$itemprice."】元,券后价【".$itemendprice."】元";
					
					$describe = coverDescribe02($itemshorttitle,$pircedesc,$itemdesc,$qrcodeImageAddress);
					$article = $article.$describe;
					echo "第".$i."个\n";
					usleep(200);
					
				}

		
				
			}



		}else{
			echo "转换高佣金失败".$hightCommissionResult['msg'];
			
		}

	}else{
		echo "获取单品信息失败,退出程序".$result['msg'];
		exit();
	}


}

// $zaikan = "http://sschj99.com/zb_users/theme/txtao/pic/zaikan.gif";
// $article = $article."<br/>";
echo $article."\n";
// echo "-----------------------------";
// RLogUtil::console_log('以下是生成的文章');
// RLogUtil::console_log($article);







?>