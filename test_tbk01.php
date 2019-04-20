<?php
header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Methods:*'); 
header('Access-Control-Allow-Headers:x-requested-with,content-type');   
//header("Access-Control-Allow-Origin: http://127.0.0.1:8020");
include "TopSdk.php";
date_default_timezone_set('Asia/Shanghai');


function analysisKeywords($taowords){
	$c = new TopClient;
	$c->appkey = '24333767';
	$c->secretKey = '8b5750f690730e4a2938b409329b0a3e';
	$req = new WirelessShareTpwdQueryRequest;
	$req->setPasswordContent($taowords);
	$resp = $c->execute($req);
	$title = $resp->title;
	return $title;
}


//$taowords = $_GET['taowords'];


?>