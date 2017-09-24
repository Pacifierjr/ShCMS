<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$login = trim($_POST['login']);
$pass = trim($_POST['pass']);
$flag  = 0;
$class = array(
	0 => 'Warrior',
	1 => 'Guardian',
	2 => 'Assasin',
	3 => 'Hunter',
	4 => 'Pagan',
	5 => 'Oracle',
	6 => 'Fighter',
	7 => 'Defender',
	8 => 'Ranger',
	9 => 'Archer',
	10 => 'Mage',
	11 => 'Priest'
);
if (isset($_POST['submit'])) {
	if (strlen($login) < 1) {
		echo "Invalid User Name.\n ";
	}
	$res = mssql_query("SELECT * FROM [PS_userdata].[dbo].[Users_Master] WHERE UserID = '$login' and Pw = '$pass'");
	if (mssql_num_rows($res) == 0) {
		echo "User $login does not exist";
	} else {
		$res2 = mssql_query("SELECT umg.Country, c.Family, c.CharName, c.CharID, c.Job, c.Level FROM [PS_GameData].[dbo].[UserMaxGrow] AS umg 
							 INNER JOIN [PS_GameData].[dbo].[Chars] AS c ON 
							 umg.UserUID = c.UserUID WHERE c.UserID = '$login' AND c.Del=1");
		if (mssql_num_rows($res2) == 0)
			echo "Account does not contain any dead characters.";
		else {
			echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\">Select toon to resurrect :<br />
				  <input type=\"hidden\" name=\"username\" value=\"$login\">
				  <table cellspacing=1 cellpadding=2 border=1 style=\"border-style:hidden;\">
				  <tr><td>Select</td><td>CharName</td><td>Class</td><td>Level</td></tr>";
			while ($chars = mssql_fetch_array($res2)) {
				if ($chars['Country'] == 0) {
					if ($chars['Family'] == 0 || $chars['Family'] == 1) {
						echo "<tr>
						<td><input type=\"radio\" name =\"char\" value=\"" . $chars['CharName'] . "," . $chars['CharID'] . "\"></td>
						<td>" . $chars['CharName'] . "</td><td>" . $class[$chars['Job'] + 6] . "</td>
						<td>" . $chars['Level'] . "</td>
						</tr>";
					}
				} else if ($chars['Country'] == 1) {
					if ($chars['Family'] == 2 || $chars['Family'] == 3) {
						echo "<tr>
						<td><input type=\"radio\" name =\"char\" value=\"" . $chars['CharName'] . "," . $chars['CharID'] . "\"></td>
						<td>" . $chars['CharName'] . "</td><td>" . $class[$chars['Job']] . "</td>
						<td>" . $chars['Level'] . "</td>
						</tr>";
					}
				}
			}
			echo "</table><input type=\"submit\" value=\"Submit\" name=\"submit2\" /></form>";
		}
	}
} else if (isset($_POST['submit2'])) {
	$toon  = $_POST['char'];
	$login = $_POST['username'];
	$slot  = -1;
	$res1  = mssql_query("
	SELECT MIN(Slots.Slot) AS OpenSlot FROM
	(SELECT 0 AS Slot UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4) AS Slots
	LEFT JOIN
	(SELECT c.Slot
	FROM PS_UserData.dbo.Users_Master AS um
	INNER JOIN PS_GameData.dbo.Chars AS c ON c.UserUID = um.UserUID
	WHERE um.UserID = '$login'
	AND c.Del = 0) AS Chars ON Chars.Slot = Slots.Slot
	WHERE Chars.Slot IS NULL");
	$slot  = mssql_fetch_array($res1);
	$toon2 = explode(',', $toon);
	if ($slot[0] > -1 && $slot[0] < 5) {
		mssql_query("UPDATE PS_GameData.dbo.Chars SET Del=0, Slot=$slot[0], Map=42, PosX=63 , PosZ=57, DeleteDate=NULL WHERE CharID = $toon2[1]");
		$Charz = mssql_query('SELECT C.CharID,C.Family,C.Job,U.Country FROM  PS_GameData.dbo.Chars as C INNER JOIN PS_GameData.dbo.UserMaxGrow as U on UM.UserUID = C.UserUID WHERE CharName = \''.$toon.'\'');
		if (mssql_num_rows($Charz) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Rowz = mssql_fetch_assoc($Charz))
		mssql_query('UPDATE PS_GameData.dbo.Chars SET SET [Family] = (
CASE
WHEN '.$Rowz['Country'].' = 0 AND '.$Rowz['Job'].' = 0 THEN 0
WHEN '.$Rowz['Country'].' = 0 AND '.$Rowz['Job'].' = 1 THEN 0
WHEN '.$Rowz['Country'].' = 0 AND '.$Rowz['Job'].' = 2 THEN 1
WHEN '.$Rowz['Country'].' = 0 AND '.$Rowz['Job'].' = 3 THEN 1
WHEN '.$Rowz['Country'].' = 0 AND '.$Rowz['Job'].' = 4 THEN 1
WHEN '.$Rowz['Country'].' = 0 AND '.$Rowz['Job'].' = 5 THEN 0
WHEN '.$Rowz['Country'].' = 1 AND '.$Rowz['Job'].' = 0 THEN 3
WHEN '.$Rowz['Country'].' = 1 AND '.$Rowz['Job'].' = 1 THEN 3
WHEN '.$Rowz['Country'].' = 1 AND '.$Rowz['Job'].' = 2 THEN 2
WHEN '.$Rowz['Country'].' = 1 AND '.$Rowz['Job'].' = 3 THEN 3
WHEN '.$Rowz['Country'].' = 1 AND '.$Rowz['Job'].' = 4 THEN 2
WHEN '.$Rowz['Country'].' = 1 AND '.$Rowz['Job'].' = 5 THEN 2
 ELSE Family
END) ');
		echo "Toon Successfully resurrected <br /> UserID = $login<br />Slot = " . ($slot[0] + 1) . "<br />Char = $toon2[0]";
		//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $login . '\',\' Dead Toon Rez \',GETDATE())');	
	} else
		echo "No slots avaliable";
}
?>
	<html>
	<head>
	<title>Shaiya Toon Ressurection</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>Resurrect your toon<br>
	<form action="<?php
	echo $_SERVER['PHP_SELF'];
?>" method="POST">
	<table>
	<tr>
	<td>UserName:</td><td>	<input type="text" name="login" /></td></tr>
    <td>Password:</td><td>	<input type="password" name="pass" /></td>
	</tr>
	</table>
	<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>