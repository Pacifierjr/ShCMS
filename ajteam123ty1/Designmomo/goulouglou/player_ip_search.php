<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$id = $_POST['CharName'];
if (isset($_POST['SC'])) {
	if (empty($_POST['CharName'])) {
		die('You didn\'t specify a Character Name!');
	}
	//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' .$id. '\',\' Search Accounts Associated with IP. \',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' .$id. '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' .$id. '\'');
	$useruid = @mssql_query('SELECT * FROM PS_GameData.dbo.Chars WHERE CharName = \'' . $_POST['CharName'] . '\'');
	while ($res = mssql_fetch_array($useruid))
		$ip = @mssql_query("SELECT * FROM PS_UserData.dbo.Users_Master where UserUID = " . $res['UserUID'] . "");
	while ($res1 = mssql_fetch_array($ip))
		$query = mssql_query('SELECT * FROM PS_UserData.dbo.Users_Master WHERE UserIp = \'' . $res1['UserIp'] . '\'');
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
<b>Select an account to get All characters Associated to it.</b>
		<th>Account Name</th>
		<th>Password</th>
		<th>UserUID</th>
		<th>Select</th></tr>';
	while ($Row = @mssql_fetch_array($query)) {
		echo '<tr><td>' . $Row['UserID'] . '</td>
		  <td>' . $Row['Pw'] . '</td>
		  <td>' . $Row['UserUID'] . '</td>
	<td><input type="radio" name="CharID" value="' . $Row['UserUID'] . '"></td>
	</tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="SCI">';
	echo '</form>';
} elseif (isset($_POST['SCI'])) {
	if (!isset($_POST['CharID'])) {
		die('You didn\'t select a Character!');
	}
	$res = @mssql_query('SELECT * FROM PS_GameData.dbo.Chars WHERE UserUID = ' . $_POST['CharID'] . 'AND Del = 0 order by Slot');
	if (@mssql_num_rows($res) == 0) {
		echo 'Search returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>CharName</th>
		<th>Slot</th><td style=\"color:#FC9100\" bgcolor=\"white\">CharClass  </td></tr>';
	while ($Row = @mssql_fetch_assoc($res)) {
		echo '<tr>
		<td>' . $Row['CharName'] . '</td>
		<td>' . $Row['Slot'] . '</td>
		<td>' . $Row['Family'] . '</td>
		</tr>';
	}
	echo '</table>';
	echo '</form>';
} else {
?>
<?php
}
?>
<html>
<head>
<title>Player IP Search</title>
</head>
<body>
<font face="Trebuchet MS">
<center>
<br><br>
<b>Search All Accounts Associated to IP of a Character<br>
<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
<table>
<tr><td>Character Name:</td><td><input type="text" name="CharName"></td></tr>
</table>
<p><input type="submit" value="Submit" name="SC" /></p>
</form>
</center>
</body>
</html>