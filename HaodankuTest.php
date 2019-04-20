<?php


header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Methods:*'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');   
header("content-type:text/html;charset=utf-8");
//header("Access-Control-Allow-Origin: http://127.0.0.1:8020");
//include "TopSdk.php";
include "ApiUtils.php";
include "RStringUtil.php";
date_default_timezone_set('Asia/Shanghai');


require("mysql_class.php");
require("SqliteUtil.php");

// $serverName = "139.199.219.164";
// $userName = "root";
// $userPassword = "82702083a";
// $dbName = "wp";

$serverName = "127.0.0.1";
$userName = "root";
$userPassword = "82702083a";
$dbName = "haodanku";



$result = ApiUtils::getSalesList(0);
$result_code = $result['code'];


function coverDescribe($itemtitle,$itemshorttitle,$itemdesc,$itemprice,$itemendprice,$itempic_copy,$taowords){
	$describe = "<img src=\""."http://img.haodanku.com/".$itempic_copy."\"/>"."\n"
	.$itemshorttitle."\n"
	.$itemtitle."\n"
	."原价【".$itemprice."元】 券后价【".$itemendprice."元】\n"
	."【推荐理由】".$itemdesc."\n"
	."长按复制这段文字".$taowords."打开淘宝领券\n"
	."&nbsp;&nbsp;";
	return $describe;


}

if ($result_code!=1) {
	exit('获取数据失败'.$result['msg']);
}else{
	$result_data = $result['data'];
	$data_count = count($result_data);

	$db = new SqliteUtil('/Applications/XAMPP/xamppfiles/htdocs/phpworkspace/tbksdk/haodanku.db');
	$describe ;
	for ($i=0; $i < 10; $i++) { 
		$temp_product = $result_data[$i];
		
		$product_id = $temp_product['product_id'];
		$itemid = $temp_product['itemid'];
		$seller_id = $temp_product['seller_id'];
		$itemtitle = $temp_product['itemtitle'];
		$itemshorttitle = $temp_product['itemshorttitle'];

		$itemdesc = $temp_product['itemdesc'];
		$itemprice = $temp_product['itemprice'];
		$itemsale = $temp_product['itemsale'];
		$itemsale2 = $temp_product['itemsale2'];
		$todaysale = 0;
		if (!empty($temp_product['todaysale'])) {
			$todaysale = $temp_product['todaysale'];
		}

		$yesterdaysale = 0;
		if (!empty($temp_product['yesterdaysale'])) {
			$yesterdaysale = $temp_product['yesterdaysale'];
		}
		$itempic = $temp_product['itempic'];
		$itempic_copy = $temp_product['itempic_copy'];
		$fqcat = $temp_product['fqcat'];
		$itemendprice = $temp_product['itemendprice'];
		$shoptype = $temp_product['shoptype'];
		$tktype = $temp_product['tktype'];
		$tkrates = $temp_product['tkrates'];
		$tkmoney = $temp_product['tkmoney'];
		$couponurl = $temp_product['couponurl'];
		$couponmoney = $temp_product['couponmoney'];
		$couponsurplus = $temp_product['couponsurplus'];
		$couponreceive = $temp_product['couponreceive'];
		$couponreceive2 = $temp_product['couponreceive2'];
		$todaycouponreceive = $temp_product['todaycouponreceive'];
		$couponnum = $temp_product['couponnum'];
		$couponexplain = $temp_product['couponexplain'];
		$couponstarttime = $temp_product['couponstarttime'];
		$couponendtime = $temp_product['couponendtime'];
		$start_time = $temp_product['start_time'];
		$end_time = $temp_product['end_time'];
		$starttime = $temp_product['starttime'];
		$is_brand = $temp_product['is_brand'];
		$guide_article = $temp_product['guide_article'];
		$videoid = $temp_product['videoid'];
		$activity_type = $temp_product['activity_type'];
		$general_index = $temp_product['general_index'];
		$planlink = $temp_product['planlink'];
		$seller_name = $temp_product['seller_name'];
		$sellernick = $temp_product['sellernick'];
		$discount = $temp_product['discount'];
		$order_count = 0;
		if (!empty($temp_product['order_count'])) {
			$order_count = $temp_product['order_count'];
		}

	
		$taowords;
		$result = ApiUtils::getHighCommission($itemid);
		if ($result['code']==1) {
			$click_url = $result['data']['coupon_click_url'];
			$taowords = ApiUtils::creatTaoWords($click_url,$itemtitle,"");
			echo ("第".$i."个".$itemtitle.",".$itemdesc.",".$taowords."\n");
			sleep(2);
		}else{
			echo('转换高佣金失败:'.$result['msg']);
		}
		$describe = $describe.coverDescribe($itemtitle,$itemshorttitle,$itemdesc,$itemprice,$itemendprice,$itempic_copy,$taowords);
		
		//以下为插入数据库操作
		// $insertSql = "insert into product (itemid,seller_id,itemtitle,itemshorttitle,itemdesc,itemprice,itemsale,itemsale2,todaysale,yesterdaysale,itempic,itempic_copy,fqcat,itemendprice,shoptype,tktype,tkrates,tkmoney,couponurl,couponmoney,couponsurplus,couponreceive,couponreceive2,todaycouponreceive,couponnum,couponexplain,couponstarttime,couponendtime,start_time,end_time,starttime,is_brand,guide_article,videoid,activity_type,general_index,planlink,seller_name,sellernick,discount,order_count) values (".$itemid.",".$seller_id.",'".$itemtitle."','".$itemshorttitle."','".$itemdesc."',".$itemprice.",".$itemsale.",".$itemsale2.",".$todaysale.",".$yesterdaysale.",'".$itempic."','".$itempic_copy."',".$fqcat.",".$itemendprice.",'".$shoptype."','".$tktype."',".$tkrates.",".$tkmoney.",'".$couponurl."',".$couponmoney.",".$couponsurplus.",".$couponreceive.",".$couponreceive2.",".$todaycouponreceive.",".$couponnum.",'".$couponexplain."',".$couponstarttime.",".$couponendtime.",".$start_time.",".$end_time.",".$starttime.",".$is_brand.",'".$guide_article."',".$videoid.",'".$activity_type."',".$general_index.",'".$planlink."','".$seller_name."','".$sellernick."',".$discount.",".$order_count.")";


		// var_dump($insertSql);
		// if(!$db){
		// 	echo $db->lastErrorMsg();
		// } else {
		// 	echo "Opened database successfully";
		// }
		// $results = $db->exec($insertSql);
		// if (!$results) {
		// 	echo "插入失败".$db->lastErrorMsg();
		// }else{
		// 	echo "插入成功";
		// }

	}

	echo $describe;

	
}






?>