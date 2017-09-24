<?php
include "db_connect.php";
$ip = $_SERVER['REMOTE_ADDR'];
$char  = trim($_REQUEST['char']);
$count = 0;
if (!isset($_POST['submit'])) {
} else {
	if (strlen($char) < 1) {
		echo "Char Name too short.\n ";
	}
	//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $char . '\',\'Search I.P. of '. $char .'.\',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $char . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $char . '\'');
	$useruid = mssql_query("SELECT * FROM PS_GameData.dbo.Chars where CharName = '$char'");
	while ($res = mssql_fetch_array($useruid))
		$query = mssql_query("SELECT * FROM PS_UserData.dbo.Users_Master where UserUID = " . $res['UserUID'] . "");
	if (@mssql_num_rows($query) == 0) {
		echo 'Character search for: $char returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>UserIP</th>
		<th>Select</th></tr>';
	while ($Row  = mssql_fetch_array($query)) {
		echo '<tr><td>' . $Row['UserIp'] . '</td>
	<td><input type="radio" name="UserIp" value="' . $Row['UserIp'] . '"></td>
	</tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="SCI">';
	echo '</form>';
}
if (isset($_POST['SCI'])) {
	if (!isset($_POST['UserIp'])) {
		die('You didn\'t select a Character!');
	}
	$res1 = mssql_query('SELECT UserID from PS_UserData.dbo.Users_Master WHERE UserIp = \'' . $_POST['UserIp'] . '\' ORDER BY UserID');
	if (@mssql_num_rows($res1) == 0) {
		echo 'Search returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>UserID</th></tr>';
	while ($Row1 = @mssql_fetch_array($res1)) {
		echo '<tr><td>' . $Row1['UserID'] . '</td></tr>';
	}
	echo '</table>';
}
?>
	<html>
	<head>
	<title>Player IP Search</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>Player IP Search<br>
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
