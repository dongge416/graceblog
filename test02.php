<?php
header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Methods:*'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');   
header("content-type:text/html;charset=utf-8");
// header("content-type:text/html;charset=gb2312");
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

//旧版
// $result = ApiUtils::analysisKeywords("￥p3gYYeKoHLS￥");
// var_dump($result);

//新版
// $result = ApiUtils20190611::analysisKeywords02("￥p3gYYeKoHLS￥");
// var_dump($result);

// $result = ApiUtils::convertApi('【一次性毛巾洗脸巾沐足浴巾无纺布足浴加厚足疗巾洗脚纸擦脚纸巾】http://m.tb.cn/h.36J6gxq?sm=a8e615 点击链接，再选择浏览器咑閞；或復·制这段描述￥oclubfM8H9G￥后到👉淘♂寳♀👈');

// var_dump($result);



// $result = ApiUtils::getItemInfo('18475042599');
// var_dump($result);
// // $a = 2.3;
// var_dump($a/100)*10;


// $result = ApiUtils::converShortUrl("http://dl.vipbfx.cn/home/index.html?number=http%3A%2F%2Fxunlei.xiazai-zuida.com%2F1906%2FZhuilong2%EF%BC%9A%E8%B4%BC%E7%8E%8B.HD1280%E9%AB%98%E6%B8%85%E5%9B%BD%E8%AF%AD%E4%B8%AD%E5%AD%97%E7%89%88.mp4");
// $result = ApiUtils::converShortUrl("http://download.xunleizuida.com/1904/HY为家.BD1280高清中英双字版.mp4");
// var_dump($result);
	//2849184197
$dir = "F:/BaiduYunDownload/wwwd";
// $dir = iconv("GBK", "utf-8", $dir);

// $filesHandle = opendir($dir);
// while ($file = readdir($filesHandle)) {
// 	var_dump(mb_convert_encoding($file,"utf-8","GBK"));
// }



function myScanDir($dir){
	$files = array();
	if (is_dir($dir)) {
		if ($handle = opendir($dir)) {
			
			while (($file = readdir($handle)) !== false) {

				if($file != "." && $file != ".."){
					
					if (is_dir($dir."/".$file)) {
						$files[$file] = myScanDir($dir."/".$file);
						$file = mb_convert_encoding($file,"utf-8","GBK");
						if (strstr($file, "学益佳")) {
							$newFileName = str_replace("学益佳", "", $file);
							$newDir = mb_convert_encoding($dir, "utf-8","GBK");
							var_dump(rename($newDir."/".$file,$newDir."/".$newFileName));
							echo "修改后的名字:".$newFileName."\n";
						}

						

						echo "目录:".$file."\n";
					}else{
						$file = mb_convert_encoding($file,"utf-8","GBK");
						$files[] = $dir."/".$file;


						if (strstr($file, "学益佳")) {
							$newFileName = str_replace("学益佳", "", $file);
							$newDir = mb_convert_encoding($dir, "utf-8","GBK");
							var_dump(rename($newDir."/".$file,$newDir."/".$newFileName));
							echo "修改后的名字:".$newFileName."\n";
						}

						echo "文件名:".$file."\n";
					}
				}

				
			}
		}
	}
	closedir($handle);
	return $files;
}

myScanDir($dir);

// var_dump(urlencode("http://xunlei.xiazai-zuida.com/1906/Zhuilong2：贼王.HD1280高清国语中字版.mp4"));



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

// $serverName = "198.177.127.149";
// $userName = "zxdycom_dongge";
// $userPassword = "csd13668945255a";
// $dbName = "zxdycom_haowuriji";
// $mysqlDb = new wp_mysql_class($serverName,$userName,$userPassword,$dbName);
// $mysqlDb->dbConnect();

// $selectSql = "select count(*) as a from zbp_post where log_itemid ='22221111'";
// $log_PostTime = time();

// $selectResult = $mysqlDb->query($selectSql);

// $row=mysqli_fetch_array($selectResult,MYSQLI_ASSOC);
// echo $row['a'];

// $mysqlDb->dbClose();



//测试单品api
// $result = ApiUtils::getItemDetail('gracehe','586643759651');
// var_dump($result);

//测试高佣金接口3
// $result = ApiUtils::getHighCommission3("18475042599","gracehe","mm_112728812_44352900_449168271","");
// var_dump(json_decode($result));
// 
//测试大淘客单品详情
// $result = ApiUtils::getItemDetail4DTK("592358456921");
// $a = $result['data']['total_num'];
// var_dump($a);

//测试店铺转换淘口令
// $result = ApiUtils::shop2Taowords($tbKey,$tbSecret,$pid,"4020099716");
// var_dump($result);

//测试达人文章
// $result = ApiUtils::getDaRenWenZhang("gracehe","4948");
// $data = $result['data']['article'];
// var_dump(htmlspecialchars_decode($data));


//测试二维码图片生成
// $result = ApiUtils::creatImage("https://img.alicdn.com/imgextra/i3/725677994/O1CN0128vIcFXg5I7fJto_!!725677994.jpg","http://wx.tshtts.cn/common/index.html?number=999aa","3150126865487");
// echo $result;

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