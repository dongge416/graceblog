<?php


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers:x-requested-with,content-type');   
header("content-type:text/html;charset=utf-8");
include "ApiUtils.php";
include "RStringUtil.php";
date_default_timezone_set('Asia/Shanghai');


// require("mysql_class.php");
require("wp_mysql_class.php");
require("MySqliteUtil.php");



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
	."<span style=\"font-size: 13px;\">【推荐理由】".$itemdesc."</span><br/>"
	."<span style=\"background-color: rgb(255, 215, 213); color: rgb(255, 41, 65); font-size: 15px;\">长按复制这红色文字"
	.$taowords."打开某.宝领券</span><br/>"
	."<br/><br/><hr/>";
	return $describe;
}

$uservalue = $_GET['value'];
$brandcat = $_GET['brandcat'];
$syncWeb = $_GET['syncweb'];

$db = new MySqliteUtil('/Applications/XAMPP/xamppfiles/htdocs/phpworkspace/tbksdk/haodanku.db');
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





$result = ApiUtils::getBrand($hdkKey,"");

$result_code = $result['code'];




if ($result_code!=1) {
	echo "获取好单库品牌数据失败\n";
	exit('获取数据失败'.$result['msg']);
}else{
	$resultData = $result['data'];


	$dataCount = count($resultData);
	$describe ;

	for ($i=0; $i < $dataCount; $i++) { 

		$items = $resultData[$i]['item'];
		$itemCount = count($items);

		for ($j=0; $j < $itemCount; $j++) { 


			// $itemId = $items[$j]['itemid'];
			$itemTitle = $items[$j]['itemtitle'];
			$itemShortTitle = $items[$j]['itemshorttitle'];
			$itemDesc = $items[$j]['itemdesc'];
			$itemId = $items[$j]['itemid'];
			$itemPrice = $items[$j]['itemprice'];
			$itemEndPrice = $items[$j]['itemendprice'];
			$itempicCopy = $items[$j]['itempic_copy'];
			


			$taowords;

			$result = ApiUtils::getHighCommission2($itemId,$hdkKey,$pid);

			$result = json_decode($result,true);
			$code = $result['code'];
			if ($code==1) {
				$click_url = $result['data']['coupon_click_url'];
				
				$taowords = ApiUtils::creatTaoWords($tbKey,$tbSecret,$click_url,$itemTitle,"");
				
				if (RStringUtil::isKouLing($taowords)) {
					$taowords = RStringUtil::custionKouLing($taowords,"");
					$describe = $describe.coverDescribe($itemTitle,$itemShortTitle,$itemDesc,$itemPrice,$itemEndPrice,$itempicCopy,$taowords);
				}
				usleep(500);
			}else{
				echo "转换高佣金失败";
				exit();
			}
			


			
		}
	}


	if ($syncWeb==1) {
		$post_author = "1";
		$post_date = date("Y-m-d H:i:s");
		$post_date_gmt = gmdate("Y-m-d H:i:s");
		$post_content = $describe;
		$post_title = "今日淘宝大牌精选";
		$post_excerpt ="";
		$post_status = "publish";
		$comment_status = "open";
		$ping_status = "open";
		$post_password = "";
		$post_name = urlencode($post_title);
		$to_ping;
		$pinged;
		$post_modified = $post_date;
		$post_modified_gmt = $post_date_gmt;
		$post_content_filtered;
		$post_parent;
		$guid;
		$menu_order;
		$post_type = "post";
		$post_mime_type;
		$comment_count;

		// $mysqlDb = new wp_mysql_class($serverName,$userName,$userPassword,$dbName);
		// $mysqlDb->dbConnect();
		// $insertSql = "insert into wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_status,comment_status,ping_status,post_name,post_modified,post_modified_gmt,post_type) values ('".$post_author."','".$post_date."','".$post_date_gmt."','".$post_content."','".$post_title."','".$post_status."','".$comment_status."','".$ping_status."','".$post_name."','".$post_modified."','".$post_modified_gmt."','
		// ".$post_type."')";
		// echo $insertSql."\n";
		// $mysqlDb->insert($insertSql);
		// $mysqlDb->dbClose();
		// echo "插入成功";

		$serverName = "139.199.219.164";
		$userName = "root";
		$userPassword = "82702083a";
		$dbName = "wp";
		$mysqlDb = new wp_mysql_class($serverName,$userName,$userPassword,$dbName);
		$mysqlDb->dbConnect();
		// $mysqlDb->insert("insert into wp_posts (post_date,post_title,post_content) values ('2019-04-01 15:58:22','aaaOOOOOOO','222')");
// $mysqlDb->insert("insert into wp_posts (post_date,post_title,post_content) values ('2019-04-01 15:58:21' , '2222' , '测试内容')");

		// $insertSql = "insert into wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_status,comment_status,ping_status,post_name,post_modified,post_modified_gmt,post_type) values ('".$post_author."','".$post_date."','".$post_date_gmt."','".$post_content."','".$post_title."','".$post_status."','".$comment_status."','".$ping_status."','".$post_name."','".$post_modified."','".$post_modified_gmt."','
		// ".$post_type."')";

		$insertSql = "insert into wp_posts (post_author,post_date,post_date_gmt,post_content,post_title,post_status,comment_status,ping_status,post_name,post_modified,post_modified_gmt,post_type) values ('".$post_author."','".$post_date."','".$post_date_gmt."','".$post_content."','".$post_title."','".$post_status."','".$comment_status."','".$ping_status."','".$post_name."','".$post_modified."','".$post_modified_gmt."','".$post_type."')";

		$insertFlag = $mysqlDb->insert($insertSql);
		echo $insertFlag."\n";
		if ($insertFlag) {
			
			echo "插入成功";
		}else{
			echo "插入失败";
		}
		$mysqlDb->dbClose();
		
		


	}




	// echo $describe;
	

	
}






?>