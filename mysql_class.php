<?php

class mysql_class {
	private $serverName ;
	private $userName ;
	private $userPassword ;
	private $dbName ;
	private $conn ;


	function mysql_class($serverName,$userName,$userPassword,$dbName){
		$this->serverName = $serverName;
		$this->userName = $userName;
		$this->userPassword = $userPassword;
		$this->dbName = $dbName;
	}

	function dbConnect(){
		$this->conn = mysql_connect($this->serverName,$this->userName,$this->userPassword);
		// var_dump($this->serverName);
		if(!$this->conn){
			// die('connect error:' . mysql__error());
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db($this->dbName,$this->conn);
		mysql_query('set names utf-8');

	}

	function dbClose(){
		mysql_close($this->conn);
	}

	function query($sql){
		return mysql_query($sql);
	}

	// function myArray($result){
	// 	retrun mysql_fetch_array($result);[]
	// }

	function rows($result){
		return mysql_num_rows($result);
	}

	function update($sql){
		$result = mysql_query($sql);
		var_dump('更新结果:'.$result);
	}

	function insert($sql){
		$result = mysql_query($sql);
		var_dump('插入结果:'.$result);
	}

}

?>