<?php
// Database configuration parameters
include "db_connect.php";
;
//Form Data
$ip       = $_SERVER['REMOTE_ADDR'];
$CharName = $_POST['CharName'];
$QuaryID  = $_POST['QuaryID'];
$UserID   = $_POST['UserID'];
$success  = false;
if (isset($_POST['submit'])) {
	if (empty($_POST['CharName'])) {
		die('You didn\'t specify a Character Name!');
	} {
		if ($QuaryID == 1) {
			$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\''.$CharName.'\',\''.$CharName.' Un 3 Day banned.\',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $CharName . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $CharName . '\'');
			$useruid = mssql_query('SELECT UserUID,UserID FROM PS_GameData.dbo.Chars WHERE CharName=\'' . $CharName . '\'');
			if (mssql_num_rows($useruid) == 0)
				echo "No chars matched the query";
			else
				while ($res = mssql_fetch_array($useruid)) { {
						$query   = mssql_query('UPDATE PS_UserData.dbo.Users_Master SET Status= 0
			WHERE UserUID = \'' . $res['UserUID'] . '\'');
			if ( $query == 1 )
			{
				$query2 = mssql_query('DELETE FROM GM_Stuff.dbo.BannedAccounts 
			 WHERE UserID =  \'' . $res['UserID'] . '\'');
						$success = '' . $CharName . 's account successfully Un 3 Day banned.';
					}
				}
		}}
		if (($QuaryID) == 2) {
			$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\''.$CharName.'\',\''.$CharName.' Un 2 week banned.\',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $CharName . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $CharName . '\'');
			$useruid = mssql_query('SELECT UserUID,UserID FROM PS_GameData.dbo.Chars WHERE CharName=\'' . $CharName . '\'');
			if (mssql_num_rows($useruid) == 0)
				echo "No chars matched the query";
			else
				while ($res = mssql_fetch_array($useruid)) { {
						$query   = mssql_query('UPDATE PS_UserData.dbo.Users_Master SET Status= 0
			WHERE UserUID = \'' . $res['UserUID'] . '\'');
			if ( $query == 1 )
			{
				$query2 = mssql_query('DELETE FROM GM_Stuff.dbo.BannedAccounts 
			 WHERE UserID =  \'' . $res['UserID'] . '\'');
						$success = '' . $CharName . 's account successfully Un 2 week banned.';
					}
				}
		}}
		if (($QuaryID) == 3) {
			$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\''.$CharName.'\',\''.$CharName.' Un I.P. banned.\',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $CharName . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $CharName . '\'');
			$useruid = mssql_query('SELECT UserUID,UserID FROM PS_GameData.dbo.Chars WHERE CharName=\'' . $CharName . '\'');
			if (mssql_num_rows($useruid) == 0)
				echo "No chars matched the query";
			else
				while ($res = mssql_fetch_array($useruid)) { {
						$query   = mssql_query('UPDATE PS_UserData.dbo.Users_Master SET Status= 0
			WHERE UserUID = \'' . $res['UserUID'] . '\'');
			if ( $query == 1 )
			{
				$query2 = mssql_query('DELETE FROM GM_Stuff.dbo.BannedIP 
			 WHERE UserID =  \'' . $res['UserID'] . '\'');
						$success = '' . $CharName . 's IP successfully Un I.P. Banned.';
					}
				}
		}
	}}
	echo $success;
}
?>

<html>
	<head>
	<title>ACCOUNT UN BAN by Char Name</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>ACCOUNT UN BAN by Char Name</b>
    <form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
    <table>
    <tr><td>Char Name:</td><td><input type="text" name="CharName"/></td></tr>
    <tr><td>Ban Type:</td><td><select name="QuaryID">
  <option value="1">3 Day Ban</option>
  <option value="2">2 Week Ban</option>
  <option value="3">IP Bann</option>
</select></td></tr>
	</table>
<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>