<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class CharID{
	private static $sql;
	private static $res;
	private static $fet;
	private static $conn;

	public static function byName($name){
		self::$conn = dbConn::getConnection();
		self::$sql = self::$conn->prepare("SELECT [CharID] FROM [PS_GameData].[dbo].[Chars] WHERE [CharName] = '".Parser::validate($name)."'");
		self::$sql->execute();
		self::$fet = self::$sql->fetch(PDO::FETCH_BOTH);
		
		if (self::$sql->rowCount() == 1)
			return self::$fet[0];
		
		if (self::$sql->rowCount() < 1)
			return 'Character not found.';
		
		self::$sql = self::$conn->prepare("SELCT [CharID] FROM [PS_GameData].[dbo].[Chars] WHERE [CharName] = '".Parser::validate($name)."'' AND [Del] = 0");
		self::$sql->execute();
		
		if (self::$sql->rowCount() < 1)
			return self::$fet[0];
		
		self::$fet = self::$sql->fetch(PDO::FETCH_BOTH);
		return self::$fet[0];			
	}
}


?>