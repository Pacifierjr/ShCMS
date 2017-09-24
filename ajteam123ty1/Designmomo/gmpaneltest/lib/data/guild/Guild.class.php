<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

require_once('lib/data/Guild/GuildWarehouse.class.php');

class Guild{
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
	
	public function __construct($gid){
		$this->gid	= $gid;
		$this->sql	= "SELECT [g].[GuildName], [g].[GuildPoint], [g].[Country], [g].[TotalCount], [g].[CreateDate], [d].[Remark], [g].[MasterCharID], [g].[Del] FROM [PS_GameData].[dbo].[Guilds] AS [g]
					   INNER JOIN [PS_GameData].[dbo].[GuildDetails] AS [d] ON [d].[GuildID] = [g].[GuildID]
					   WHERE [g].[GuildID] = '$gid'";
		$this->res	= mssql_query($this->sql);
		$this->info = mssql_fetch_assoc($this->res);
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
		$this->sql	= "SELECT [CharID], [GuildLevel], [JoinDate] FROM [PS_GameData].[dbo].[GuildChars] WHERE [GuildID] = '".$this->gid."' AND [Del] = 0 ORDER BY [GuildLevel] ASC";
		$this->res	= mssql_query($this->sql);
		$this->i	= 0;
		
		if (mssql_num_rows($this->res) < 1)
			return false;
		
		while ($this->fet = mssql_fetch_array($this->res)){
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
		$this->sql = "UPDATE [PS_GameData].[dbo].[GuildDetails] SET [Remark] = '".Parser::validate($notiz)."' WHERE [GuildID] = '".$this->gid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return 'Erreur dans l instruction SQL';
	}
	
	public function changeLeader($name){
		$this->newcharID		= CharID::byName($name);
		
		if (!Parser::gint($this->newcharID))
			return $this->newcharID;
		
		$this->newLeader		= new char($this->newcharID);
		$this->newLeaderUser	= new user($this->newLeader->getUserUID());
		
		if ($this->newLeader->getGuild() != $this->getGuildID())
			return 'Le nouveau chef doit être déjà dans la guilde.';
		
		if ($this->newLeader->getDel())
			return 'Le nouveau chef est mort.';
		
		if ($this->newLeader->isBanned())
			return 'Le nouveau chef est interdit.';
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[Guilds] SET [MasterUserID] = '".Parser::validate($this->newLeaderUser->getName())."', [MasterCharID] = '".$this->newcharID."', [MasterName] = '".Parser::validate($this->newLeader->getName())."' WHERE [GuildID] = '".$this->gid."'";
		$this->res = mssql_query($this->sql);
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[GuildChars] SET [GuildLevel] = 2 WHERE [CharID] = '".$this->getMasterCharID()."' AND [GuildID] = '".$this->gid."' AND [Del] = 0";
		$this->res = mssql_query($this->sql);
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[GuildChars] SET [GuildLevel] = 1 WHERE [CharID] = '".$this->newcharID."' AND [GuildID] = '".$this->gid."' AND [Del] = 0";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function changeName($name){
		$this->sql = "UPDATE [PS_GameData].[dbo].[Guilds] SET [GuildName] = '".Parser::validate($name)."' WHERE [GuildID] = '".$this->gid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return 'Erreur dans l instruction SQL';
	}
	
	public function changePoint($point){
		if (!Parser::gint($point))
			return 'S il vous plaît saisir uniquement des chiffres.';
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[Guilds] SET [GuildPoint] = '".$point."' WHERE [GuildID] = '".$this->getGuildID()."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function delete(){
		$this->sql = "EXEC [PS_GameData].[dbo].[usp_Delete_Guild_E] @GuildID = '".$this->getGuildID()."'";
		$this->res = mssql_query($this->sql);
		
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