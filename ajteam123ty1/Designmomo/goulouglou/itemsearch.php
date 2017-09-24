<?php
include "db_connect.php";
$ip = $_SERVER['REMOTE_ADDR'];
$char  = '???';
$count = 0;
if (isset($_POST['submit'])) {
	$res = mssql_query('SELECT * FROM PS_GameDefs.dbo.Items WHERE Type = ' . $_POST['ItemID'] . ' AND ItemName NOT LIKE  "%"+\'' . $char . '\'+"%"  ORDER BY ItemID');
	if (mssql_num_rows($res) == 0) {
		echo 'Search returned no results.';
	}
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="1"><tr>
		<th>ItemName</th>
		<th>ItemID</th>
		<th>Type</th>
		<th>TypeID</th></tr>';
	while ($Row = mssql_fetch_assoc($res)) {
		echo '<tr><td>' . $Row['ItemName'] . '</td>
		<td>' . $Row['ItemID'] . '</td>
		<td>' . $Row['Type'] . '</td>
		<td>' . $Row['TypeID'] . '</td>
		</tr>';
	}
	echo '</table>';
	echo '</form>';
}
?>
	<html>
	<head>
	<title>Item Search By Catagory</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>Item Search By Catagory<br>
	<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
	<table>
    <tr><td>Item Catagory:</td><td>
<select name="ItemID">
<option value="1">1 Handed Sword</option>
<option value="2">2 Handed Sword</option>
<option value="3">1 Handed Axe</option>
<option value="4">2 Handed Sword</option>
<option value="5">Duel Swords/Axes</option>
<option value="6">Spears</option>
<option value="7">1 Handed Blunts</option>
<option value="8">2 Handed Blunts</option>
<option value="9">1 Handed Dagger</option>
<option value="10">Dagger</option>
<option value="11">Javelings</option>
<option value="12">Staffs</option>
<option value="13">Bow</option>
<option value="14">Crossbows</option>
<option value="15">Claws</option>
<option value="16">AOL Helms</option>
<option value="17">AOL Tops</option>
<option value="18">AOL Pants</option>
<option value="19">AOL Shields</option>
<option value="20">AOL Gaunts</option>
<option value="21">Aol Boots</option>
<option value="22">Rings</option>
<option value="23">Amulets</option>
<option value="24">AOL Caps/Dashing Extream</option>
<option value="25">Potions / Enchant Items</option>
<option value="27">Quest Items</option>
<option value="28">More Quest Items</option>
<option value="29">More Quest Items</option>
<option value="30">Lapis</option>
<option value="31">UOF Helms</option>
<option value="32">UOF Tops</option>
<option value="33">UOF Pants</option>
<option value="34">UOF Shields</option>
<option value="35">UOF Gaunts</option>
<option value="36">UOF Boots</option>
<option value="38">EP5 Enchant Items</option>
<option value="39">Fury Caps</option>
<option value="40">Loops</option>
<option value="42">Mounts</option>
<option value="43">Etin</option>
<option value="44">Few Enchants/Quest Items</option>
<option value="94">Gold Bars</option>
<option value="95">Lapisia</option>
<option value="100">DP Items</option>
</select></td></tr>
	</table>
	<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>