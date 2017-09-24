<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class lapis{
	private $id;
	private $sql;
	private $res;
	private $info;
	
	public function __construct($id){
		if ($id > 255)
			return false;
		$this->id	= Parser::Lapis($id);
		$this->sql	= "SELECT [ItemName], [ConstHP], [ConstMP], [ConstSP], [ConstStr], [ConstDex], [ConstRec], [ConstInt], [ConstWis], [ConstLuc] FROM [PS_GameDefs].[dbo].[Items] WHERE [ItemID] = '".$this->id."'";
		$this->res	= mssql_query($this->sql);
		$this->info = mssql_fetch_assoc($this->res);	
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