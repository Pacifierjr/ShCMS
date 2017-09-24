<?php
// Database configuration parameters
include "db_connect.php";
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
	(\''.$Log['UserID'].'\',\''.$ip.'\',\''.$CharName.'\',\''.$CharName.' banned for 3Days.\',GETDATE())');
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
						$query   = mssql_query('UPDATE PS_UserData.dbo.Users_Master SET Status= -5
			WHERE UserUID = \'' . $res['UserUID'] . '\'');
			if ( $query == 1 )
			{
				$query2 = mssql_query('INSERT INTO GM_Stuff.dbo.BannedAccounts 
			 (UserID, Status, Success, TimeActivated,StaffID,StaffIP) 
VALUES(\'' . $res['UserID'] . '\', \'Banned\', \'True\', GETDATE(),\'' .$StaffID. '\',\'' .$ip.'\')');
				if ( $query2 == 1 )
			{	$query3 = mssql_query ('UPDATE GM_Stuff.dbo.BannedAccounts 
SET TimeReleased = (GETDATE() +3)
Where UserID=\'' . $res['UserID'] . '\'');
						$success = '' . $CharName . 's account successfully banned for: 3 days.';
					}
				}
		}}}
		if (($QuaryID) == 2) {
			$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\''.$CharName.'\',\''.$CharName.' banned for 2 weeks.\',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $CharName . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $CharName . '\'');
			$useruid = mssql_query('SELECT UserUID FROM PS_GameData.dbo.Chars WHERE CharName=\'' . $CharName . '\'');
			if (mssql_num_rows($useruid) == 0)
				echo "No chars matched the query";
			else
				while ($res = mssql_fetch_array($useruid)) { {
						$query   = mssql_query('UPDATE PS_UserData.dbo.Users_Master SET Status= -4
			WHERE UserUID = \'' . $res['UserUID'] . '\'');
					if ( $query == 1 )
					$userid = mssql_query('SELECT * FROM PS_GameData.dbo.Chars WHERE CharName=\'' . $CharName . '\'');
			if (mssql_num_rows($userid) == 0)
				echo "No no userid selected";
			else
				while ($res4 = mssql_fetch_array($userid))
			{$query2 = mssql_query('INSERT INTO GM_Stuff.dbo.BannedAccounts 
			 (UserID, Status, Success, TimeActivated,StaffID,StaffIP) 
VALUES(\'' . $res4['UserID'] . '\', \'Banned\', \'True\', GETDATE(),\'' .$StaffID. '\',\'' .$ip.'\')');
				if ( $query2 == 1 )
			{	$query3 = mssql_query ('UPDATE GM_Stuff.dbo.BannedAccounts 
SET TimeReleased = (GETDATE() +14)
Where UserID=\'' . $res4['UserID'] . '\'');
						$success = '' . $CharName . 's account successfully banned for: 2 Weeks.';
					}
				}
		}}}
		if (($QuaryID) == 3) {
			$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\''.$CharName.'\',\''.$CharName.' I.P. Banned.\',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $CharName . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $CharName . '\'');
			$useruid = mssql_query('SELECT UserUID FROM PS_GameData.dbo.Chars WHERE CharName=\'' . $CharName . '\'');
			if (mssql_num_rows($useruid) == 0)
				echo "No chars matched the query";
			else
				while ($res = mssql_fetch_array($useruid)) { {
						$query   = mssql_query('UPDATE PS_UserData.dbo.Users_Master SET Status= -2
			WHERE UserUID = \'' . $res['UserUID'] . '\'');
					if ( $query == 1 )
			{	$userip = mssql_query ('SELECT * FROM PS_UserData.dbo.Users_Master WHERE UserUID= \'' . $res['UserUID'] . '\'');
			if (mssql_num_rows($userip) == 0)
				echo "No IP Grabed";
			else
				while ($res5 = mssql_fetch_array($userip))
			{$query2 = mssql_query('INSERT INTO GM_Stuff.dbo.BannedIP 
			 (UserID, BanDate, IP1, StaffID,StaffIP) 
VALUES(\'' . $res5['UserID'] . '\', GETDATE(),\''.$res5['UserIp'].'\',\'' .$StaffID. '\',\'' .$ip.'\')');
						$success = '' . $CharName . 's IP successfully banned.';
					}
				}
		}}}
	}
	echo $success;
}
?>
<html>
	<head>
	<title>ACCOUNT BAN by Char Name</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>ACCOUNT BAN by Char Name</b>
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