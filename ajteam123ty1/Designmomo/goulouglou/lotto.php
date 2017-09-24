<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$Staff = trim($_REQUEST['Staff']);
$ip    = $_SERVER['REMOTE_ADDR'];
if ((isset($_POST['submit'])) || strlen($Staff) > 1) {
	if (strlen($Staff) < 1) {
		die("No Staff Name Provided.\n ");
	} else
	//Check if UserID Exists
		{
		$useruid = @mssql_query('SELECT UserID,Pw FROM  PS_UserData.dbo.Users_Master WHERE UserID = \'' . $Staff . '\'');
		if (mssql_num_rows($useruid) == 0)
			die('Account Dosent Exist');
		else
			//Check if UserID IS admin + account Exists
		$useruid1 = @mssql_query('SELECT UserID,Pw FROM  PS_UserData.dbo.Users_Master WHERE UserID = \'' . $Staff . '\' AND Status > 15');
		if (mssql_num_rows($useruid1) == 0)
			die('Account ISNOT of proper Status');
		else
	$res     = mssql_query("SELECT TOP 1* FROM PS_GameData.dbo.Chars C INNER JOIN PS_UserData.dbo.Users_Master U ON U.UserUID = C.UserUID Where U.Status > 0  and C.RegDate < (GETDATE() -7) and C.JoinDate > (GETDATE() -14) and C.Del = 0 ORDER BY NEWID()");
	$detail  = mssql_fetch_array($res);
	$coloums = array(
		'CharName'
	);
	if (mssql_num_rows($res) == 0) {
		die("No Characters Created atleast 2 week ago that has been active in the last week");
	} else {
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\"><font face=\"Trebuchet MS\">
			<table cellspacing=1 cellpadding=2 border=1 style=\"border-style:hidden;\">
			<tr><td>Name</td><td>Value</td>";
		foreach ($coloums as $value) {
			echo "<tr>
				<td>$value</td>";
			echo "<td><input type=\"text\" name=\"$value\" value=\"$detail[$value]\" /></td></tr>";
			$count++;
		}
	}
	$query1 = mssql_query('INSERT INTO GM_Stuff.dbo.RandomLottoWinners (CharName,StaffName,ExecutionDate,StaffIP) VALUES (\''.$detail[$value].'\',\''. $Staff . '\',getdate(),\'' . $ip . '\')');
}
//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\''.$detail[$value].'\',\'  '.$detail[$value].' Picked For Loto \',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \''.$detail[$value].'\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \''.$detail[$value].'\'');
}
?>
	<html>
	<head>
	<title>Random Lottery</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>Random Lottery<br>
	<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
	<table>
	<tr>
	<td>Staff Name:</td><td><input type="text" name="Staff" /></td>
	</tr>
	</table>
	<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>