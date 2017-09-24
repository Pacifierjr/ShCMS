<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/ 

Class lapis{
	private $id;
	private $sql;
	private $res;
	private $info;
	private $conn;
	
	public function __construct($id){
		$this->conn = dbConn::getConnection();
		if ($id > 255)
			return false;
		$this->id	= Parser::Lapis($id);
		$this->sql	= $this->conn->prepare("SELECT [ItemName], [ConstHP], [ConstMP], [ConstSP], [ConstStr], [ConstDex], [ConstRec], [ConstInt], [ConstWis], [ConstLuc] FROM [PS_GameDefs].[dbo].[Items] WHERE [ItemID] = '".$this->id."'");
		$this->sql->execute();
		$this->info = $this->sql->fetch(PDO::FETCH_BOTH);	
	}
	
	public function getName(){
		return preg_replace('/จน/', 'ü', $this->info['ItemName']);
	}
	
	public function getHP(){
		return $this->info['ConstHP'];
	}
	
	public function getMP(){
		return $this->info['ConstMP'];
	}
	
	public function getSP(){
		return $this->info['ConstSP'];
	}
	
	public function getStr(){
		return $this->info['ConstStr'];
	}
	
	public function getDex(){
		return $this->info['ConstDex'];
	}
	
	public function getRec(){
		return $this->info['ConstRec'];
	}
	
	public function getInt(){
		return $this->info['ConstInt'];
	}
	
	public function getWis(){
		return $this->info['ConstWis'];
	}
	
	public function getLuc(){
		return $this->info['ConstLuc'];
	}
}

?>