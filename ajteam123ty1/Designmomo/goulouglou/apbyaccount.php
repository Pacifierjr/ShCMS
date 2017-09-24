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
	} { {
			$query   = mssql_query('UPDATE PS_UserData.dbo.Users_Master SET Point = Point + ' . $DP . ' 
			WHERE UserID = \'' . $UserID . '\'');
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
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $UserID . '\',\' Added ' .$DP. ' D.P. \',GETDATE())');
	
	echo $success;
}
?>
<html>
	<head>
	<title>apByAccount HandOut</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>A.P. HandOut</b>
    <form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
    <table>
    <tr><td>UserID:</td><td><input type="text" name="UserID"/></td></tr>
    <tr><td>D.P.Ammount:</td><td><input type="text" name="DP"/></td></tr>
	</table>
<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>