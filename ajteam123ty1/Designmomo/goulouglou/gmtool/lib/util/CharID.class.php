<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class CharID{
	private static $sql;
	private static $res;
	private static $fet;
	
	public static function byName($name){
		self::$sql = "SELECT [CharID] FROM [PS_GameData].[dbo].[Chars] WHERE [CharName] = '".Parser::validate($name)."'";
		self::$res = mssql_query(self::$sql);
		self::$fet = mssql_fetch_array(self::$res);
		
		if (mssql_num_rows(self::$res) == 1)
			return self::$fet[0];
		
		if (mssql_num_rows(self::$res) < 1)
			return 'Charakter nicht gefunden.';
		
		self::$sql = "SELCT [CharID] FROM [PS_GameData].[dbo].[Chars] WHERE [CharName] = '".Parser::validate($name)."'' AND [Del] = 0";
		self::$res = mssql_query(self::$sql);
		
		if (mssql_num_rows(self::$res) < 1)
			return self::$fet[0];
		
		self::$fet = mssql_fetch_array(self::$res);
		return self::$fet[0];			
	}
}


?>