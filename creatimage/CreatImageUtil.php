<?php
include 'phpqrcode.php';
date_default_timezone_set('Asia/Shanghai');

// phpinfo();

class CreatImageUtil {

	public function creatImage($picUrl,$productUrl){
		// 1 获取背景图尺寸
		list($bg_w,$bg_h) = getimagesize("./bg.jpg");
		//创建画布
		$image = imagecreatetruecolor($bg_w,$bg_h);
		//将背景图填充到画布
		$bgImage = imagecreatefromjpeg("./bg.jpg");
		imagecopyresized($image, $bgImage, 0, 0, 0, 0, $bg_w, $bg_h, $bg_w, $bg_h);
		//画主图
		$productContent = file_get_contents($picUrl);
		$productImage = @imagecreatefromstring($productContent);
		imagecopyresized($image, $productImage, 30, 40, 0, 0, 800, 800, 800, 800);
		//画二维码
		$qrCode = "./qrCode.png";
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
		imagejpeg($image,"../outputimage/".date("YmdHis").".jpeg");

		
		imagedestroy($image);
	}



}

$picUrl = "https://img.alicdn.com/imgextra/i3/725677994/O1CN017YXHPD28vIedsctMk_!!725677994.jpg";
$productUrl = "https://zhidao.baidu.com/question/360788669508288572.html";
// $creatImageUtil = new CreatImageUtil();
// $creatImageUtil->creatImage($picUrl,$productUrl);




?>