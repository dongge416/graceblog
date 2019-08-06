<?php

include 'phpqrcode.php';
date_default_timezone_set('Asia/Shanghai');


$picUrl = $_GET['picurl'];
$productUrl = $_GET['producturl'];
$itemId = $_GET['itemid'];

// $picUrl = "https://img.alicdn.com/bao/uploaded/i2/2011301966/O1CN01MNR4kK1QOTBrvX6p1_!!0-item_pic.jpg";
// $productUrl = "https://bbs.csdn.net/topics/392169256";
// $itemId = "55555";
// $result = "error";





// 1 获取背景图尺寸
list($bg_w,$bg_h) = getimagesize("./img/bg.jpg");
		//创建画布
$image = imagecreatetruecolor($bg_w,$bg_h);
		//将背景图填充到画布
$bgImage = imagecreatefromjpeg("./img/bg.jpg");
imagecopyresized($image, $bgImage, 0, 0, 0, 0, $bg_w, $bg_h, $bg_w, $bg_h);
		//画主图
$productContent = file_get_contents($picUrl);
$productImage = @imagecreatefromstring($productContent);
imagecopyresized($image, $productImage, 30, 40, 0, 0, 800, 800, 800, 800);
		//画二维码
$qrCode = "./img/qrCode.png";
		// $productUrl = "https://zhidao.baidu.com/question/360788669508288572.html";
$errorCorrectionLevel = "H";
$qrCodeSize = 5;;
QRcode::png($productUrl,$qrCode,$errorCorrectionLevel,$qrCodeSize);
$imageQRcode = @imagecreatefromstring(file_get_contents($qrCode));

$qrCodeWidth = imagesx($imageQRcode);
$qrCodeHeight = imagesy($imageQRcode);

imagecopyresized($image, $imageQRcode, 110, 930, 0, 0, 200, 200, $qrCodeWidth, $qrCodeHeight);
		// imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
// header("Content-type: image/jpeg");
$imageName = date("YmdHis")."_".$itemId;
imagejpeg($image,"./outputimage/".$imageName.".jpeg");


imagedestroy($image);
$result = "http://b.rebate365.cn/qrcode/outputimage/".$imageName.".jpeg";
echo $result;

?>