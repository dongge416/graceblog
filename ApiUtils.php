<?php
include "TopSdk.php";
error_reporting( E_ALL&~E_NOTICE );
class ApiUtils{

	//zhaoliuping1967
	public static $my_app_key = "25622488";
	public static $my_app_secret_key="2e872c09ff31878d86351f3b592a7c48";
	
	

	public static $haodanku_key = "gracehe";
	public static $my_pid="mm_112728812_44352900_449168271";


	public static function analysisKeywords($taowords){
		$c = new TopClient;
		$c->appkey = self::$my_app_key;
		$c->secretKey = self::$my_app_secret_key;
		$req = new WirelessShareTpwdQueryRequest;
		$req->setPasswordContent($taowords);
		$resp = $c->execute($req);
		//print_r($resp);
		return $resp;
	}

	//201906
	public static function analysisKeywords02($taowords){
		$c = new TopClient;
		$c->appkey = self::$my_app_key;
		$c->secretKey = self::$my_app_secret_key;
		$$req = new TbkTpwdConvertRequest;
		$req->setPasswordContent($taowords);
		//mm_131510009_450450026_108534950088
		$req->setAdzoneId("108534950088");
		$req->setDx("1");
		$resp = $c->execute($req);
		return $resp;
	}

	public static function creatTaoWords($tbKey,$tbSecret,$urlStr,$textStr,$logo){
		$result_taowords;
		$c = new TopClient;
		$c->appkey = $tbKey;
		$c->secretKey = $tbSecret;
		$req = new TbkTpwdCreateRequest;
		
		$req->setText($textStr);
		$req->setUrl($urlStr);
		if (!empty($logo)) {
			# code...
			$req->setLogo($logo);
		}
		
		
		$resp = $c->execute($req);
		// var_dump('===淘口令===');
		// var_dump($resp);
		//print_r($resp);
		$result_taowords = $resp->data->model;
		return $result_taowords;
	}

	public static function getItemInfo($itemId){
		$c = new TopClient;
		$c->appkey = self::$my_app_key;
		$c->secretKey = self::$my_app_secret_key;
		$req = new TbkItemInfoGetRequest;
		$req->setNumIids($itemId);
		
		$resp = $c->execute($req);
		$arr_results = $resp->results;
		$n_tbk_item = $arr_results->n_tbk_item;

		
		return $n_tbk_item;
	}

	public static function shop2Taowords($tbKey,$tbSecret,$pid,$shopId){
		$c = new TopClient;
		$c->appkey = $tbKey;
		$c->secretKey = $tbSecret;
		$req = new TbkShopConvertRequest;
		$req->setFields("user_id,click_url");
		$req->setUserIds($shopId);
		$req->setPlatform("1");
		$req->setAdzoneId($pid);
		// $req->setUnid("demo");
		$resp = $c->execute($req);
		return $resp;

	}

	public static function getItemDetail4DTK($itemId){
		$request_url = 'http://api.dataoke.com/index.php?r=port/index&appkey=c6409e9647&v=2&id='
		.$itemId; 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $request_url);	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($curl);
		curl_close($curl);
		$send_result = json_decode($result,true);
		return $send_result;
	}

	public static function getHighCommission($itemId,$hdkKey,$pid){
		
		$send_result = array();
		$request_url = 'http://v2.api.haodanku.com/ratesurl'; 
		$request_data['apikey'] = $hdkKey; 
		$request_data['itemid'] = $itemId; 
		$request_data['pid'] = $pid; 
		//$request_data['activityid'] = '7d6e6619ff754e1e94ea140e2a82240f'; 
		$ch = curl_init(); 
		curl_setopt($ch,CURLOPT_URL,$request_url); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch, CURLOPT_TIMEOUT,10); 
		curl_setopt($ch,CURLOPT_POST,1); 
		curl_setopt($ch,CURLOPT_POSTFIELDS,$request_data); 
		$res = curl_exec($ch); 
		curl_close($ch); 
		$arr_msg_result = json_decode($res,true);
		$arr_msg_code = $arr_msg_result['code'];
		$arr_msg_data = $arr_msg_result['data'];
		//var_dump($res);

		if ($arr_msg_code==1) {
			# 请求成功
			$send_result['code'] = '1';
			$send_result['msg'] = 'SUCCESS';
			$send_result_data = array();
			$send_result_data['max_commission_rate'] = $arr_msg_data['max_commission_rate'];
			$send_result_data['couponmoney'] = $arr_msg_data['couponmoney'];
			$send_result_data['coupon_click_url'] = $arr_msg_data['coupon_click_url'];
			$send_result_data['couponexplain'] = $arr_msg_data['couponexplain'];
			$send_result['data'] = $send_result_data;
			//var_dump($send_result);
		}else{
 			# 请求成功
			$send_result['code'] = '0';
			$send_result['msg'] = 'error:'.$arr_msg_result['msg'];
			$send_result['data'] = '';
		}
		return $res;

	}

	public static function getHighCommission2($itemId,$hdkKey,$pid){
		
		$send_result = array();
		$request_url = 'http://v2.api.haodanku.com/ratesurl'; 
		$request_data['apikey'] = $hdkKey; 
		$request_data['itemid'] = $itemId; 
		$request_data['pid'] = $pid; 
		//$request_data['activityid'] = '7d6e6619ff754e1e94ea140e2a82240f'; 
		$ch = curl_init(); 
		curl_setopt($ch,CURLOPT_URL,$request_url); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch, CURLOPT_TIMEOUT,10); 
		curl_setopt($ch,CURLOPT_POST,1); 
		curl_setopt($ch,CURLOPT_POSTFIELDS,$request_data); 
		$res = curl_exec($ch); 
		curl_close($ch); 
		
		return $res;

	}

	public static function getHighCommission3($itemId,$hdkKey,$pid,$activityId){
		
		$send_result = array();
		$request_url = 'http://v2.api.haodanku.com/ratesurl'; 
		$request_data['apikey'] = $hdkKey; 
		$request_data['itemid'] = $itemId; 
		$request_data['pid'] = $pid; 
		$request_data['activityid'] = $activityId; 
		$ch = curl_init(); 
		curl_setopt($ch,CURLOPT_URL,$request_url); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch, CURLOPT_TIMEOUT,10); 
		curl_setopt($ch,CURLOPT_POST,1); 
		curl_setopt($ch,CURLOPT_POSTFIELDS,$request_data); 
		$res = curl_exec($ch); 
		curl_close($ch); 
		
		return $res;

	}


	public static function getSalesList($hdkKey,$cid){
		$request_url = 'http://v2.api.haodanku.com/sales_list/apikey/'.$hdkKey.'/sale_type/2/cid/' . $cid;		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $request_url);	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($curl);
		curl_close($curl);

		

		$send_result = json_decode($result,true);

		return $send_result;

	}

	public static function getBrand($hdkKey,$brandcat){
		$request_url = "http://v2.api.haodanku.com/brand/apikey/".$hdkKey."/back/100/min_id/1";		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $request_url);	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($curl);
		curl_close($curl);
		$send_result = json_decode($result,true);
		return $send_result;

	}

	public static function getItemDetail($hdkKey,$itemid){
		$request_url = "http://v2.api.haodanku.com/item_detail/apikey/".$hdkKey."/itemid/".$itemid;		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $request_url);	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($curl);
		curl_close($curl);
		$send_result = json_decode($result,true);
		return $send_result;
	}

	public static function getDaRenWenZhang($hdkKey,$articleId){
		$request_url = "http://v2.api.haodanku.com/talent_article/apikey/".$hdkKey."/id/".$articleId."/";		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $request_url);	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($curl);
		curl_close($curl);

		$send_result = json_decode($result,true);
		// var_dump($send_result);
		return $send_result;
	}

	public static function creatImage($picUrl,$productUrl,$itemId){
		$request_url = "http://b.rebate365.cn/qrcode/CreatQRcodeImageAction02.php?picurl=".$picUrl."&producturl=".$productUrl."&itemid=".$itemId;		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $request_url);	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}

	public static function creatImage02($picUrl,$productUrl,$itemId,$itemTitle,$itemPrice,$itemendPrice){
		$request_url = "http://b.rebate365.cn/qrcode/CreatQRcodeImageAction03.php?picurl=".$picUrl."&producturl=".$productUrl."&itemid=".$itemId."&itemtitle=".$itemTitle."&itempirce=".$itemPrice."&itemendpirce=".$itemendPrice;		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $request_url);	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}

public static function converShortUrl($longUrl){
		$request_url = "https://api.weibo.com/2/short_url/shorten.json?source=2849184197&url_long=".$longUrl;		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $request_url);	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		$result = curl_exec($curl);
		curl_close($curl);
		$send_result = json_decode($result,true);

		return $send_result;

	}



	public static function convertApi($taowords){
		$send_result = array('code'=>'0','msg'=>'error','data'=>'');

		$item_id ;
		if (RStringUtil::checkUrl($taowords)) {
			# 是链接，分离itmeid
			//$send_result['data'] = '系统无法识别这个口令，请在淘宝把链接复制给我查询';
			
			//return $send_result;
		}

		if(RStringUtil::isTamllKouLing($taowords)){
			$send_result['data'] = '系统无法识别这个口令，请在淘宝把链接复制给我查询';
			var_dump('isTamllKouLing');

			return json_encode($send_result,JSON_UNESCAPED_UNICODE);
		}

		if(RStringUtil::isKouLing($taowords)){
			$taowords_result = self::analysisKeywords($taowords);
			//var_dump($taowords_result);
			if($taowords_result->suc == 'false'){
				#淘口令请求失败
				$send_result['data'] = '抱歉！这个链接没有任何优惠和反利,请换一个宝贝再试';
				return json_encode($send_result,JSON_UNESCAPED_UNICODE);
			}
		}

		
		$item_id = RStringUtil::separateItemId($taowords_result->url);
		//echo "item_id:".$item_id;
		if (!is_numeric($item_id)) {
			# code...
			//echo '解析ID失败:'.$item_id;
			$send_result['data'] = '系统无法识别这个口令，请在淘宝把链接复制给我查询';
			return json_encode($send_result,JSON_UNESCAPED_UNICODE);
		}else{
			//是数字，进行高佣金转链接
			
			$hightCommission = self::getHighCommission($item_id);
			//var_dump($hightCommission);
			$code = $hightCommission['code'];
			if ($code == 0) {
				# code...
				$send_result['data'] = '抱歉！这个链接没有任何优惠和反利,请换一个宝贝再试';
				//var_dump('-----');
				return json_encode($send_result,JSON_UNESCAPED_UNICODE);
			}

			//var_dump('==========');
			//var_dump($hightCommission);
			//标题
			$title = $taowords_result->content;
			//var_dump('-----title------');
			//echo ($title);
			//二合一连接
			$coupon_click_url = $hightCommission['data']['coupon_click_url'];
			//返回的淘口令
			$send_taoword = self::creatTaoWords($coupon_click_url,$title,'');
			
			//原价
			$original_price = $taowords_result->price;
			if (empty($original_price)) {
				#原价为空
				$item_info = self::getItemInfo($item_id);
				$original_price = $item_info->zk_final_price;

			}
			$original_price = floatval($original_price);
			//优惠劵金额
			$couponmoney = $hightCommission['data']['couponmoney'];
			//优惠劵使用条件
			$couponexplain = $hightCommission['data']['couponexplain'];
			//券后价
			$discount_price;
			//优惠劵使用条件金额
			$couponexplain_money = RStringUtil::separateCouponexplain($couponexplain);
			if ($original_price >= $couponexplain_money) {
				# 可以使用优惠劵
				$discount_price = $original_price - $couponmoney;
				// var_dump('------8888888888-------');
				// var_dump($original_price);
				// var_dump($couponmoney);
				// var_dump($discount_price);
				// var_dump('------8888888888-------');
			}else{
				
				$discount_price = $original_price;
			}
			
			//计算佣金
			//佣金比率
			$max_commission_rate = $hightCommission['data']['max_commission_rate'];
			//佣金
			$commission = $discount_price * ($max_commission_rate / 100);
			// var_dump('--佣金--');
			// var_dump($commission);
			$commission = round($commission,2);
			// var_dump($commission);
			
			// var_dump('---discount_price---');
			// var_dump($discount_price);
			// var_dump('---max_commission_rate---');
			// var_dump($max_commission_rate);
			// var_dump('---original_price--');
			// var_dump($original_price);
			
			


			//返利
			$rebate_money = RStringUtil::countRebateMoney($commission);
			$rebate_money = round($rebate_money,2);
			// var_dump('-----返利----');
			// var_dump($rebate_money);
			
			if (!empty($send_taoword)) {
				# code...
			}


			$send_result['code'] = '1';
			$send_result['msg'] = 'SUCCESS';
			$send_result['data']['title']=$title;
			$send_result['data']['discount_price'] = $discount_price;
			$send_result['data']['commission'] = $commission;
			$send_result['data']['couponmoney'] = $couponmoney;
			$send_result['data']['rebate_money'] = $rebate_money;
			$send_result['data']['send_taoword'] = $send_taoword;
			$send_result_json = json_encode($send_result,JSON_UNESCAPED_UNICODE);
			return $send_result_json;
		}
		

	}

}
?>