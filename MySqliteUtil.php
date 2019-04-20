<?php

class MySqliteUtil extends SQLite3{

	private $filePath;

	function __construct($filePath){
		$this->filePath = $filePath;
		$this->open($this->filePath);
	}


	

}




// $db = new SqliteUtil('/Applications/XAMPP/xamppfiles/htdocs/phpworkspace/tbksdk/haodanku.db');
// if(!$db){
// 	echo $db->lastErrorMsg();
// } else {
// 	echo "Opened database successfully\n";
// }

//查询
// $results = $db->query('select * from 会员信息');
// while($rows = $results->fetchArray(SQLITE3_ASSOC)){
// 	var_dump($rows['对应ID']);
// }

//插入
// $results = $db->exec("insert into product (itemid,itemshorttitle) values ('111','测试短标题')");
// if(!$results){
// 	echo "插入错误".lastErrorMsg();
// }else{
// 	echo "插入成功";
// }

//更新
// $results = $db->exec("update product set itemshorttitle='测试段标题3' where itemid = '111'");
// if(!$results){
// 	echo "更新错误:".lastErrorMsg();
// }else{
// 	echo "更新成功";
// }



?>