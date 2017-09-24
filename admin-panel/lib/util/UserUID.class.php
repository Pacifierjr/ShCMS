<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class UserUID{
	private static $sql;
	private static $res;
	private static $fet;
	private static $count;
	private static $returnArr;
	private static $conn;
	public static function byUserIP($ip){
		self::$conn = dbConn::getConnection();
		self::$sql = self::$conn->prepare("SELECT [UserUID] FROM [PS_UserData].[dbo].[Users_Master] WHERE [UserIP] = '".Parser::validate($ip)."'");
		self::$sql->execute();
		
		if (self::$sql->rowCount() == 0)
			return false;
		
		self::$count = 0;
		
		while (self::$fet = self::$sql->fetch(PDO::PARAM_BOTH)){
			self::$returnArr[self::$count] = self::$fet[0];
			self::$count++;
		}
		
		return self::$returnArr;
	}
}

?>