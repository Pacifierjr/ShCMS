<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_POST['SCN'])) {
	$Long   = @mssql_query('SELECT * FROM PS_GameData.dbo.Guilds WHERE GuildID=' . $_POST['GuildID'] . '');
	$Result = @mssql_fetch_assoc($Long);
	$Fields = array(
		'GuildID',
		'GuildName',
		'MasterUserID',
		'MasterCharID',
		'MasterName',
		'Country',
		'TotalCount',
		'GuildPoint',
		'Del',
		'CreateDate',
		'DeleteDate'
	);
	$NoEdit = array(
		'GuildID',
		'GuildName',
		'MasterUserID',
		'MasterCharID',
		'MasterName',
		'Country',
		'TotalCount',
		'GuildPoint',
		'Del',
		'CreateDate',
		'DeleteDate'
	);
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1">';
	foreach ($Fields as $Columns) {
		echo '<tr><th>' . $Columns . '</th>';
		if (in_array($Columns, $NoEdit)) {
			echo '<th><input type="text" value="' . $Result[$Columns] . '" name="' . $Columns . '" style="background:#D0D0D0;" READONLY></th>';
		} else {
			if ($Set) {
				if ($Columns == 'Enchant') {
					echo '<td><select style="width:100%;" name="' . $Columns . '">';
					echo '<option value="00">00</option>';
					if (in_array($Result['Type'], $Armor)) {
						for ($e = 50; $e <= 70; $e++) {
							if ($e == $Result[$Columns]) {
								echo '<option value="' . $e . '" selected>' . $e . '</option>';
							}
							echo '<option value="' . $e . '">' . $e . '</option>';
						}
					} else {
						for ($a = 1; $a <= 20; $a++) {
							$a = str_pad($a, 2, 0, STR_PAD_LEFT);
							if ($a == $Result[$Columns]) {
								echo '<option value="' . $a . '" selected>' . $a . '</option>';
							}
							echo '<option value="' . $a . '">' . $a . '</option>';
						}
					}
					echo '</select></td>';
				} else {
					echo '<td><select style="width:100%;" name="' . $Columns . '">';
					for ($i = 0; $i <= $Result['ReqWis']; $i++) {
						$i = str_pad($i, 2, 0, STR_PAD_LEFT);
						if ($i == $Result[$Columns]) {
							echo '<option value="' . $i . '" selected>' . $i . '</option>';
						} else {
							echo '<option value="' . $i . '">' . $i . '</option>';
						}
					}
					echo '</select></td>';
				}
			} else {
				echo '<th><input type="text" name="' . $Columns . '" value="' . $Result[$Columns] . '" /></th>';
			}
		}
		echo '</tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="CNE">';
	echo '</form>';
}
elseif (isset($_POST['CNE'])) {
	mssql_query('DELETE FROM PS_GameData.dbo.Guilds Where GuildID = \'' . $_POST['GuildID'] . '\'');
	mssql_query('DELETE FROM PS_GameData.dbo.GuildChars Where GuildID = \'' . $_POST['GuildID'] . '\'');
	foreach ($_POST as $Name => $Value) {
		echo $Name . '=>' . $Value . '<br>';
	}
} elseif (isset($_POST['SC'])) {
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
	(\''.$Log['UserID'].'\',\''.$ip.'\',\''. $_POST['CharName'] .'\',\'Disbaned Guild. \',GETDATE())');
	$Chars = @mssql_query('SELECT GuildName,GuildID FROM PS_GameData.dbo.Guilds WHERE GuildName = \'' . $_POST['CharName'] . '\'');
	if (@mssql_num_rows($Chars) == 0) {
		echo 'Character search for: "' . $_POST['CharName'] . '" returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>GuildName</th>
		<th>Select</th></tr>';
	while ($Row = @mssql_fetch_assoc($Chars)) {
		echo '<tr><td>' . $Row['GuildName'] . '</td>
	<td><input type="radio" name="GuildID" value="' . $Row['GuildID'] . '"></td>
	</tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="SCI">';
	echo '</form>';
} elseif (isset($_POST['SCI'])) {
	if (!isset($_POST['GuildID'])) {
		die('You didn\'t select a Guild!');
	}
	$res = @mssql_query('SELECT * FROM PS_GameData.dbo.Guilds  WHERE GuildID = ' . $_POST['GuildID'] . ' ');
	if (@mssql_num_rows($res) == 0) {
		echo 'Search returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>GuildID</th>
		<th>GuildName</th>
		<th>MasterUserID</th>
		<th>MasterName</th>
		<th>Country</th></tr>';
	while ($Row = @mssql_fetch_assoc($res)) {
		echo '<tr><td>' . $Row['GuildID'] . '</td>
		<td>' . $Row['GuildName'] . '</td>
		<td>' . $Row['MasterUserID'] . '</td>
		<td>' . $Row['MasterName'] . '</td>
		<td>' . $Bag[$Row['Country']] . '</td>
		<td><input type="radio" name="GuildID" value="' . $Row['GuildID'] . '"></td>
		</tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="SCN">';
	echo '</form>';
}
?>
<html>
<head>
<title>Disband Guild</title>
</head>
<body>
<font face="Trebuchet MS">
<center>
<br><br>
<b>Disband Guild<br>
<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
<table>
<tr><td>Guild Name:</td><td><input type="text" name="CharName"></td></tr>
</table>
<p><input type="submit" value="Submit" name="SC" /></p>
</form>
</center>
</body>
</html>