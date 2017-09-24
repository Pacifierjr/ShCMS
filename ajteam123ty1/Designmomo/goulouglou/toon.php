<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_POST['SCN'])) {
	$Long = @mssql_query('SELECT * FROM PS_GameData.dbo.CharRenameLog
WHERE CharID =' . $_POST['ItemUID'] . ' Order BY UpdateTime');
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>CharID</th>
		<th>CharName</th>
		<th>UpdateTime</th></tr>';
	while ($Row = @mssql_fetch_assoc($Long)) {
		echo '<tr><td>' . $Row['CharID'] . '</td>
	 <td>' . $Row['CharName'] . '</td>
	<td>' . $Row['UpdateTime'] . '</td>
	</tr>';
	}
	echo '</table>';
	echo '</form>';
}
if (isset($_POST['SC'])) {
	if (empty($_POST['CharName'])) {
		die('You didn\'t specify a Character Name!');
	}//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $_POST['CharName'] . '\',\' Search Dead/Alive toons assoicated to '.$_POST['CharName'].' \',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $_POST['CharName'] . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $_POST['CharName'] . '\'');
	$useruid = mssql_query('SELECT * FROM PS_GameData.dbo.Chars WHERE CharName = \'' . $_POST['CharName'] . '\'');
	while ($res = mssql_fetch_array($useruid))
		$query = mssql_query("SELECT * FROM PS_GameData.dbo.Chars where UserUID = " . $res['UserUID'] . "");
	$del = array(
		0 => 'Alive',
		1 => 'Dead/Deleated'
	);
	if (@mssql_num_rows($query) == 0) {
		echo 'Character search for: "' . $_POST['CharName'] . '" returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>CharName</th>
		<th>Status</th>
		<th>Select</th></tr>';
	while ($Row = @mssql_fetch_assoc($query)) {
		echo '<tr><td>' . $Row['CharName'] . '</td>
	 <td>' . $del[$Row['Del']] . '</td>
	<td><input type="radio" name="CharID" value="' . $Row['CharID'] . '"></td>
	</tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="SCI">';
	echo '</form>';
} elseif (isset($_POST['SCI'])) {
	if (!isset($_POST['CharID'])) {
		die('You didn\'t select a Character!');
	}
	$Bag = array(
		0 => 'Alive',
		1 => 'Dead/Deleated'
	);
	$res = mssql_query('SELECT * FROM PS_GameData.dbo.Chars WHERE CharID = ' . $_POST['CharID'] . '');
	if (mssql_num_rows($res) == 0) {
		echo 'Search returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>CharName</th>
		<th>CharID</th>
		<th>Status</th>
		<th>UserID</th>
		<th>OldCharName</th>
		<th>Select</th></tr>';
	while ($Row = @mssql_fetch_assoc($res)) {
		echo '<tr><td>' . $Row['CharName'] . '</td>
	    <td>' . $Row['CharID'] . '</td>
		<td>' . $Bag[$Row['Del']] . '</td>
		<td>' . $Row['UserID'] . '</td>
		<td>' . $Row['OldCharName'] . '</td>
		<td><input type="radio" name="ItemUID" value="' . $Row['CharID'] . '"></td>
		</tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="SCN">';
	echo '</form>';
}
?>
<html>
<head>
<title>Dead/Alive Previous toon names</title>
</head>
<body>
<font face="Trebuchet MS">
<center>
<br><br>
<b>Dead/Alive Previous toon names<br>
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