<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers:x-requested-with,content-type');   
header("content-type:text/html;charset=utf-8");
include "ApiUtils.php";
date_default_timezone_set('Asia/Shanghai');




$movieAddress = $_GET['movieaddress'];

$movieAddressSecret = base64_encode($movieAddress);
$longUrl = "http://dl.vipbfx.cn/home/index.html?number=".$movieAddressSecret;

$request_url = "https://api.weibo.com/2/short_url/shorten.json?source=2849184197&url_long=".$longUrl;		
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $request_url);	
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_TIMEOUT, 10);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
$result = curl_exec($curl);
curl_close($curl);
// $send_result = json_decode($result,true);


$result = json_decode($result,true);
// var_dump($result);
if ($result) {
	echo $result['urls'][0]['url_short'];
}else{
	echo "error";
}



?>