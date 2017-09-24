<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/ 

Class UserStoredItems{
	private $uuid;
	private $sql;
	private $res;
	private $fet;
	private $itemArray;
	private $count;
	private $conn;
	
	public function __construct($uuid){
		$this->conn = dbConn::getConnection();
		$this->uuid = $uuid;
	}
	
	public function readItems(){
		$this->sql = $this->conn->prepare("SELECT [i].[ItemID], CAST([i].[ItemUID] as varchar(32)) as ItemUID, [i].[Slot], [i].[Quality], [i].[Gem1], [i].[Gem2], [i].[Gem3], [i].[Gem4], [i].[Gem5], [i].[Gem6], [i].[Craftname], [i].[Count], [i].[MakeTime], [id].[ItemName], [id].[ReqLevel], [id].[Quality] AS [MaxQuality], [id].[Slot] AS [MaxSlot]
					  FROM [PS_GameData].[dbo].[UserStoredItems] AS [i]
					  INNER JOIN [PS_GameDefs].[dbo].[Items] AS [id] ON [id].[ItemID] = [i].[ItemID]
					  WHERE [i].[UserUID] = '".$this->uuid."'
					  ORDER BY [i].[Slot] ASC");
		$this->res = $this->sql->execute();
		
		$this->itemArray = array();
		
		$this->count = 0;
		
		while ($this->fet = $this->sql->fetch(PDO::FETCH_BOTH)){
			$this->itemArray[$this->count]['ItemID']		= $this->fet[0];
			$this->itemArray[$this->count]['ItemName']		= preg_replace('/จน/', 'ü', $this->fet[13]);
			$this->itemArray[$this->count]['ReqLevel']		= $this->fet[14];
			$this->itemArray[$this->count]['Quality']		= $this->fet[3];
			$this->itemArray[$this->count]['MaxQuality']	= $this->fet[15];
			$this->itemArray[$this->count]['MaxSlot']		= $this->fet[16];
			$this->itemArray[$this->count]['ItemUID']		= $this->fet[1];
			$this->itemArray[$this->count]['Slot']			= $this->fet[2];
			$this->itemArray[$this->count]['Count']			= $this->fet[11];
			$this->itemArray[$this->count]['CraftName']		= $this->fet[10];
			$this->itemArray[$this->count]['MakeTime']		= strtotime($this->fet[12]);
			$this->itemArray[$this->count]['Lapis1']		= $this->fet[4];
			$this->itemArray[$this->count]['Lapis2']		= $this->fet[5];
			$this->itemArray[$this->count]['Lapis3']		= $this->fet[6];
			$this->itemArray[$this->count]['Lapis4']		= $this->fet[7];
			$this->itemArray[$this->count]['Lapis5']		= $this->fet[8];
			$this->itemArray[$this->count]['Lapis6']		= $this->fet[9];
			$this->count++;
		}
		
		return $this->itemArray;
	}
	
	public function getItemOnSlot($slot){
		if (!preg_match('#^[0-9]*$#', $slot))
			throw new SystemException('Slot must be an intergrer.', 0, 0, __FILE__, __LINE__);
			
		$this->sql = $this->conn->prepare("SELECT [i].[ItemID], [i].[ItemUID], [i].[Slot], [i].[Quality], [i].[Gem1], [i].[Gem2], [i].[Gem3], [i].[Gem4], [i].[Gem5], [i].[Gem6], [i].[Craftname], [i].[Count], [i].[MakeTime], [id].[ItemName], [id].[ReqLevel], [id].[Quality] AS [MaxQuality], [id].[Slot] AS [MaxSlot]
					  FROM [PS_GameData].[dbo].[UserStoredItems] AS [i]
					  INNER JOIN [PS_GameDefs].[dbo].[Items] AS [id] ON [id].[ItemID] = [i].[ItemID]
					  WHERE [i].[UserUID] = '".$this->uuid."' AND [i].[Slot] = '$slot'");
		$this->res = $this->sql->execute();
		
		$this->itemArray = NULL;
		$this->itemArray = array();
		
		if ($this->sql->rowCount() != 1)
			return false;
		
		$this->fet = $this->sql->fetch(PDO::FETCH_BOTH);
		
		$this->itemArray['ItemID']		= $this->fet[0];
		$this->itemArray['ItemName']	= preg_replace('/จน/', 'ü', $this->fet[13]);
		$this->itemArray['ReqLevel']	= $this->fet[14];
		$this->itemArray['Quality']		= $this->fet[3];
		$this->itemArray['MaxQuality']	= $this->fet[15];
		$this->itemArray['ItemUID']		= $this->fet[1];
		$this->itemArray['Slot']		= $this->fet[2];
		$this->itemArray['Count']		= $this->fet[11];
		$this->itemArray['CraftName']	= $this->fet[10];
		$this->itemArray['MakeTime']	= strtotime($this->fet[12]);
		$this->itemArray['Lapis1']		= $this->fet[4];
		$this->itemArray['Lapis2']		= $this->fet[5];
		$this->itemArray['Lapis3']		= $this->fet[6];
		$this->itemArray['Lapis4']		= $this->fet[7];
		$this->itemArray['Lapis5']		= $this->fet[8];
		$this->itemArray['Lapis6']		= $this->fet[9];
		
		return $this->itemArray;
		
	}
	
	public function deleteItemOnSlot($slot){
		if (!preg_match('#^[0-9]*$#', $slot))
			throw new SystemException('Slot must be an intergrer.', 0, 0, __FILE__, __LINE__);
		
		$this->sql = $this->conn->prepare("SELECT [ItemUID] FROM [PS_GameData].[dbo].[UserStoredItems] WHERE [UserUID] = '".$this->uuid."' AND [Slot] = '$slot'");
		$this->res = $this->sql->execute();
		
		if ($this->sql->rowCount() != 1)
			return false;
		
		$this->sql = $this->conn->prepare("DELETE FROM [PS_GameData].[dbo].[UserStoredItems] WHERE [UserUID] = '".$this->uuid."' AND [Slot] = '$slot'");
		$this->res = $this->sql->execute();
		
		if ($this->res)
			return true;
		else
			return false;
	}
	
	public function deleteAll(){
		$this->sql = $this->conn->prepare("DELETE FROM [PS_GameData].[dbo].[UserStoredItems] WHERE [UserUID] = '".$this->uuid."'");
		$this->res = $this->sql->execute();
		
		if ($this->res)
			return true;
		else
			return false;
	}
}

?>