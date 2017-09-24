<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class Count{
	private static $sql;
	private static $res;
	private static $fet;
	private static $conn;

	public static function Chars(){
		self::$conn = dbConn::getConnection();
		self::$sql = self::$conn->prepare("SELECT Count([CharID]) FROM [PS_GameData].[dbo].[Chars]");
		self::$sql->execute();
		self::$fet = self::$sql->fetch(PDO::FETCH_BOTH);
		
		return self::$fet[0];
	}
	
	public static function Accounts(){
		self::$conn = dbConn::getConnection();
		self::$sql = self::$conn->prepare("SELECT Count([UserUID]) FROM [PS_UserData].[dbo].[Users_Master]");
		self::$sql->execute();
		self::$fet = self::$sql->fetch(PDO::FETCH_BOTH);
		
		return self::$fet[0];
	}
	
	public static function BannedChars(){
		self::$conn = dbConn::getConnection();
		self::$sql = self::$conn->prepare("SELECT Count([c].[CharID]) FROM [PS_GameData].[dbo].[Chars] AS [c]
					  INNER JOIN [PS_UserData].[dbo].[Users_Master] AS [um] ON [um].[UserUID] = [c].[UserUID]
					  WHERE [um].[Status] = -5");
		self::$sql->execute();
		self::$fet = self::$sql->fetch(PDO::FETCH_BOTH);
		
		return self::$fet[0];
	}
	
	public static function BannedAccounts(){
		self::$conn = dbConn::getConnection();
		self::$sql = self::$conn->prepare("SELECT Count([UserUID]) FROM [PS_UserData].[dbo].[Users_Master] WHERE [Status] = -5");
		self::$sql->execute();
		self::$fet = self::$sql->fetch(PDO::FETCH_BOTH);
		
		return self::$fet[0];
	}
	
	public static function DeletedChars(){
		self::$conn = dbConn::getConnection();
		self::$sql = self::$conn->prepare("SELECT Count([CharID]) FROM [PS_GameData].[dbo].[Chars] WHERE [Del] = 1");
		self::$sql->execute();
		self::$fet = self::$sql->fetch(PDO::FETCH_BOTH);
		
		return self::$fet[0];
	}
}


?>