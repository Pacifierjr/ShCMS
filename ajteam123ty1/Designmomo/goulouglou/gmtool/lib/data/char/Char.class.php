<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

require_once (INC_DIR.'lib/data/char/CharItems.class.php');

class Char{
	private $charid;
	private $sql;
	private $res;
	private $fet;
	private $info;
	private $user;
	private $i;
	private $klassen;
	private $modus;
	private $rassen;
	private $retArray;
	
	public function __construct($charid){
		$this->charid	= $charid;
		$this->sql = "SELECT * FROM [PS_GameData].[dbo].[Chars] WHERE [CharID] = '$charid'";
		$this->res		= mssql_query($this->sql);
		$this->info		= mssql_fetch_assoc($this->res);
		$this->user		= new user($this->info['UserUID']);
		$this->klassen	= array(0 => 'Warrior', 1 => 'Gardien', 2 => 'Assasin', 3 => 'Hunt', 4 => 'Ani', 5 => 'Oracle',
								6 => 'Figther', 7 => 'Def', 8 => 'Ranger', 9 => 'Archer', 10 => 'Mage', 11 => 'Priest');
		$this->modus	= array(0 => 'Facil', 1 => 'Normal', 2 => 'Hard', 3 => 'UM');
		$this->rassen	= array(0 => 'Humain', 1 => 'Elf', 2 => 'Vail', 3 => 'Deatheader');
	}
	
	public function getCharID(){
		return $this->charid;
	}
	
	public function getUserUID(){
		return $this->info['UserUID'];
	}
	
	public function getName(){
		return Parser::specialChars($this->info['CharName']);
	}
	
	public function getDel(){
		if ($this->info['Del'] == 0)
			return false;
		else
			return true;
	}
	
	public function getSlot(){
		return $this->info['Slot'];
	}
	
	public function getFamily(){
		return $this->info['Family'];
	}
	
	public function getGrow(){
		return $this->info['Grow'];
	}
	
	public function getHair(){
		return $this->info['Hair'];
	}
	
	public function getFace(){
		return $this->info['Face'];
	}
	
	public function getSize(){
		return $this->info['Size'];
	}
	
	public function getJob(){
		return $this->info['Job'];
	}
	
	public function getSex(){
		return $this->info['Sex'];
	}
	
	public function getLevel(){
		return $this->info['Level'];
	}
	
	public function getStatPoint(){
		return $this->info['StatPoint'];
	}
	
	public function getSkillPoint(){
		return $this->info['SkillPoint'];
	}
	
	public function getStr(){
		return $this->info['Str'];
	}
	
	public function getDex(){
		return $this->info['Dex'];
	}
	
	public function getRec(){
		return $this->info['Rec'];
	}
	
	public function getInt(){
		return $this->info['Int'];
	}
	
	public function getLuc(){
		return $this->info['Luc'];
	}
	
	public function getWis(){
		return $this->info['Wis'];
	}
	
	public function getHP(){
		return $this->info['HP'];
	}
	
	public function getMP(){
		return $this->info['MP'];
	}
	
	public function getSP(){
		return $this->info['SP'];
	}
	
	public function getMap(){
		return $this->info['Map'];
	}
	
	public function getExp(){
		return $this->info['Exp'];
	}
	
	public function getPosX(){
		return $this->info['PosX'];
	}
	
	public function getPosY(){
		return $this->info['PosY'];
	}
	
	public function getPosZ(){
		return $this->info['Posz'];
	}
	
	public function getKills(){
		return $this->info['K1'];
	}
	
	public function getTode(){
		return $this->info['K2'];
	}
	
	public function getDKills(){
		return $this->info['K3'];
	}
	
	public function getDTode(){
		return $this->info['K4'];
	}
	
	public function getKillLevel(){
		return $this->info['KillLevel'];
	}
	
	public function getDeadLevel(){
		return $this->info['DeadLevel'];
	}
	
	public function getRenameCnt(){
		return $this->info['RenameCnt'];
	}
	
	public function getOldCharName(){
		return $this->info['OldCharName'];
	}
	
	public function getLastLogin(){
		return strtotime($this->info['JoinDate']);
	}
	
	public function getLastLogout(){
		return strtotime($this->info['LeaveDate']);
	}
	
	public function getLastLoginTime(){
		return $this->getLastLogout() - $this->getLastLogin();
	}
	
	public function getLoginStatus(){
		return $this->info['Loginstatus'];
	}
	
	public function getGuild(){
		$this->sql = "SELECT [GuildID] FROM [PS_GameData].[dbo].[GuildChars] WHERE [CharID] = '".$this->charid."' AND [Del] = 0";
		$this->res = mssql_query($this->sql);
		
		if (mssql_num_rows($this->res) != 1)
			return false;
			
		$this->fet = mssql_fetch_array($this->res);
		return $this->fet[0];
	}
	
	public function getClassName(){
		if ($this->getFamily() < 2)
			return $this->klassen[$this->getJob() + 6];
		else
			return $this->klassen[$this->getJob()];
	}
	
	public function getModeName(){
		return $this->modus[$this->getGrow()];
	}
	
	public function getRaceName(){
		return $this->rassen[$this->getFamily()];
	}
	
	public function isBanned(){
		return $this->user->isBanned();
	}
	
	public function ban(){
		$this->user->ban();
	}
	
	public function unban(){
		$this->user->unban();
	}
	
	public function getFriends(){
		$this->sql = "SELECT [FriendID] FROM [PS_GameData].[dbo].[FriendChars] WHERE [CharID] = '".$this->getCharID()."'";
		$this->res = mssql_query($this->sql);
		
		if (mssql_num_rows($this->res) == 0)
			return false;
		
		$this->count = 0;
		
		while ($this->fet = mssql_fetch_array($this->res)){
			$this->retArray[$this->count] = $this->fet[0];
			$this->count++;
		}
		
		return $this->retArray;
	}
	
	public function kill(){
		if ($this->getLoginStatus())
			return 'Le personnage est actuellement connecté.';
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [Del] = 1 WHERE [CharID] = '".$this->charid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return 'Erreur dans l instruction SQL';
	}
	
	public function res(){
		if (!$this->getDel())
			return 'Ce personnage n est pas mort';
		
		for ($this->i = 0; $this->i < 6; $this->i++){
			$this->sql = "SELECT [CharID] FROM [PS_GameData].[dbo].[Chars] WHERE [UserUID] = '".$this->getUserUID()."' AND [Slot] = '".$this->i."' AND [Del] = 0";
			$this->res = mssql_query($this->sql);
			
			if (mssql_num_rows($this->res) == 0)
				break;
		}
			
		if ($this->i == 5)
			return 'Kein Slot frei.';
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [Del] = 0, [Slot] = '".$this->i."', [Map] = 42, [PosX] = 63, [PosZ] = 57, [DeleteDate] = NULL WHERE [CharID] = '".$this->charid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return 'Erreur dans l instruction SQ';
	}
	
	public function resetKills(){
		if ($this->getLoginStatus())
			return 'Le personnage est actuellement connec.';
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [k1] = 0, [k2] = 0, [k3] = 0, [k4] = 0 WHERE [CharID] = '".$this->charid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return 1;
		else
			return 'Erreur dans l instruction SQ';		
	}
	
	public function changeName($name){
		if ($this->getLoginStatus())
			return 'Le personnage est actuellement connec.';
		
		if (strlen($name) < 1)
			return 'Le nom est trop court.';
		
		$this->sql = "SELECT [CharID] FROM [PS_GameData].[dbo].[Chars] WHERE [CharName] = '".Parser::validate($name)."' AND [Del] = 0";
		$this->res = mssql_query($this->sql);
		
		if (mssql_num_rows($this->res) != 0)
			return 'Le nom est un glorifié attribué';
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [CharName] = '".Parser::validate($name)."' WHERE [CharID] = '".$this->charid."'";
		$this->res = mssql_query($this->sql);
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[Guilds] SET [MasterName] = '".Parser::validate($name)."' WHERE [MasterCharID] = '".$this->charid."'";
		$this->res = mssql_query($this->sql);
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[FriendChars] SET [FriendName] = '".Parser::validate($name)."' WHERE [FriendID] = '".$this->charid."'";
		$this->res = mssql_query($this->sql);
		
		$this->sql = "UPDATE [PS_GameData].[dbo].[BanChars] SET [BanName] = '".Parser::validate($name)."' WHERE [BanID] = '".$this->charid."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function changeLevel($level){
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [Level] = '".Parser::validate($level)."' WHERE [CharID] = '".$this->getCharID()."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function changeGrow($grow){
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [Grow] = '".Parser::validate($grow)."' WHERE [CharID] = '".$this->getCharID()."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function changeSex($sex){
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [Sex] = '".Parser::validate($sex)."' WHERE [CharID] = '".$this->getCharID()."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function changeStat($statpoint){
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [statpoint] = '".Parser::validate($statpoint)."' WHERE [CharID] = '".$this->getCharID()."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function changeSkill($skillpoint){
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [skillpoint] = '".Parser::validate($skillpoint)."' WHERE [CharID] = '".$this->getCharID()."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function changeKill($kills){
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [k1] = '".Parser::validate($kills)."' WHERE [CharID] = '".$this->getCharID()."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function changeTod($tod){
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [k2] = '".Parser::validate($tod)."' WHERE [CharID] = '".$this->getCharID()."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function changeDKill($kills){
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [k3] = '".Parser::validate($kills)."' WHERE [CharID] = '".$this->getCharID()."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function changeDTod($tod){
		$this->sql = "UPDATE [PS_GameData].[dbo].[Chars] SET [k4] = '".Parser::validate($tod)."' WHERE [CharID] = '".$this->getCharID()."'";
		$this->res = mssql_query($this->sql);
		
		return true;
	}
	
	public function leaveGuild(){
		$this->sql = "UPDATE [PS_GameData].[dbo].[GuildChars] SET [Del] = 1 WHERE [CharID] = '".$this->getCharID()."' AND [Del] = 0";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return 'Erreur dans l instruction SQL';	
	}
	
	public function createCI(){
		$this->ci = new CharItems($this->charid);
		return true;
	}
	
	public function leseCI(){
		if (!$this->ciExists())
			$this->createCI();
		
		return $this->ci->readItems();
	}
	
	public function CIslot($slot){
		if (!$this->ciExists())
			$this->createCI();
		
		return $this->ci->getItemOnSlot($slot);
	}
	
	public function delCIslot($slot){
		if (!$this->ciExists())
			$this->createCI();
		
		return $this->ci->deleteItemOnSlot($slot);
	}
	
	public function delCIall(){
		if (!$this->ciExists())
			$this->createCI();
		
		return $this->ci->deleteAll();
	}
	
	private function ciExists(){
		if (isset($this->ci))
			return true;
		else
			return false;
	}
}

?>