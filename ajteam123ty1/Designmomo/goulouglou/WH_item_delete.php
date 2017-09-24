<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_POST['SCN'])) {
	$Set    = false; //Change to True to have it based off ReqWis, false for custom input.
	@mssql_query('DELETE FROM PS_GameData.dbo.UserStoredItems Where ItemUID=' . $_POST['ItemUID'] . ''); {
		echo 'Item Deleated Sucesfuly!!<br>';
	}
}
 elseif (isset($_POST['SC'])) {
	if (empty($_POST['UserID'])) {
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
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $_POST['UserID'] . '\',\'Delete '.$_POST['UserID'].' W.H. Items. \',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $_POST['UserID'] . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $_POST['UserID'] . '\'');
	$Chars = @mssql_query('SELECT UserID,UserUID,CharName FROM PS_GameData.dbo.Chars WHERE CharName = \'' . $_POST['UserID'] . '\'');
	if (@mssql_num_rows($Chars) == 0) {
		echo 'Character search for: "' . $_POST['UserID'] . '" returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>CharName</th>
		<th>UserID</th>
		<th>UserUID</th>
		<th>Select</th></tr>';
	while ($Row = @mssql_fetch_assoc($Chars)) {
		echo '<tr><td>' . $Row['CharName'] . '</td>
<td>' . $Row['UserID'] . '</td>
<td>' . $Row['UserUID'] . '</td>
	<td><input type="radio" name="UserUID" value="' . $Row['UserUID'] . '"></td>
	</tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="SCI">';
	echo '</form>';
} elseif (isset($_POST['SCI'])) {
	if (!isset($_POST['UserUID'])) {
		die('You didn\'t select a Character!');
	}
	$Bag = array(
		0 => 'Equipped',
		1 => 'Bag 1',
		2 => 'Bag 2',
		3 => 'Bag 3',
		4 => 'Bag 4',
		5 => 'Bag 5'
	);
	$res = @mssql_query('SELECT I.ItemName,CI.Slot,CI.Count,CI.ItemUID,CI.UserUID FROM PS_GameData.dbo.UserStoredItems CI
					INNER JOIN PS_GameDefs.dbo.Items I ON I.ItemID=CI.ItemID WHERE CI.UserUID = ' . $_POST['UserUID'] . ' ORDER BY CI.Slot');
	if (@mssql_num_rows($res) == 0) {
		echo 'Search returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>ItemName</th>
		<th>Slot</th>
		<th>Count</th>
		<th>Select</th></tr>';
	while ($Row = @mssql_fetch_assoc($res)) {
		echo '<tr><td>' . $Row['ItemName'] . '</td>
		<td>' . $Row['Slot'] . '</td>
		<td>' . $Row['Count'] . '</td>
		<td><input type="radio" name="ItemUID" value="' . $Row['ItemUID'] . '"></td>
		</tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="SCN">';
	echo '</form>';
} else {
?>
	<?php
	require_once('WH_item_delete.php');
}
?>
<html>
<head>
<title>W.H.Items Delete</title>
</head>
<body>
<font face="Trebuchet MS">
<center>
<br><br>
<b>W.H. Items Delete<br>
<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
<table>
<tr><td>Character Name:</td><td><input type="text" name="UserID"></td></tr>
</table>
<p><input type="submit" value="Submit" name="SC" /></p>
</form>
</center>
</body>
</html>
