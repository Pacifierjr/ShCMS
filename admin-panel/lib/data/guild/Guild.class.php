<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

require_once('lib/data/Guild/GuildWarehouse.Class.php');

Class Guild{
	private $gid;
	private $sql;
	private $res;
	private $fet;
	private $info;
	private $i;
	private $charArray;
	private $newcharID;
	private $newLeader;
	private $newLeaderUser;
	private $warehouse;
	private $conn;
	
	public function __construct($gid){
		$this->conn = dbConn::getConnection();
		$this->gid	= $gid;
		$this->sql	= $this->conn->prepare("SELECT [g].[GuildName], [g].[GuildPoint], [g].[Country], [g].[TotalCount], [g].[CreateDate], [d].[Remark], [g].[MasterCharID], [g].[Del] FROM [PS_GameData].[dbo].[Guilds] AS [g]
					   INNER JOIN [PS_GameData].[dbo].[GuildDetails] AS [d] ON [d].[GuildID] = [g].[GuildID]
					   WHERE [g].[GuildID] = '$gid'");
		$this->sql->execute();
		$this->info = $this->sql->fetch(PDO::FETCH_BOTH);
	}
	
	public function getGuildID(){
		return $this->gid;
	}
	
	public function getName(){
		return Parser::specialChars($this->info['GuildName']);
	}
	
	public function getGuildPoint(){
		return $this->info['GuildPoint'];
	}
	
	public function getCountry(){
		return $this->info['Country'];
	}
	
	public function getMitgliederZahl(){
		return $this->info['TotalCount'];
	}
	
	public function getCreateDatum(){
		return strtotime($this->info['CreateDate']);
	}
	
	public function getRemark(){
		return Parser::specialChars($this->info['Remark']);
	}
	
	public function getMasterCharID(){
		return $this->info['MasterCharID'];
	}

	public function getMitglieder(){
		$this->sql	= $this->conn->prepare("SELECT [CharID], [GuildLevel], [JoinDate] FROM [PS_GameData].[dbo].[GuildChars] WHERE [GuildID] = '".$this->gid."' AND [Del] = 0 ORDER BY [GuildLevel] ASC");
		$this->sql->execute();
		$this->i	= 0;
		
		if ($this->sql->rowCount() < 1)
			return false;
		
		while ($this->fet = $this->sql->fetch(PDO::FETCH_BOTH)){
			$this->charArray[$this->i]['CharID']		= $this->fet[0];
			$this->charArray[$this->i]['GuildLevel']	= $this->fet[1];
			$this->charArray[$this->i]['JoinDate']	= strtotime($this->fet[2]);
			$this->i++;
		}
		
		return $this->charArray;		
	}
	
	public function getDel(){
		return $this->info['Del'];
	}
	
	public function changeNotiz($notiz){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[GuildDetails] SET [Remark] = '".Parser::validate($notiz)."' WHERE [GuildID] = '".$this->gid."'");
		$this->res = $this->sql->execute();
		
		if ($this->res)
			return true;
		else
			return 'Error in the SQL query';
	}
	
	public function changeLeader($name){
		$this->newcharID		= CharID::byName($name);
		
		if (!Parser::gint($this->newcharID))
			return $this->newcharID;
		
		$this->newLeader		= new char($this->newcharID);
		$this->newLeaderUser	= new user($this->newLeader->getUserUID());
		
		if ($this->newLeader->getGuild() != $this->getGuildID())
			return 'The new leader must member of the guild.';
		
		if ($this->newLeader->getDel())
			return 'The new leader is dead.';
		
		if ($this->newLeader->isBanned())
			return 'The new leader is banned.';
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Guilds] SET [MasterUserID] = '".Parser::validate($this->newLeaderUser->getName())."', [MasterCharID] = '".$this->newcharID."', [MasterName] = '".Parser::validate($this->newLeader->getName())."' WHERE [GuildID] = '".$this->gid."'");
		$this->res = $this->sql->execute();
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[GuildChars] SET [GuildLevel] = 2 WHERE [CharID] = '".$this->getMasterCharID()."' AND [GuildID] = '".$this->gid."' AND [Del] = 0");
		$this->res = $this->sql->execute();
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[GuildChars] SET [GuildLevel] = 1 WHERE [CharID] = '".$this->newcharID."' AND [GuildID] = '".$this->gid."' AND [Del] = 0");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeName($name){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Guilds] SET [GuildName] = '".Parser::validate($name)."' WHERE [GuildID] = '".$this->gid."'");
		$this->res = $this->sql->execute();
		
		if ($this->res)
			return true;
		else
			return 'Error in the SQL query';
	}
	
	public function changePoint($point){
		if (!Parser::gint($point))
			return 'Please put a number.';
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Guilds] SET [GuildPoint] = '".$point."' WHERE [GuildID] = '".$this->getGuildID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function delete(){
		$this->sql = $this->conn->prepare("EXEC [PS_GameData].[dbo].[usp_Delete_Guild_E] @GuildID = '".$this->getGuildID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function createWH(){
		$this->warehouse = new GuildWarehouse($this->getGuildID());
	}
	
	public function WHexists(){
		if (isset($this->warehouse))
			return true;
		else
			return false;
	}
	
	public function readWH(){
		if (!$this->WHexists())
			$this->createWH();
		
		return $this->warehouse->readItems();
	}
	
	public function WHslot($slot){
		if (!$this->WHexists())
			$this->createWH();
		
		return $this->warehouse->getItemOnSlot($slot);
	}
	
	public function delWHslot($slot){
		if (!$this->WHexists())
			$this->createWH();
		
		return $this->warehouse->deleteItemOnSlot($slot);
	}
	
	public function delWHall(){
		if (!$this->WHexists())
			$this->createWH();
		
		return $this->warehouse->deleteAll($slot);
	}
}


?>