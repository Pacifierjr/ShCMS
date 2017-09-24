<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class Count{
	private static $sql;
	private static $res;
	private static $fet;
	
	public static function Chars(){
		self::$sql = "SELECT Count([CharID]) FROM [PS_GameData].[dbo].[Chars]";
		self::$res = mssql_query(self::$sql);
		self::$fet = mssql_fetch_array(self::$res);
		
		return self::$fet[0];
	}
	
	public static function Accounts(){
		self::$sql = "SELECT Count([UserUID]) FROM [PS_UserData].[dbo].[Users_Master]";
		self::$res = mssql_query(self::$sql);
		self::$fet = mssql_fetch_array(self::$res);
		
		return self::$fet[0];
	}
	
	public static function BannedChars(){
		self::$sql = "SELECT Count([c].[CharID]) FROM [PS_GameData].[dbo].[Chars] AS [c]
					  INNER JOIN [PS_UserData].[dbo].[Users_Master] AS [um] ON [um].[UserUID] = [c].[UserUID]
					  WHERE [um].[Status] = -5";
		self::$res = mssql_query(self::$sql);
		self::$fet = mssql_fetch_array(self::$res);
		
		return self::$fet[0];
	}
	
	public static function BannedAccounts(){
		self::$sql = "SELECT Count([UserUID]) FROM [PS_UserData].[dbo].[Users_Master] WHERE [Status] = -5";
		self::$res = mssql_query(self::$sql);
		self::$fet = mssql_fetch_array(self::$res);
		
		return self::$fet[0];
	}
	
	public static function DeletedChars(){
		self::$sql = "SELECT Count([CharID]) FROM [PS_GameData].[dbo].[Chars] WHERE [Del] = 1";
		self::$res = mssql_query(self::$sql);
		self::$fet = mssql_fetch_array(self::$res);
		
		return self::$fet[0];
	}
}


?>