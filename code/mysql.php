<?php

class MySQL{
	private $conn;
	private $host_addr = "localhost";
	private $host_user = "root";
	private $host_pass = "";
	private $host_db = "auch";

	public function __construct($db = null){
		if($db != null) $this->host_db = $db;
		$this->conn = new PDO("mysql:host=$this->host_addr;dbname=$this->host_db",$this->host_user,$this->host_pass);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}



try{
	$x = new MySQL();
	echo "Connected";

}catch(Exception $e){
		echo "Connection failed" . $e->getMessage();
		die();
}



?>