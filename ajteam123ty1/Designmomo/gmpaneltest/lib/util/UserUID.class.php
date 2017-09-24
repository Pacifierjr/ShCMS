<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class UserUID{
	private static $sql;
	private static $res;
	private static $fet;
	private static $count;
	private static $returnArr;
	
	public static function byUserIP($ip){
		self::$sql = "SELECT [UserUID] FROM [PS_UserData].[dbo].[Users_Master] WHERE [UserIP] = '".Parser::validate($ip)."'";
		self::$res = mssql_query(self::$sql);
		
		if (mssql_num_rows(self::$res) == 0)
			return false;
		
		self::$count = 0;
		
		while (self::$fet = mssql_fetch_array(self::$res)){
			self::$returnArr[self::$count] = self::$fet[0];
			self::$count++;
		}
		
		return self::$returnArr;
	}
}

?>