<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/ 

Class item{
	private $type; //Art, 0 => Inventar, 1 => Warenlager, 2 => Gildenwarenlager 3=> Auktionshaus
	private $uid;
	private $db;
	private $sql;
	private $res;
	private $fet;
	private $info;
	private $char;
	private $user;
	private $guild;
	private $auction;
	private $craftname;
	private $craftnameArr;
	private $craftnameFields;
	private $foreachDummy;
	private $conn;
	
	public function __construct($uid, $type){
		$this->conn = dbConn::getConnection();
		$this->uid	= $uid;
		$this->type	= $type;
		$this->craftnameFields = array('Str', 'Dex', 'Rec', 'Int', 'Wis', 'Luc' , 'HP', 'MP', 'SP', 'Lapisa');
		
		$this->db	= array(0 => '[PS_GameData].[dbo].[CharItems]',
							1 => '[PS_GameData].[dbo].[UserStoredItems]',
							2 => '[PS_GameData].[dbo].[GuildStoredItems]',
							3 => '[PS_GameData].[dbo].[MarketItems]');
		$this->sql	= $this->conn->prepare("SELECT [ui].*, [i].[ItemName], [i].[ReqLevel], [i].[Quality] AS [MaxQuality], [i].[Slot] AS [MaxSlots], CAST([ui].[ItemUID] as varchar(32)) as iItemUID
					   FROM ".$this->db[$this->type]." AS [ui]
					   INNER JOIN [PS_GameDefs].[dbo].[Items] AS [i] ON [i].[ItemID] = [ui].[ItemID]
					   WHERE [ui].[ItemUID] = '".$this->uid."'");
					   
		$this->sql->execute();
			
		if ($this->sql->rowCount() == 0){
			return false;
		}
		
		$this->fet	= $this->sql->fetch(PDO::FETCH_BOTH);
		$this->info = $this->fet;

		if (isset($this->info['CharID'])){
			$this->char	= new char($this->info['CharID']);
			$this->user = new user($this->char->getUserUID());
		} else if (isset($this->info['UserUID'])){
			$this->user = new user($this->info['UserUID']);
		} else if (isset($this->info['GuildID'])){
			$this->guild = new guild($this->info['GuildID']);
		} else if (isset($this->info['MarketID'])){
			$this->auction	= new auction($this->info['MarketID']);
			$this->char		= new char($this->auction->getCharID());
			$this->user		= new user($this->char->getUserUID());
		}
			
		if (strlen($this->info['Craftname']) != 20)
			$this->info['Craftname'] = '00000000000000000000';
		
		$this->craftname = str_split($this->info['Craftname'], 2);
		$this->craftnameArr['Str']		= $this->craftname[0];
		$this->craftnameArr['Dex']		= $this->craftname[1];
		$this->craftnameArr['Rec']		= $this->craftname[2];
		$this->craftnameArr['Int']		= $this->craftname[3];
		$this->craftnameArr['Wis']		= $this->craftname[4];
		$this->craftnameArr['Luc']		= $this->craftname[5];
		$this->craftnameArr['HP']		= $this->craftname[6];
		$this->craftnameArr['MP']		= $this->craftname[7];
		$this->craftnameArr['SP']		= $this->craftname[8];
		$this->craftnameArr['Lapisa']	= $this->craftname[9];
		
		

		return true;
	}
	
	public function getDB(){
		return $this->db[$this->type];
	}
	
	public function getUID(){
		return $this->uid;
	}
	
	public function getCharID(){
		if (isset($this->info['CharID']))
			return $this->info['CharID'];
		else
			return false;
	}
	
	public function getUserUID(){
		return $this->user->getUserUID();
	}
	
	public function getGuildID(){
		return $this->guild->getGuildID();
	}
	
	public function getMarketID(){
		return $this->info['MarketID'];
	}
	
	public function getCharName(){
		return $this->char->getName();
	}
	
	public function getUserName(){
		return $this->user->getName();
	}
	
	public function getItemID(){
		return $this->info['ItemID'];
	}
	
	public function getItemName(){
		return Parser::SpecialChars($this->info['ItemName']);
	}
	
	public function getType(){
		return $this->info['Type'];
	}
	
	public function getTypeID(){
		return $this->info['TypeID'];
	}
	
	public function getBag(){
		if (isset($this->info['Bag']))
			return $this->info['Bag'];
		else
			return false;
	}
	
	public function getSlot(){
		if (isset($this->info['Slot']))
			return $this->info['Slot'];
		else
			return false;
	}
	
	public function getQuality(){
		return $this->info['Quality'];
	}
	
	public function getMaxQuality(){
		return $this->info['MaxQuality'];
	}
	
	public function getSlots(){
		return $this->info['MaxSlots'];
	}
	
	public function getLapis1(){
		return $this->info['Gem1'];
	}
	
	public function getLapis2(){
		return $this->info['Gem2'];
	}
	
	public function getLapis3(){
		return $this->info['Gem3'];
	}
	
	public function getLapis4(){
		return $this->info['Gem4'];
	}
	
	public function getLapis5(){
		return $this->info['Gem5'];
	}
	
	public function getLapis6(){
		return $this->info['Gem6'];
	}
	
	public function getStr(){
		return $this->craftnameArr['Str'];
	}
	
	public function getDex(){
		return $this->craftnameArr['Dex'];
	}
	
	public function getRec(){
		return $this->craftnameArr['Rec'];
	}
	
	public function getInt(){
		return $this->craftnameArr['Int'];
	}
	
	public function getWis(){
		return $this->craftnameArr['Wis'];
	}
	
	public function getLuc(){
		return $this->craftnameArr['Luc'];
	}
	
	public function getHP(){
		return $this->craftnameArr['HP'];
	}
	
	public function getMP(){
		return $this->craftnameArr['MP'];
	}
	
	public function getSP(){
		return $this->craftnameArr['SP'];
	}
	
	public function getLapisa(){
		if ($this->craftnameArr['Lapisa'] > 49)
			$this->craftnameArr['Lapisa'] = $this->craftnameArr['Lapisa'] - 50;
		
		return $this->craftnameArr['Lapisa'];
	}
	
	public function getCount(){
		return $this->info['Count'];
	}
	
	public function getTime(){
		return strtotime($this->info['Maketime']);
	}
	
	public function linkLapis($lapis, $slot){
		if (!Parser::gint($lapis))
			return 'The lapis ID must be an integer';
		
		if (!Parser::gint($slot))
			return 'Slot must be an intergrer';
		
		if ($lapis < 1)
			return 'The Lapis ID must be at least 1.';
		
		if ($lapis > 255)
			return 'The Lapis ID can not exceed 255.';
		
		if ($slot < 1)
			return 'The slot can not be less than 1.';
		
		if ($slot > 6)
			return 'The slot can not exceed 6.';
		
		$this->sql = $this->conn->prepare("UPDATE ".$this->getDB()." SET [Gem".$slot."] = '$lapis' WHERE [ItemUID] = '".$this->getUID()."'");
		$this->res = $this->sql->execute();
		
		return true;		
	}
	
	public function extractLapis($slot){
		if (!Parser::gint($slot))
			return 'The slot must be an intergret';
		
		if ($slot > 6)
			return 'The slot can not exceed 6.';
		
		$this->sql = $this->conn->prepare("UPDATE ".$this->getDB()." SET [Gem".$slot."] = 0 WHERE [ItemUID] = '".$this->getUID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	
	
	
	public function changeCraftname($stat, $value){
		if (!in_array($stat, $this->craftnameFields))
			return 'Falscher Attribut-Name';
		
		if (strlen($value) > 2)
			return 'Maximal 2 Zeichen möglich';
		
		if (!Parser::gint($value))
			return 'Nur Zahlen möglich';
		
		if (strlen($value) == 1)
			$value = '0'.$value;
			
		if (strlen($value) == 0)
			$value = '00';
		
		$this->craftname = '';
		
		
		foreach($this->craftnameFields as $this->foreachDummy){
			if ($this->foreachDummy != $stat)
				$this->craftname .= $this->craftnameArr[$this->foreachDummy];
			else
				$this->craftname .= $value;
		}
		
		
		if (strlen($this->craftname) != 20)
			return 'Da ist etwas schief gelaufen, wende dich bitte an Trayne & eQuiNox';
		
		$this->sql = $this->conn->prepare("UPDATE ".$this->getDB()." SET [CraftName] = '".$this->craftname."' WHERE [ItemUID] = '".$this->getUID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeCount($count){
		if (!Parser::gint($count))
			return 'Die Anzahl darf nur aus Nummern bestehen.';
		
		if ($count < 1)
			return 'Die Anzahl darf nicht kleiner als eins sein.';
		
		if ($count > 255)
			return 'Die Anzahl darf nicht größer als 255 sein.';
		
		$this->sql = $this->conn->prepare("UPDATE ".$this->getDB()." SET [Count] = '".$count."' WHERE [ItemUID] = '".$this->getUID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeQuality($halt){
		if (!Parser::gint($halt))
			return 'Die Haltbarkeit darf nur aus Nummern bestehen.';
		
		if ($halt < 0)
			return 'Die Haltbarkeit kann nicht kleiner als 0 sein.';
		
		if ($halt > $this->getMaxQuality())
			return 'Die Haltbarkeit kann nicht größer als die maximale Haltbarkeit sein.';
		
		$this->sql = $this->conn->prepare("UPDATE ".$this->getDB()." SET [Quality] = '$halt' WHERE [ItemUID] = '".$this->getUID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function delete(){
		$this->sql = $this->conn->prepare("DELETE FROM ".$this->getDB()." WHERE [ItemUID] = '".$this->getUID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function getLevel(){
		return $this->info['ReqLevel'];
	}

	
	
	
	
	
	
	
	
}