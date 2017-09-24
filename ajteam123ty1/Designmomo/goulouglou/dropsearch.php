<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_POST['SCN'])) {
	echo " <b>Select the check box next to the row with the Mob Name you wish to search and hit submit on bottom of the page under this tabel to display ALL Items that drop From the specific mob and a rouph %.</b>";
	if (!isset($_POST['MobID'])) {
		die('You didn\'t select an item!');
	}
	$res = mssql_query('SELECT DISTINCT m.ItemName,m.Grade,m.ItemID,mi.DropRate,mi.MobID,mi.ItemOrder FROM PS_GameDefs.dbo.Items m inner join PS_GameDefs.dbo.MobItems  mi on mi.Grade = m.Grade Where mi.MobID = \'' . $_POST['MobID'] . '\' AND m.ItemName NOT LIKE "%"+"???"+"%"');
	if (mssql_num_rows($res) == 0) {
		echo 'Search returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>Item Name</th>
		<th>Drop Rate</th>
		</tr>';
	while ($Row = @mssql_fetch_assoc($res)) {
		echo '<tr><td>' . $Row['ItemName'] . '</td>
		   <td>' . $Row['DropRate'] . '%</td>
		</tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="CNE">';
	echo '</form>';
} elseif (isset($_POST['SC'])) {
	echo " <b>Select the check box next to the row with the Item Name you wish to search and hit submit button on bottom of the page under this tabel to display ALL Mob's that drop the Item and a rouph %.</b>";
	$Chars = mssql_query('SELECT DISTINCT ItemName,ItemID FROM PS_GameDefs.dbo.Items WHERE ItemName LIKE "%"+\'' . $_POST['item'] . '\'+"%" ORDER BY ItemID');
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>Item</th>
		<th>Select</th></tr>';
	while ($row = mssql_fetch_assoc($Chars)) {
		echo '<tr><td>' . $row['ItemName'] . '</td>
	<td><input type="radio" name="ItemID" value="' . $row['ItemID'] . '"></td></tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="SCI">';
	echo '</form>';
} elseif (isset($_POST['SCI'])) {
	echo " <b>Select the check box next to the row with the Mob Name you wish to search and hit submit on bottom of the page under this tabel to display ALL Items that drop From the specific mob and a rouph %.</b>";
	if (!isset($_POST['ItemID'])) {
		die('You didn\'t select an item!');
	}
	$res = mssql_query('SELECT DISTINCT m.MobName,m.MobID,mi.Grade,mi.DropRate FROM PS_GameDefs.dbo.Mobs m inner join PS_GameDefs.dbo.MobItems  mi on mi.MobID = m.MobID inner join PS_GameDefs.dbo.Items i on mi.Grade = i.Grade Where i.ItemID = ' . $_POST['ItemID'] . ' order by m.MobID');
	if (mssql_num_rows($res) == 0) {
		echo 'Search returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>MobName</th>
		<th>Drop Rate</th>
		<th>Select</th>
		</tr>';
	while ($Row = @mssql_fetch_assoc($res)) {
		echo '<tr><td>' . $Row['MobName'] . '</td>
		   <td>' . $Row['DropRate'] . '%</td>
		<td><input type="radio" name="MobID" value="' . $row['MobID'] . '"></td></tr>';
	}
	echo '</table>';
	echo '<input type="Submit" value="Submit" name="SCN">';
	echo '</form>';
}
?>
<html>
<head>
<title>Drop Search</title>
</head>
<body>
<font face="Trebuchet MS">
<center>
<br><br>
<b>Drop Search</b>
<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
<table>
<tr><td>Item Name:</td><td><input type="text" name="item" /></td></tr>
</table>
<b>Dosen't have to be Spelt exactly how it apears in game</b>
<p><input type="submit" value="Submit" name="SC" /></p>
</form>
</center>
</body>
</html>