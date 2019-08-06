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
	$describe = "<hr/><img src=\""."http://img.haodanku.com/".$itempic_copy."\"/>"."<br/>"
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

$uservalue = $_GET['uservalue'];
// $cid = $_GET['cid'];
// $syncWeb = $_GET['syncweb'];

// $uservalue = "gui_ling";
$cid = "1";
$syncWeb = "0";

$db = new MySqliteUtil('D:\phpStudy\PHPTutorial\WWW\php\graceblog\haodanku.db');

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
	$result = ApiUtils::getItemDetail($hdkKey,$itemid);
	$code = $result['code'];
	if ($code==1) {
		$resultData = $result['data'];
		$itemtitle = $resultData['itemtitle'];
		$itemshorttitle = $resultData['itemshorttitle'];
		$itemdesc = $resultData['itemdesc'];
		$itemprice = $resultData['itemprice'];
		$itemendprice = $resultData['itemendprice'];
		$itempic_copy = $resultData['itempic_copy'];
		$activityId = $resultData['activityid'];
		// $hightCommissionResult = ApiUtils::getHighCommission2($itemid,$hdkKey,$pid);

		$taowords;
		$hightCommissionResult = ApiUtils::getHighCommission3($itemid,$hdkKey,$pid,$activityId);
		$hightCommissionResult = json_decode($hightCommissionResult,true);
		if ($hightCommissionResult['code']==1) {
			$click_url = $hightCommissionResult['data']['coupon_click_url'];
			$taowords = ApiUtils::creatTaoWords($tbKey,$tbSecret,$click_url,$itemtitle,"");
			
			if (RStringUtil::isKouLing($taowords)) {
				$taowords = RStringUtil::custionKouLing($taowords,"");
				$describe = coverDescribe($itemtitle,$itemshorttitle,$itemdesc,$itemprice,$itemendprice,$itempic_copy,$taowords);
				// var_dump($describe);
				$article = $article.$describe;
				
				echo "第".$i."个成功\n";
				usleep(500);
			}



		}else{
			echo "转换高佣金失败".$hightCommissionResult['msg'];
			
		}

	}else{
		echo "获取单品信息失败,退出程序".$result['msg'];
		exit();
	}


}

echo $article."\n";
RLogUtil::console_log('以下是生成的文章');
RLogUtil::console_log($article);


exit();









?>