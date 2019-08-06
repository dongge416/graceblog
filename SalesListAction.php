<?php


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers:x-requested-with,content-type');   
header("content-type:text/html;charset=utf-8");
include "ApiUtils.php";
include "RStringUtil.php";
include "RLogUtil.php";
date_default_timezone_set('Asia/Shanghai');


require("wp_mysql_class.php");
require("MySqliteUtil.php");

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
	."<span style=\"font-size: 12px;\">".$itemtitle."</span><br/>"
	."<span style=\"font-size: 13px;\">【推荐理由】".$itemdesc."</span><br/><br/>"
	."<span style=\"background-color: rgb(255, 215, 213); color: rgb(255, 41, 65); font-size: 15px;\">长按复制红色这段口令文字"
	.$taowords."打开【手机淘宝】领券</span><br/>"
	."<br/><br/><hr/>";
	return $describe;
}

// $uservalue = $_GET['value'];
// $cid = $_GET['cid'];
// $syncWeb = $_GET['syncweb'];

$uservalue = "gui_ling";
$cid = "2";
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

}
$db->close();





$result = ApiUtils::getSalesList($hdkKey,$cid);
var_dump($result);
echo "----------------";
$result_code = $result['code'];




if ($result_code!=1) {
	echo "获取好单库榜单数据失败\n";
	exit('获取数据失败'.$result['msg']);
}else{
	$result_data = $result['data'];
	$data_count = count($result_data);


	$describe ;
//打开数据库
	$serverName = "127.0.0.1";
	$userName = "root";
	$userPassword = "root";
	$dbName = "myzblog";
	$mysqlDb = new wp_mysql_class($serverName,$userName,$userPassword,$dbName);
	$mysqlDb->dbConnect();

	for ($i=0; $i < 3; $i++) { 
		RLogUtil::console_log("log:".$i);
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
		$result = ApiUtils::getHighCommission2($itemid,$hdkKey,$pid);
		$result = json_decode($result,true);
		if ($result['code']==1) {
			$click_url = $result['data']['coupon_click_url'];
			$taowords = ApiUtils::creatTaoWords($tbKey,$tbSecret,$click_url,$itemtitle,"");
			
			if (RStringUtil::isKouLing($taowords)) {
				
				$taowords = RStringUtil::custionKouLing($taowords,"");
				# code...

				//文章描述
				$log_meta_array['nrms'] = $itemdesc;
				//够买方式
				$log_meta_array['gm2mc'] = '领券购买';
				//够买价格
				$log_meta_array['gm2jg'] = $itemendprice;
				//优惠券价格
				$log_meta_array['sq'] = $couponmoney;
				//是否为淘宝客文章0
				$log_meta_array['tbkkg'] = '0';
				//截图
				$log_meta_array['jietu'] = $itempic;
				//链接
				$log_meta_array['gm2lj'] = $click_url;
				//关键词
				$log_meta_array['nrgjc'] = $itemtitle;
				//加红字体
				$log_meta_array['fbt'] = '';
				//短标题
				$log_meta_array['itemshorttitle'] = $itemshorttitle;
				//标题
				$log_meta_array['itemtitle'] = $itemtitle;
				//描述
				$log_meta_array['itemdesc'] = $itemdesc;
				//原价
				$log_meta_array['itemprice'] = $itemprice;
				//券后价
				$log_meta_array['itemendprice'] = $itemendprice;
				//长图片
				$log_meta_array['itempic_copy'] = $itempic_copy;
				//淘口令
				$log_meta_array['taowords'] = $taowords;

				$log_meta = serialize($log_meta_array);

				$describe = coverDescribe($itemtitle,$itemshorttitle,$itemdesc,$itemprice,$itemendprice,$itempic_copy,$taowords);

				//数据库表字段
				$log_CateID = '2';
				//作者
				$log_AuthorID = '2';
				//标签
				$log_Tag = '{1}';
				//状态
				$log_Status = '0';
				//类型
				$log_Type = '0';
				
				// $log_Alias = '';
				//是否置顶
				$log_IsTop = '0';
				//是否锁定
				$log_IsLock = '0';

				$log_Title = $itemshorttitle;

				$log_Intro = $itemdesc;

				$log_Content = $describe;

				$log_ViewNums = '0';

				// $log_Template = '';

				$log_Meta = $log_meta;

				$log_PostTime = time();


				
				$selectSql = "select count(*) as total from zbp_post where log_itemid = '".$itemid."'";
				$selectResult = $mysqlDb->query($selectSql);
				$total=mysqli_fetch_array($selectResult,MYSQLI_ASSOC)['total'];
				if ($total > 0) {
					//更新
					$updateSql = "update zbp_post set log_Title = '".$log_Title."', log_Intro = '".$log_Intro."', log_Content = '".$log_Content."', log_Meta = '".$log_Meta."', log_PostTime = '".$log_PostTime."' where log_itemid = '".$itemid."'";
					$updateResult = $mysqlDb->query($updateSql);
					if ($updateResult) {
						echo "第".$i."个更新成功\n";
					}else{
						echo "第".$i."个更新失败\n";
					}


				}else{
					//插入
					$insertSql = "insert into zbp_post (log_CateID,log_AuthorID,log_Tag,log_Status,log_Type,log_IsTop,log_IsLock,log_Title,log_Intro,log_Content,log_ViewNums,log_Meta,log_itemid,log_PostTime) values ('".$log_CateID."','".$log_AuthorID."','".$log_Tag."','".$log_Status."','".$log_Type."','".$log_IsTop."','".$log_IsLock."','".$log_Title."','".$log_Intro."','".$log_Content."','".$log_ViewNums."','".$log_Meta."','".$itemid."','".$log_PostTime."')";
					$insertFlag = $mysqlDb->insert($insertSql);
					
					if ($insertFlag) {

						echo "第".$i."个插入成功\n";
					}else{
						echo "第".$i."个插入失败\n";
					}
				}
				

				


				

			}
			//echo ("第".$i."个".$itemtitle.",".$itemdesc.",".$taowords."\n");
			usleep(1000);
		}else{
			echo('转换高佣金失败:'.$result['msg']);
			// exit();
		}
		


	}
	//关闭数据库
	$mysqlDb->dbClose();
	// echo $describe;

	
}






?>