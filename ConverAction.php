<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers:x-requested-with,content-type');   
header("content-type:text/html;charset=utf-8");
date_default_timezone_set('Asia/Shanghai');

include "ApiUtils.php";
include "RStringUtil.php";

$content_str = $_GET['content'];

if (RStringUtil::checkUrl($content_str)) {
	# code...
}


$result_data = ApiUtils::convertApi($content_str);
echo $result_data;

?>