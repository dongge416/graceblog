<?php

include 'phpqrcode.php';
date_default_timezone_set('Asia/Shanghai');


$picUrl = $_GET['picurl'];
$productUrl = $_GET['producturl'];
$itemId = $_GET['itemid'];
$itemTitle =$_GET['itemtitle'];
$price = $_GET['itempirce'];
$itemendprice = $_GET['itemendpirce'];


// $itemTitle = "儿童冰丝防蚊裤";
// $price = "29.9";
// $itemendprice = "19.9";

// $picUrl = "https://img.alicdn.com/bao/uploaded/i2/2011301966/O1CN01MNR4kK1QOTBrvX6p1_!!0-item_pic.jpg";
// $productUrl = "https://bbs.csdn.net/topics/392169256";
// $itemId = "55555";
$result = "error";





// 1 获取背景图尺寸
list($bg_w,$bg_h) = getimagesize("./img/bg02.jpg");
		//创建画布
$image = imagecreatetruecolor($bg_w,$bg_h);
		//将背景图填充到画布
$bgImage = imagecreatefromjpeg("./img/bg02.jpg");
imagecopyresized($image, $bgImage, 0, 0, 0, 0, $bg_w, $bg_h, $bg_w, $bg_h);
		//画主图
$productContent = file_get_contents($picUrl);
$productImage = @imagecreatefromstring($productContent);
$productImageWidth = imagesx($productImage);
$productImageHeight = imagesy($productImage);
imagecopyresized($image, $productImage, 30, 80, 0, 0, 300, 300, $productImageWidth, $productImageHeight);
// imagecopyresized($image, $productImage, 30, 40, 0, 0, 800, 800, 800, 800);
		//画二维码
$qrCode = "./img/qrCode.png";
		// $productUrl = "https://zhidao.baidu.com/question/360788669508288572.html";
$errorCorrectionLevel = "H";
$qrCodeSize = 5;;
QRcode::png($productUrl,$qrCode,$errorCorrectionLevel,$qrCodeSize);
$imageQRcode = @imagecreatefromstring(file_get_contents($qrCode));

$qrCodeWidth = imagesx($imageQRcode);
$qrCodeHeight = imagesy($imageQRcode);

imagecopyresized($image, $imageQRcode, 805, 80, 0, 0, 230, 230, $qrCodeWidth, $qrCodeHeight);
// imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)

//画标题
$myfont = "./font/simhei.ttf";
$textColor = imagecolorallocate($image, 0, 0, 0);
// imagettftext(image, size, angle, x, y, color, fontfile, text)
imagettftext($image, 30, 0, 350, 130, $textColor, $myfont, $itemTitle);
if (!empty($price)) {
	
	 //画原价
	$priceColor = imagecolorallocate($image, 154, 154, 154);
	imagettftext($image, 28, 0, 350, 290, $priceColor, $myfont, "原价:".$price);
	imageline($image, 350, 270, 550, 270, $priceColor);
}


//画价格
$endPriceColor = imagecolorallocate($image, 254, 0, 2);
imagettftext($image, 30, 0, 350, 360, $endPriceColor, $myfont, "现价:".$itemendprice."元");



// header("Content-type: image/jpeg");
$imageName = date("YmdHis")."_".$itemId;
imagejpeg($image,"./outputimage/".$imageName.".jpeg");



imagedestroy($image);
$result = "http://b.rebate365.cn/qrcode/outputimage/".$imageName.".jpeg";
echo $result;

?>