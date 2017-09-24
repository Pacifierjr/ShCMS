<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$UserID = $_POST['CharName'];
if (isset($_POST['SC'])) {
	if (empty($_POST['CharName'])) {
		die('You didnt specify a Character Name!');
	}
	//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $UserID . '\',\'Jail All of '.$UserID.' Toons.\',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $UserID . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $UserID . '\'');
	$Chars = @mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $_POST['CharName'] . '\'');
	while ($res = mssql_fetch_array($Chars))
		$query = mssql_query("SELECT * FROM PS_GameData.dbo.Chars where UserUID = " . $res['UserUID'] . "");
	if (@mssql_num_rows($Chars) == 0) {
		echo 'Character search for: "' . $_POST['CharName'] . '" returned no results.';
	}
	while ($Row = @mssql_fetch_assoc($query)) {
		$Chars2 = mssql_query("UPDATE PS_GameData.dbo.Chars SET Map = 41,PosX = 46,PosY = 3 ,PosZ = 45 where CharID = " . $Row['CharID'] . "");
		echo '</form>';
	}
} 
?>
<html>
<head>
<title>Jail Toons</title>
</head>
<body>
<font face="Trebuchet MS">
<center>
<br><br>
<b> Jail ALL toons for this account by /kicking online toon then submit the toon name here<br>
<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
<table>
<tr><td>Character  Name:</td><td><input type="text" name="CharName"></td></tr>
</table>
<p><input type="submit" value="Submit" name="SC" /></p>
</form>
</center>
</body>
</html>