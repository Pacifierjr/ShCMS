<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class Auction{
	private $mid;
	private $sql;
	private $res;
	private $fet;
	private $info;
	private $conn;
	public function __construct($mid){
		$this->mid	= $mid;
		$this->conn = dbConn::getConnection();
		$this->sql	= $this->conn->prepare("SELECT [m].[MarketID], [m].[CharID], [m].[MinMoney], [m].[DirectMoney], [m].[GuaranteeMoney], [m].[TenderCharID], [m].[TenderCharName], [m].[TenderMoney], [m].[EndDate], [m].[Del],
					   [mi].[ItemID], [mi].[Quality], CAST([mi].[ItemUID] as varchar(32)) as ItemUID, [mi].[Count],
					   [i].[ItemName], [i].[ReqLevel], [i].[Quality] AS [MaxQuality]
					   FROM [PS_GameData].[dbo].[Market] AS [m]
					   INNER JOIN [PS_GameData].[dbo].[MarketItems] AS [mi] ON [mi].[MarketID] = [m].[MarketID]
					   INNER JOIN [PS_GameDefs].[dbo].[Items] AS [i] ON [i].[ItemID] = [mi].[ItemID]
					   WHERE [m].[MarketID] = ?");
		$this->sql->bindParam(1, $this->mid, PDO::PARAM_INT);
		$this->sql->execute();
		$this->fet	= $this->sql->fetch(PDO::FETCH_BOTH);
		$this->info = $this->fet;
		return true;
	}
	
	public function getMarketID(){
		return $this->info['MarketID'];
	}
	
	public function getCharID(){
		return $this->info['CharID'];
	}
	
	public function getMinMoney(){
		if ($this->info['MinMoney'] < 0)
			return ($this->info['MinMoney'] * (-1)) + 2147483648;
		else
			return $this->info['MinMoney'];
	}
	
	public function getDirectMoney(){
		if ($this->info['DirectMoney'] < 0)
			return ($this->info['DirectMoney'] * (-1)) + 2147483648;
		else
			return $this->info['DirectMoney'];
	}
	
	public function getKosten(){
		return $this->info['GuaranteeMoney'];
	}
	
	public function getBieterCharID(){
		return $this->info['TenderCharID'];
	}
	
	public function getBieterName(){
		return $this->info['TenderCharName'];
	}
	
	public function getGebot(){
		return $this->info['TenderMoney'];
	}
	
	public function getEnde(){
		return strtotime($this->info['EndDate']);
	}
	
	public function getItemID(){
		return $this->info['ItemID'];
	}
	
	public function getQuality(){
		return $this->info['Quality'];
	}
	
	public function getItemName(){
		return $this->info['ItemName'];
	}
	
	public function getLevel(){
		return $this->info['ReqLevel'];
	}
	
	public function getMaxQuality(){
		return $this->info['MaxQuality'];
	}
	
	public function getItemUID(){
		return (string)$this->info['ItemUID'];
	}
	
	public function getCount(){
		return $this->info['Count'];
	}
	
	public function checkDel(){
		if ($this->info['Del'] == 0)
			return false;
		else
			return true;
	}
	
	public function Del(){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Market] SET [Del] = 1 WHERE [MarketID] = ?");
		$this->sql->bindParam(1,$this->getMarketID(),PDO::PARAM_INT);
		$this->res = $this->sql->excecute();
		
		if ($this->res)
			return true;
		else
			return false;
	}
}

?>