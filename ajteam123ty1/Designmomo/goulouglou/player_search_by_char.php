<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$char  = $_POST['char'];
$count = 0;
if (isset($_POST['submit'])) {
	if (empty($char)) {
		die('You didn\'t specify Character Name!');
	}
	//Check if UserID Exists
		{
	$useruid = mssql_query("SELECT * FROM PS_GameData.dbo.Chars where CharName = '$char'");
	while ($res = mssql_fetch_array($useruid))
		$query = mssql_query("SELECT * FROM PS_GameData.dbo.Chars where UserUID = " . $res['UserUID'] . "");
	if (mssql_num_rows($query) == 0)
		echo "No chars matched the query";
	else {
		echo "
		<body alink=\"blue\" vlink=\"blue\" llink=\"blue\">
		<font face=\"trebuchet MS\">Result for the search '$char':<table cellspacing=1 cellpadding=2 border=1 style=\"border-style:hidden;\">
		<tr><td>UserUID</td><td>UserName</td><td>Char ID</td><td>Char Name</td></tr>";
		while ($res = mssql_fetch_array($query))
			echo "<tr><td>" . $res['UserUID'] . "</td><td>" . $res['UserID'] . "</td><td>" . $res['CharID'] . "</td><td><a href=\"player_edit.php?char=" . $res['CharName'] . "\" style=\"text-decoration:none;\">" . $res['CharName'] . "</a></td></tr>";
		echo "</table></font></body>";
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
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $char . '\',\' Searched Chars on ' . $char . 's Account \',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $char . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $char . '\'');
}?>
	<html>
	<head>
	<title>Player Search by CharName</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>Player Search by CharName<br>
	<form action="<?php
	echo $_SERVER['PHP_SELF'];
?>" method="POST">
	<table>
	<tr>
	<td>Character Name:</td><td><input type="text" name="char" /></td>
	</tr>
	</table>
	<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>