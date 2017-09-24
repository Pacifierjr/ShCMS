<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

require_once (INC_DIR.'lib/data/user/UserStoredItems.class.php');

class User{
	private $uuid;
	private $info;
	private $sql;
	private $res;
	private $fet;
	private $usi;
	private $retArray;
	private $count;
	
	public function __construct($uuid){
		$this->uuid	= $uuid;
		$this->sql	= "SELECT * FROM [PS_UserData].[dbo].[Users_Master] WHERE [UserUID] = '$uuid'";
		$this->res	= mssql_query($this->sql);
		
		$this->fet	= mssql_fetch_assoc($this->res);
		$this->info = $this->fet;
	}
	
	public function getUserUID(){
		return $this->uuid;
	}
	
	public function getName(){
		return Parser::specialChars($this->info['UserID']);
	}
	
	public function getPw(){
		return $this->info['Pw'];
	}
	
	public function getLastLogin(){
		return strtotime($this->info['JoinDate']);
	}
	
	public function getLeave(){
		return $this->info['Leave'];
	}
	
	public function getIp(){
		return $this->info['UserIp'];
	}
	
	public function getPoint(){
		return $this->info['Point'];
	}
	
	public function getStatus(){
		return $this->info['Status'];
	}
	
	public function getChars(){
		$this->sql = "SELECT [CharID] FROM [PS_GameData].[dbo].[Chars] WHERE [UserUID] = '".$this->getUserUID()."'";
		$this->res = mssql_query($this->sql);
		
		if (mssql_num_rows($this->res) < 1)
			return false;
		
		$this->count 	= 0;
		$this->retArray = NULL;
		
		while ($this->fet = mssql_fetch_array($this->res)){
			$this->retArray[$this->count] = $this->fet[0];
			$this->count++;
		}
		
		return $this->retArray;
	}
	
	public function getFraktion(){
		$this->sql = "SELECT [Country] FROM [PS_GameData].[dbo].[UserMaxGrow] WHERE [UserUID] = '".$this->getUserUID()."'";
		$this->res = mssql_query($this->sql);
		$this->fet = mssql_fetch_array($this->res);
		
		return $this->fet[0];
	}
	
	public function isAdm(){
		if ($this->info['Status'] == 16 && $this->info['Admin'] == 1 && $this->info['AdminLevel'] == 255)
			return true;
		else
			return false;
	}
	
	public function isGm(){
		if ($this->info['Status'] > 15 && $this->info['Admin'] == 1 && $this->info['AdminLevel'] == 255)
			return true;
		else
			return false;
	}
	
	public function isBanned(){
		if ($this->info['Status'] == -5)
			return true;
		else
			return false;
	}
	
	public function ban(){
		if ($this->isBanned())
			return true;
		
		$this->sql = "UPDATE [PS_UserData].[dbo].[Users_Master] SET [Status] = -5 WHERE [UserUID] = '".$this->uuid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return false;
	}
	
	public function unban(){
		if (!$this->isBanned())
			return true;
		
		$this->sql = "UPDATE [PS_UserData].[dbo].[Users_Master] SET [Status] = 0 WHERE [UserUID] = '".$this->uuid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return false;
	}
	
	public function changePw($password){
		if (strlen($password) < 1)
			return 'S il vous plaît fournir des informations détaillées';
		
		$this->sql = "UPDATE [PS_UserData].[dbo].[Users_Master] SET [Pw] = '".Parser::validate($password)."' WHERE [UserUID] = '".$this->getUserUID()."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return false;
	}
	
	public function makeAdm(){
		if ($this->isAdm())
			return true;
		
		$this->sql = "UPDATE [PS_UserData].[dbo].[Users_Master] SET [Status] = 16, [Admin] = 1, [AdminLevel] = 255 WHERE [UserUID] = '".$this->uuid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return false;		
	}
	
	public function makeGM($status){
		if (!Parser::gint($status))
			throw new SystemException('Statut doit être de type entier.', 0, 0, __FILE__, __LINE__);
		
		$this->sql = "UPDATE [PS_UserData].[dbo].[Users_Master] SET [Status] = $status, [Admin] = 1, [AdminLevel] = 255 WHERE [UserUID] = '".$this->uuid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return false;
	}
	
	public function giveAp($ap){
		if (!Parser::gint($ap))
			throw new SystemException('Ap doit être de type entier.', 0, 0, __FILE__, __LINE__);
		
		$this->sql = "UPDATE [PS_UserData].[dbo].[Users_Master] SET [Point] = (Point + $ap) WHERE [UserUID] = '".$this->uuid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return false;
	}
	
	public function takeAp($ap){
		if (!Parser::gint($ap))
			throw new SystemException('Ap doit être de type entier.', 0, 0, __FILE__, __LINE__);
		
		if ($ap > $this->getPoint())
			return 'Pas assez d AP disponible';
		
		$this->sql = "UPDATE [PS_UserData].[dbo].[Users_Master] SET [Point] = (Point - $ap) WHERE [UserUID] = '".$this->uuid."'";
		$this->res = mssql_query($this->sql);
		
		if ($this->res)
			return true;
		else
			return false;
	}
	
	public function createWL(){
		$this->usi = new UserStoredItems($this->uuid);
		return true;
	}
	
	public function leseWL(){
		if (!$this->usiExists())
			$this->createWL();
		
		return $this->usi->readItems();
	}
	
	public function WLslot($slot){
		if (!$this->usiExists())
			$this->createWL();
		
		return $this->usi->getItemOnSlot($slot);
	}
	
	public function delWLslot($slot){
		if (!$this->usiExists())
			$this->createWL();
		
		return $this->usi->deleteItemOnSlot($slot);
	}
	
	public function delWLall(){
		if (!$this->usiExists())
			$this->createWL();
		
		return $this->usi->deleteAll();
	}
	
	private function usiExists(){
		if (isset($this->usi))
			return true;
		else
			return false;
	}
	
	public function getLastLogins(){
		$this->sql = "SELECT top 10 [IP], [Zeit] FROM [PS_UserData].[dbo].[GMTool_LoginLog] WHERE [UserUID] = '".$this->getUserUID()."' ORDER BY [Zeit] DESC";
		$this->res = mssql_query($this->sql);
		
		if (mssql_num_rows($this->res) < 1)
			return false;
		
		$this->count 	= 0;
		$this->retArray = NULL;
		
		while ($this->fet = mssql_fetch_array($this->res)){
			$this->retArray[$this->count]['IP']		= $this->fet[0];
			$this->retArray[$this->count]['Zeit']	= strtotime($this->fet[1]);
			
			$this->count++;
		}
		
		return $this->retArray;
	}
}

?>