<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

require_once (INC_DIR.'lib/data/char/CharItems.Class.php');

Class Char{
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
	private $conn;
	public function __construct($charid){
		$this->charid	= $charid;
		$this->conn = dbConn::getConnection();
		$this->sql = $this->conn->prepare("SELECT * FROM [PS_GameData].[dbo].[Chars] WHERE [CharID] = ?");
		$this->sql->bindParam(1, $this->charid, PDO::PARAM_INT);
		$this->res		= $this->sql->execute();
		$this->info		= $this->sql->fetch(PDO::FETCH_BOTH);
		$this->user		= new user($this->info['UserUID']);
		$this->klassen	= array(0 => 'Fighter', 1 => 'Defender', 2 => 'Ranger', 3 => 'Archer', 4 => 'Mage', 5 => 'Priest',
								6 => 'Warrior', 7 => 'Guardian', 8 => 'Assassin', 9 => 'Hunter', 10 => 'Animist', 11 => 'Oracle');
		$this->modus	= array(0 => 'Easy', 1 => 'Normal', 2 => 'Hard', 3 => 'Ultimate');
		$this->rassen	= array(0 => 'Human', 1 => 'Elf', 2 => 'Vail', 3 => 'Death Eaters');
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
		return $this->info['LoginStatus'];
	}
	
	public function getGuild(){
		$this->sql = $this->conn->prepare("SELECT [GuildID] FROM [PS_GameData].[dbo].[GuildChars] WHERE [CharID] = ? AND [Del] = 0");
		$this->res = $this->sql->execute();
		
		if ($this->sql->rowCount() != 1)
			return false;
			
		$this->fet = $this->sql->fetch(PDO::FETCH_BOTH);
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
		$this->sql = $this->conn->prepare("SELECT [FriendID] FROM [PS_GameData].[dbo].[FriendChars] WHERE [CharID] = ?");
		$this->sql->bindParam(1, $this->getCharID(), PDO::PARAM_INT);
		$this->res = $this->sql->execute();
		
		if ($this->sql->rowCount() == 0)
			return false;
		
		$this->count = 0;
		
		while ($this->fet = $this->sql->fetch(PDO::FETCH_BOTH)){
			$this->retArray[$this->count] = $this->fet[0];
			$this->count++;
		}
		
		return $this->retArray;
	}
	
	public function kill(){
		if ($this->getLoginStatus())
			return 'The character is currently logged in.';
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [Del] = 1 WHERE [CharID] = ?");
		$this->sql->bindParam(1, $this->charid, PDO::PARAM_INT);
		$this->res = $this->sql->execute();
		
		if ($this->res)
			return true;
		else
			return 'Error in the SQL query';
	}
	
	public function res(){
		if (!$this->getDel())
			return 'This character is not death.';
		
		for ($this->i = 0; $this->i < 6; $this->i++){
			$this->sql = $this->conn->prepare("SELECT [CharID] FROM [PS_GameData].[dbo].[Chars] WHERE [UserUID] = ? AND [Slot] = ? AND [Del] = 0");
			$this->sql->bindParam(1, $this->getUserUID(), PDO::PARAM_INT);
			$this->sql->bindParam(2, $this->i, PDO::PARAM_INT);
			$this->res = $this->sql->execute();
			
			if ($this->sql->rowCount() == 0)
				break;
		}
			
		if ($this->i == 5)
			return 'No free slot.';
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [Del] = 0, [Slot] = ?, [Map] = 42, [PosX] = 63, [PosZ] = 57, [DeleteDate] = NULL WHERE [CharID] = ?");
		$this->sql->bindParam(1, $this->i, PDO::PARAM_INT);
		$this->sql->bindParam(2, $this->charid, PDO::PARAM_INT);
		$this->res = $this->sql->execute();
		
		if ($this->res)
			return true;
		else
			return 'Error in the SQL query';
	}
	
	public function resetKills(){
		if ($this->getLoginStatus())
			return 'The character is currently logged in.';
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [k1] = 0, [k2] = 0, [k3] = 0, [k4] = 0 WHERE [CharID] = ?");
		$this->sql->bindParam(1, $this->charid, PDO::PARAM_INT);
		$this->res = $this->sql->execute();
		
		if ($this->res)
			return 1;
		else
			return 'Error in the SQL query';
	}
	
	public function changeName($name){
		if ($this->getLoginStatus())
			return 'The character is currently logged in.';
		
		if (strlen($name) < 1)
			return 'The name is too small.';
		
		$this->sql = $this->conn->prepare("SELECT [CharID] FROM [PS_GameData].[dbo].[Chars] WHERE [CharName] = '".Parser::validate($name)."' AND [Del] = 0");
		$this->res = $this->sql->execute();
		
		if ($this->sql->rowCount() != 0)
			return 'The name is already in use';
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [CharName] = '".Parser::validate($name)."' WHERE [CharID] = '".$this->charid."'");
		$this->res = $this->sql->execute();
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Guilds] SET [MasterName] = '".Parser::validate($name)."' WHERE [MasterCharID] = '".$this->charid."'");
		$this->res = $this->sql->execute();
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[FriendChars] SET [FriendName] = '".Parser::validate($name)."' WHERE [FriendID] = '".$this->charid."'");
		$this->res = $this->sql->execute();
		
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[BanChars] SET [BanName] = '".Parser::validate($name)."' WHERE [BanID] = '".$this->charid."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeLevel($level){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [Level] = '".Parser::validate($level)."' WHERE [CharID] = '".$this->getCharID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeGrow($grow){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [Grow] = '".Parser::validate($grow)."' WHERE [CharID] = '".$this->getCharID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeSex($sex){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [Sex] = '".Parser::validate($sex)."' WHERE [CharID] = '".$this->getCharID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeStat($statpoint){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [statpoint] = '".Parser::validate($statpoint)."' WHERE [CharID] = '".$this->getCharID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeSkill($skillpoint){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [skillpoint] = '".Parser::validate($skillpoint)."' WHERE [CharID] = '".$this->getCharID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeKill($kills){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [k1] = '".Parser::validate($kills)."' WHERE [CharID] = '".$this->getCharID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeTod($tod){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [k2] = '".Parser::validate($tod)."' WHERE [CharID] = '".$this->getCharID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeDKill($kills){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [k3] = '".Parser::validate($kills)."' WHERE [CharID] = '".$this->getCharID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function changeDTod($tod){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[Chars] SET [k4] = '".Parser::validate($tod)."' WHERE [CharID] = '".$this->getCharID()."'");
		$this->res = $this->sql->execute();
		
		return true;
	}
	
	public function leaveGuild(){
		$this->sql = $this->conn->prepare("UPDATE [PS_GameData].[dbo].[GuildChars] SET [Del] = 1 WHERE [CharID] = '".$this->getCharID()."' AND [Del] = 0");
		$this->res = $this->sql->execute();
		
		if ($this->res)
			return true;
		else
			return 'Error in the SQL query';	
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