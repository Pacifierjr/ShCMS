<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class Top{
	private static $sql;
	private static $res;
	private static $fet;
	private static $array;
	private static $count;
	
	public static function Accounts($count){
		if (!Parser::gint($count))
			throw new SystemException('Count muss vom Typ integer sein', 0, 0, __FILE__, __LINE__);
		
		self::$sql = "SELECT top $count [UserUID], [UserID], [Admin], [AdminLevel], [Status], [JoinDate], [Point], [UserIP] FROM [PS_UserData].[dbo].[Users_Master]
					  ORDER BY [UserUID] DESC";
		self::$res = mssql_query(self::$sql);
		
		self::$count = 0;
		
		while (self::$fet = mssql_fetch_assoc(self::$res)){
			self::$array[self::$count]['UserUID']		= self::$fet['UserUID'];
			self::$array[self::$count]['UserID']		= Parser::specialChars(self::$fet['UserID']);
			self::$array[self::$count]['Admin']			= self::$fet['Admin'];
			self::$array[self::$count]['AdminLevel']	= self::$fet['AdminLevel'];
			self::$array[self::$count]['Status']		= self::$fet['Status'];
			self::$array[self::$count]['JoinDate']		= strtotime(self::$fet['JoinDate']);
			self::$array[self::$count]['Point']			= self::$fet['Point'];
			self::$array[self::$count]['UserIP']		= self::$fet['UserIP'];
			
			self::$count++;
		}
		
		return self::$array;
	}
	
	public static function Chars($count){
		if (!Parser::gint($count))
			throw new SystemException('Count muss vom Typ integer sein', 0, 0, __FILE__, __LINE__);
		
		self::$sql = "SELECT top $count [UserUID], [CharID], [CharName], [Del], [Level], [Family], [Job], [Map], [k1], [k2] FROM [PS_GameData].[dbo].[Chars]
					  ORDER BY [CharID] DESC";
		self::$res = mssql_query(self::$sql);
		
		self::$count = 0;
		
		while (self::$fet = mssql_fetch_assoc(self::$res)){
			self::$array[self::$count]['UserUID']		= self::$fet['UserUID'];
			self::$array[self::$count]['CharID']		= self::$fet['CharID'];
			self::$array[self::$count]['CharName']		= Parser::specialChars(self::$fet['CharName']);
			self::$array[self::$count]['Del']			= self::$fet['Del'];
			self::$array[self::$count]['Level']			= self::$fet['Level'];
			self::$array[self::$count]['Family']		= self::$fet['Family'];
			self::$array[self::$count]['Job']			= self::$fet['Job'];
			self::$array[self::$count]['Map']			= self::$fet['Map'];
			self::$array[self::$count]['k1']			= self::$fet['k1'];
			self::$array[self::$count]['k2']			= self::$fet['k2'];
			
			self::$count++;
		}
		
		return self::$array;
	}
	
	public static function Guild($count){
		if (!Parser::gint($count))
			throw new SystemException('Count muss vom Typ integer sein', 0, 0, __FILE__, __LINE__);
		
		self::$sql = "SELECT top $count [GuildID], [GuildName], [GuildPoint], [Country], [TotalCount], [CreateDate], [Del] FROM [PS_GameData].[dbo].[Guilds]
					  ORDER BY [GuildPoint] DESC";
		self::$res = mssql_query(self::$sql);
		
		self::$count = 0;
		
		while (self::$fet = mssql_fetch_assoc(self::$res)){
			self::$array[self::$count]['GuildID']		= self::$fet['GuildID'];
			self::$array[self::$count]['GuildName']		= Parser::specialChars(self::$fet['GuildName']);
			self::$array[self::$count]['GuildPoint']	= self::$fet['GuildPoint'];
			self::$array[self::$count]['Country']		= self::$fet['Country'];
			self::$array[self::$count]['TotalCount']	= self::$fet['TotalCount'];
			self::$array[self::$count]['CreateDate']	= strtotime(self::$fet['CreateDate']);
			self::$array[self::$count]['Del']			= self::$fet['Del'];
				
			self::$count++;
		}
		
		return self::$array;
	}
	
	public static function Auctions($count){
		if (!Parser::gint($count))
			throw new SystemException('Count muss vom Typ integer sein', 0, 0, __FILE__, __LINE__);
		
		self::$sql = "SELECT top $count [m].[MarketID], [m].[CharID], [m].[MinMoney], [m].[DirectMoney], [m].[GuaranteeMoney], [m].[TenderCharID], [m].[TenderCharName], [m].[TenderMoney], [m].[EndDate], [m].[Del],
					 [mi].[ItemID], [mi].[Quality],
					 [i].[ItemName], [i].[ReqLevel], [i].[Quality] AS [MaxQuality]
					 FROM [PS_GameData].[dbo].[Market] AS [m]
					 INNER JOIN [PS_GameData].[dbo].[MarketItems] AS [mi] ON [mi].[MarketID] = [m].[MarketID]
					 INNER JOIN [PS_GameDefs].[dbo].[Items] AS [i] ON [i].[ItemID] = [mi].[ItemID]
					 ORDER BY [m].[MarketID] ASC";
		self::$res = mssql_query(self::$sql);
		
		self::$count = 0;
		
		while (self::$fet = mssql_fetch_assoc(self::$res)){
			self::$array[self::$count]['MarketID']	= self::$fet['MarketID'];
			self::$array[self::$count]['CharID']	= self::$fet['CharID'];		
			self::$array[self::$count]['ItemName']	= Parser::specialChars(self::$fet['ItemName']);
			self::$array[self::$count]['EndDate']	= strtotime(self::$fet['EndDate']);
			
			self::$count++;
		}
		
		return self::$array;
	}
	
	public static function Statpadder(){
		self::$sql = "SELECT [c].*, '0.' + CAST(([c].[k1]*10)/([c].[k2]) AS VARCHAR) AS [KDR] FROM [PS_GameData].[dbo].[Chars] AS [c]
					  INNER JOIN [PS_UserData].[dbo].[Users_Master] AS [u] ON [u].[UserUID] = [c].[UserUID]
					  WHERE [k1] < 500 AND [k2] > 20 AND ([k1]*10)/([k2]) < 5 AND [u].[Status] = 0
					  ORDER BY [k2] DESC";
		self::$res = mssql_query(self::$sql);
		
		self::$count = 0;
		
		if (mssql_num_rows(self::$res) == 0)
			return false;
		
		while (self::$fet = mssql_fetch_assoc(self::$res)){
			self::$array[self::$count]['UserUID']		= self::$fet['UserUID'];
			self::$array[self::$count]['CharID']		= self::$fet['CharID'];
			self::$array[self::$count]['CharName']		= Parser::specialChars(self::$fet['CharName']);
			self::$array[self::$count]['Del']			= self::$fet['Del'];
			self::$array[self::$count]['Level']			= self::$fet['Level'];
			self::$array[self::$count]['Family']		= self::$fet['Family'];
			self::$array[self::$count]['Job']			= self::$fet['Job'];
			self::$array[self::$count]['Map']			= self::$fet['Map'];
			self::$array[self::$count]['k1']			= self::$fet['K1'];
			self::$array[self::$count]['k2']			= self::$fet['K2'];
			self::$array[self::$count]['KDR']			= self::$fet['KDR'];
			
			self::$count++;
		}
		
		return self::$array;
	}
}

?>