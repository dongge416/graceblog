<?php
header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Methods:*'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');   
header("content-type:text/html;charset=utf-8");
//header("Access-Control-Allow-Origin: http://127.0.0.1:8020");
//include "TopSdk.php";
include "ApiUtils.php";
include "RStringUtil.php";
require("wp_mysql_class.php");
date_default_timezone_set('Asia/Shanghai');


$hdkKey = "gracehe";
$tbKey = "25648468";
$tbSecret = "aa762b360d46a544fd2e0f877dfeee79";
$pid = "mm_112728812_44352900_449168271";

$serverName = "139.199.219.164";
$userName = "root";
$userPassword = "82702083a";
$dbName = "wp";




// function test($taowords){
// 	$c = new TopClient;
// 	//$c->appkey = '24333767';
// 	//$c->secretKey = '8b5750f690730e4a2938b409329b0a3e';
// 	$c->appkey = '12497914';
// 	$c->secretKey = '4b0f28396e072d67fae169684613bcd1';
// 	$req = new WirelessShareTpwdQueryRequest;
// 	$req->setPasswordContent($taowords);
// 	$resp = $c->execute($req);
// 	print_r($resp);
// 	$title = $resp->title;
// 	return $title;
// }
//￥FrDKbeqHD9G￥
//$a = test("￥EAZobeqKyTS￥");
//print_r($a->title);

/**
$request_url = 'http://v2.api.haodanku.com/ratesurl'; 
$request_data['apikey'] = 'tshtts'; 
$request_data['itemid'] = '37407455923'; 
$request_data['pid'] = 'mm_97861461_26020803_101016325'; 
//$request_data['activityid'] = '7d6e6619ff754e1e94ea140e2a82240f'; 
$ch = curl_init(); 
curl_setopt($ch,CURLOPT_URL,$request_url); 
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
curl_setopt($ch, CURLOPT_TIMEOUT,10); 
curl_setopt($ch,CURLOPT_POST,1); 
curl_setopt($ch,CURLOPT_POSTFIELDS,$request_data); 
$res = curl_exec($ch); 
curl_close($ch); 
var_dump($res);

**/


// $result = ApiUtils::analysisKeywords("爱房间家用粉少女心可机洗定制】http://m.tb.cn/h.3gEHxPo?sm=b3cf83 点击链接，再选择浏览器咑閞；或復·制描述￥EWNtbVp0Gk7￥后");

// $result = ApiUtils::convertApi('【一次性毛巾洗脸巾沐足浴巾无纺布足浴加厚足疗巾洗脚纸擦脚纸巾】http://m.tb.cn/h.36J6gxq?sm=a8e615 点击链接，再选择浏览器咑閞；或復·制这段描述￥oclubfM8H9G￥后到👉淘♂寳♀👈');

// var_dump($result);



//ApiUtils::getItemInfo('56366021766359');

// $a = 2.3;
// var_dump($a/100)*10;


// $result = ApiUtils::getHighCommission("558587300390",$hdkKey,$pid);
// var_dump($result);
// $click_url = $result['data']['coupon_click_url'];
// var_dump($click_url);

// $_data = date("Y-m-d H:i:s");
// $_gmtdate=gmdate("Y-m-d H:i:s");
// var_dump($_data);
// var_dump($_gmtdate);


// $mysqlDb = new wp_mysql_class($serverName,$userName,$userPassword,$dbName);
// $mysqlDb->dbConnect();
// $mysqlDb->insert("insert into wp_posts (post_date,post_title,post_content) values ('2019-04-01 15:58:22','OOOOOOO','222')");
// // $mysqlDb->insert("insert into wp_posts (post_date,post_title,post_content) values ('2019-04-01 15:58:21' , '2222' , '测试内容')");
// $mysqlDb->dbClose();


// echo urlencode('今日淘宝大牌精选');
// %e4%bb%8a%e6%97%a5%e6%b7%98%e5%ae%9d%e5%a4%a7%e7%89%8c%e7%b2%be%e9%80%89


// $result = ApiUtils::creatTaoWords('https://uland.taobao.com/coupon/edetail?e=UU%2BF5aYeAToGQASttHIRqW5la6%2Bg%2Bh3tTT3hgSW2HTvJrcyrdqNGeuhMTEh1L2f%2Fd7pzmbb5K16HLhyv9SDampQ5wfGz%2Fu%2BNKH0Sqb0wdcnMBAjZVSbr6yZ6Y%2FpkHtT5QS0Flu%2FfbSovkBQlP112cJ5ECHpSy25Ge6L%2Bf9DtnlV6dhEzHcMnnjcK2v3ZVS%2Fe&traceId=0b0b7a2815372821802538971e&union_lens=lensId:0bb698e5_08d3_165ed2884b6_62b7&thispid=mm_97861461_26020803_101016325&src=fklm_hltk&from=tool&sight=fklm','99900000000','');

// $result = ApiUtils::creatTaoWords('https://temai.taobao.com/index.htm?pid=mm_40361636_232700353_63876100361','今天的大额优惠','');
// var_dump($result);


// $result = ApiUtils::creatTaoWords($tbKey,$tbSecret."",'https://s.click.taobao.com/dIQjZDw','8888888','');
// echo $result;

// $result = ApiUtils::getSalesList(0);
// var_dump($result);


//好单库品牌数据
// $result = ApiUtils::getBrand($hdkKey,"");
// $resultData = $result['data'];
// $dataCoutn = count($resultData);

// for ($i=0; $i < $dataCoutn; $i++) { 
// 	# code...
// 	$items = $resultData[$i]['item'];
// 	$itemCount = count($items);

// 	for ($j=0; $j < $itemCount; $j++) { 
// 		# code...
// 		$itemId = $items[$j]['itemid'];
// 		$result = ApiUtils::getHighCommission($itemId,$hdkKey,$pid);
// 		var_dump($result);
// 	}
// }

// $data = "a:10:{s:4:\"nrms\";s:13:\"文章描述2\";s:5:\"gm2mc\";s:12:\"淘宝购买\";s:5:\"gm2jg\";s:2:\"19\";s:2:\"sq\";s:2:\"10\";s:5:\"tbkkg\";s:1:\"0\";s:5:\"jietu\";s:65:\"http://sr.ffquan.cn/super_pic/o_1d67a5b931bfhm0t1vpv1kdl17ud8.jpg\";s:5:\"gm2lj\";s:34:\"https://s.click.taobao.com/R9QO6Cw\";s:5:\"nrgjc\";s:10:\"关键词2\";s:3:\"fbt\";s:13:\"加红展示2\";s:6:\"itemid\";s:8:\"宝贝ID\";}";

// var_dump(unserialize($data));

// var_dump($count);
// var_dump($result['data']);

$serverName = "198.177.127.149";
$userName = "zxdycom_dongge";
$userPassword = "csd13668945255a";
$dbName = "zxdycom_haowuriji";
$mysqlDb = new wp_mysql_class($serverName,$userName,$userPassword,$dbName);
$mysqlDb->dbConnect();
// $selectSql = "select * from zbp_post ";
$selectSql = "select count(*) as a from zbp_post where log_itemid ='22221111'";
$log_PostTime = time();
// $selectSql = "update zbp_post set log_PostTime = '".$log_PostTime."' where log_itemid = '551864794260'";
$selectResult = $mysqlDb->query($selectSql);
// $a = mysqli_fetch_ob
// while ($rows = $selectResult->fetch_object()) {
// 	# code...
// 	echo $rows->log_Title."\n";
// }
$row=mysqli_fetch_array($selectResult,MYSQLI_ASSOC);
echo $row['a'];

$mysqlDb->dbClose();



// $contentStr="999EAZobeqKyTS￥999";
// $contentStr="999€EAZobeqKyTS€999";
// $result = "999";
// if(strstr($contentStr,"￥")){

// 	$a_index = strpos($contentStr,"￥");
// 	$b_index = strrpos($contentStr,"￥");
// 	$result = substr($contentStr, $a_index,$b_index);
// 	echo $result;
// }else if(strstr($contentStr,"￥"){
// 	$a_index = strpos($contentStr,"￥");
// 	$b_index = strrpos($contentStr,"￥");
// 	$result = substr($contentStr, $a_index,$b_index);
// }

//$result = RStringUtil::separateKouLing($contentStr);
// if($result==""){
// 	echo "空";
// }else{
// 	echo $result;
// }


// if($result==""){
// 	echo "空";
// }else{
// 	echo $result;
// }



//print_r($b===false);000

// if(RStringUtil::checkUrl('http://item.taobao.com/item.htm?id=553582995153我的是的')){
// 	echo("是网址");
// }else{
// 	echo "不是网址";
// }


// if(RStringUtil::checkChinese('http://item.tahttp://m.tb.cn/h.3TaRJTQ')){
// 	echo "有中文";
// }else{
// 	echo "没有中文";
// }



// $data = array('title' => '标题','money'=>'9.90' );
// $result = array('code'=>'0','msg'=>'error','data'=>$data);
// var_dump($result);


// $test_arr = array();
// $test_arr['000']='999';
// echo ($test_arr['000']);


//RStringUtil::separateCouponexplain('满16元可用');

// var_dump(mb_strpos('开始23测试ceshi', '测试',0,"UTF8"));
// var_dump(strpos('开始23测试ceshi', '测试'));
// var_dump(mb_strlen('我是111',"UTF8"));
// var_dump(strlen('我是111'));
?>