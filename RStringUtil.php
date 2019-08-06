<?php

class RStringUtil{

	public static function dirUtil(){
		
	}


	public static function isKouLing($contentStr){
		if (strstr($contentStr, "￥")||strstr($contentStr, "€")) {
			
			return true;
		}else {
			return false;
		}
	}

	public static function custionKouLing($kouling,$type){
		$result = "(".str_replace("￥", "", $kouling).")";
		return $result;
	}

	//商品类目：0全部，1女装，2男装，3内衣，4美妆，5配饰，6鞋品，7箱包，8儿童，9母婴，10居家，11美食，12数码，13家电，14其他，15车品，16文体，17宠物
	public static function getCidName($cid){
		$result = "全部";

		if ($cid==1) {
			$result = "女装";
		}elseif ($cid == 2) {
			$result = "男装";
		}elseif ($cid == 3) {
			$result = "内衣";
		}elseif ($cid == 4) {
			$result = "美妆";
		}elseif ($cid == 5) {
			$result = "配饰";
		}elseif ($cid == 6) {
			$result = "鞋品";
		}elseif ($cid == 7) {
			$result = "箱包";
		}elseif ($cid == 8) {
			$result = "儿童";
		}elseif ($cid == 9) {
			$result = "母婴";
		}elseif ($cid == 10) {
			$result = "居家";
		}elseif ($cid == 11) {
			$result = "美食";
		}elseif ($cid == 12) {
			$result = "数码";
		}elseif ($cid == 13) {
			$result = "家电";
		}elseif ($cid == 14) {
			$result = "其他";
		}elseif ($cid == 15) {
			$result = "车品";
		}elseif ($cid == 16) {
			$result = "文体";
		}elseif ($cid == 17) {
			$result = "宠物";
		}
		return $result;
	}

	public static function isTamllKouLing(){

		if (strstr($contentStr, "喵口令")) {
			
			return true;
		}else{
			return false;
		}
	}

	public static function separateKouLing($contentStr){
		$result = "";
		if(strstr($contentStr,"￥")){
			
			$a_index = strpos($contentStr,"￥");
			$b_index = strrpos($contentStr,"￥");
			// echo "a_index:".$a_index;
			// echo "b_index:".$b_index;
			$result = substr($contentStr, $a_index,$b_index);
			
		}else if(strstr($contentStr,"*")){
			$a_index = strpos($contentStr,"￥");
			$b_index = strrpos($contentStr,"￥");
			$result = substr($contentStr, $a_index,$b_index);
			if($a_index != $b_index){
				$result = substr($contentStr, $a_index,$b_index);
			}
			
			
		}else if(strstr($contentStr,"€")){
			$a_index = strpos($contentStr,"€");
			$b_index = strrpos($contentStr,"€");
			if($a_index != $b_index){
				$result = substr($contentStr, $a_index,$b_index);
			}
		
		}
		return $result;
	}

	public static function separateItemId($contentStr){
		$item_id;
		if (strstr($contentStr, 'https://item.taobao.com/item.htm?')) {
			# code...
			$a_index = strpos($contentStr, '&id=')+4;
			$b_index = strpos($contentStr, '&sourceType');
			// echo 'a_index:'.$a_index;
			// echo 'b_index:'.$b_index;
			$item_id = substr($contentStr, $a_index,$b_index-$a_index);
			return $item_id;
		}else if (strstr($contentStr, 'taobao.com/i')) {
			
			
			if (strstr($contentStr, '.htm')&&strstr($contentStr, 'sourceType=item')) {
				# code...
				$a_index = strpos($contentStr, 'com/i')+5;
				$b_index = strpos($contentStr, '.htm');
				$item_id = substr($contentStr, $a_index,$b_index-$a_index);
				return $item_id;
			}
		}
	}

	public static function checkUrl($contentStr){
		$regex = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|([\s()<>]+|(\([\s()<>]+))*\))+(?:([\s()<>]+|(\([\s()<>]+))*\)|[^\s`!(){};:\'".,<>?«»“”‘’]))@';
		//var_dump( preg_match($regex, 'http://segmentfault.com/q/1010000000584340') );
		return (preg_match($regex, $contentStr));
	}

	public static function checkChinese($contentStr){
		$regex = '/[\x{4e00}-\x{9fa5}]/u';
		return (preg_match($regex, $contentStr));
	}

	public static function separateCouponexplain($contentStr){
		$a_index = mb_strpos($contentStr, '满',0,"UTF8")+1;
		$b_index = mb_strpos($contentStr, '元',0,"UTF8");
		$result = mb_substr($contentStr, $a_index,$b_index-$a_index,"UTF8");
		return $result;
	}

	public static function countRebateMoney($money){
		$rebate_rate ;
		$rebate_money;
		if ($money<=0.3) {
			# code...
			$rebate_rate = 0.7;
		}else if ($money <= 1) {
			# code...
			$rebate_rate = 0.65;
		}else if ($money <= 3) {
			$rebate_rate = 0.5;
		}else if ($money <= 5) {
			$rebate_rate = 0.48;
		}else if ($money <= 15) {
			$rebate_rate = 0.45;
		}else if ($money <= 80) {
			$rebate_rate = 0.4;
		}else if ($money <= 200) {
			$rebate_rate = 0.35;
		}elseif ($money <= 500) {
			$rebate_rate = 0.3;
		}
		$rebate_money = $money * $rebate_rate;
		return $rebate_money; 
	}

}

?>