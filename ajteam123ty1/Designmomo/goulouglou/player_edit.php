<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$char  = trim($_REQUEST['char']);
$count = 0;
if ((isset($_POST['submit'])) || strlen($char) > 1) {
	if (strlen($char) < 1) {
		die("Invalid Char Name.\n ");
	}
	//create_log
		
	$res     = mssql_query("SELECT * FROM [PS_GameData].[dbo].[Chars] WHERE CharName = '$char'");
	$detail  = mssql_fetch_array($res);
	$list    = array(
		3,
		4,
		6,
		7,
		13,
		14,
		15,
		16,
		17,
		18,
		19,
		20,
		21,
		22,
		23,
		27,
		29,
		30,
		31,
		32,
		33,
		39,
		40,
		43,
		44
	);
	$coloums = array(
		'UserID',
		'UserUID',
		'CharID',
		'CharName',
		'Slot',
		'Family',
		'Grow',
		'Hair',
		'Face',
		'Size',
		'Job',
		'Sex',
		'Level',
		'StatPoint',
		'SkillPoint',
		'Str',
		'Dex',
		'Rec',
		'Int',
		'Luc',
		'Wis',
		'Map',
		'Dir',
		'Exp',
		'Money',
		'PosX',
		'PosY',
		'Posz',
		'K1',
		'K2',
		'K3',
		'K4',
		'KillLevel',
		'DeadLevel',
		'OldCharName'
	);
	$greyed  = array(
		'UserID',
		'UserUID',
		'CharID',
		'Family',
		'Slot'
	);
	if (mssql_num_rows($res) == 0) {
		die("User $char does not exist");
	} else {
		echo "Current Status of $char <form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\"><font face=\"Trebuchet MS\">

			<table cellspacing=1 cellpadding=2 border=1 style=\"border-style:hidden;\">
			<tr><td>NO.</td><td>Name</td><td>Value</td>";
		foreach ($coloums as $value) {
			echo "<tr>
				<td>$count</td>
				<td>$value :</td>";
			if (in_array($value, $greyed))
				echo "<td><input type=\"text\" readonly=\"readonly\" style=\"background:#D0D0D0;\" name=\"$value\" value=\"$detail[$value]\" /></td></tr>";
			else
				echo "<td><input type=\"text\" name=\"$value\" value=\"$detail[$value]\" /></td></tr>";
			$count++;
		}
		echo "</table><input type=\"submit\" name=\"submit2\" value=\"Submit\"></form></font>";
	}
} else if (isset($_POST['submit2'])) {
	$charid  = $_POST['CharID'];
	$coloums = array(
		'CharName',
		'Grow',
		'Hair',
		'Face',
		'Size',
		'Job',
		'Sex',
		'Level',
		'StatPoint',
		'SkillPoint',
		'Str',
		'Dex',
		'Rec',
		'Int',
		'Luc',
		'Wis',
		'Map',
		'Dir',
		'Exp',
		'Money',
		'PosX',
		'PosY',
		'Posz',
		'K1',
		'K2',
		'K3',
		'K4',
		'KillLevel',
		'DeadLevel',
		'OldCharName'
	);
	foreach ($coloums as $value) {
		mssql_query('UPDATE PS_GameData.dbo.Chars SET CharName = \'' . $_POST['CharName'] . '\',Grow = \'' . $_POST['Grow'] . '\',Hair = \'' . $_POST['Hair'] . '\',Face = \'' . $_POST['Face'] . '\',Size = \'' . $_POST['Size'] . '\',Job = \'' . $_POST['Job'] . '\',Sex = \'' . $_POST['Sex'] . '\',Level = \'' . $_POST['Level'] . '\',StatPoint = \'' . $_POST['StatPoint'] . '\',SkillPoint = \'' . $_POST['SkillPoint'] . '\',Str = \'' . $_POST['Str'] . '\',Dex = \'' . $_POST['Dex'] . '\',Rec = \'' . $_POST['Rec'] . '\',Int = \'' . $_POST['Int'] . '\',Luc = \'' . $_POST['Luc'] . '\',Wis = \'' . $_POST['Wis'] . '\',Map = \'' . $_POST['Map'] . '\',Dir = \'' . $_POST['Dir'] . '\',Exp = \'' . $_POST['Exp'] . '\',Money = \'' . $_POST['Money'] . '\',PosX = \'' . $_POST['PosX'] . '\',PosY = \'' . $_POST['PosY'] . '\',PosZ = \'' . $_POST['PosZ'] . '\',K1 = \'' . $_POST['K1'] . '\',K2 = \'' . $_POST['K2'] . '\',K3 = \'' . $_POST['K3'] . '\',K4 = \'' . $_POST['K4'] . '\',KillLevel = \'' . $_POST['KillLevel'] . '\',DeadLevel = \'' . $_POST['DeadLevel'] . '\',OldCharName = \'' . $_POST['OldCharName'] . '\' WHERE CharID=\'' . $_POST['CharID'] . '\'');
		//mssql_query("UPDATE PS_GameData.dbo.Chars SET $value=\''$_REQUEST[$value]'\' WHERE CharID=$charid");
		echo "</html>";
	}
	foreach ($_POST as $Name => $Value) {
		echo $Name . '=' . $Value . '<br>';
	}
}
?>
	<html>
	<head>
	<title>Edit Player</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>Edit Player<br>
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

