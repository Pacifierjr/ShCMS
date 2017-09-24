<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip      = $_SERVER['REMOTE_ADDR'];
$DP      = $_POST['DP'];
$UserID  = $_POST['UserID'];
if (isset($_POST['submit'])) {
	if (empty($_POST['UserID'])) {
		die('You didn\'t specify an Account Name!');
	}
	$useruid = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $UserID . '\'');
	if (mssql_num_rows($useruid) == 0)
		echo "No chars matched the query";
	else
		while ($res = mssql_fetch_array($useruid)) { {
				$query   = mssql_query('UPDATE PS_UserData.dbo.Users_Master SET Point = Point + ' . $DP . ' 
			WHERE UserID = \'' . $res['UserID'] . '\'');
				$success = 'Sucesfuly added ' . $DP . ' Points to ' . $UserID . '\'s account.';
			}
		}
		//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $UserID . '\',\' Add ' .$DP. ' D.P. \',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $UserID . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $UserID . '\'');
	echo $success;
}
?>
<html>
	<head>
	<title>apByChar HandOut</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>A.P. HandOut</b>
    <form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
    <table>
    <tr><td>Char Name:</td><td><input type="text" name="UserID"/></td></tr>
    <tr><td>D.P.Ammount:</td><td><input type="text" name="DP"/></td></tr>
	</table>
<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>
