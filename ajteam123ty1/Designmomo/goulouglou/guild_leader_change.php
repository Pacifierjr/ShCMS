<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$guild = trim($_POST['guild']);
$flag  = 0;
if (isset($_POST['submit'])) {
	if (strlen($guild) < 1) {
		echo "Invalid Guild Name.\n ";
	}
	//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\''. $guild .'\',\'Guild Lead Change. \',GETDATE())');
	$res = mssql_query("SELECT g.MasterName,g.GuildID,c.CharName,c.UserUID,c.UserID,c.CharID FROM PS_GameData.dbo.chars as c
						inner join PS_GameData.dbo.GuildChars as gc 
						on c.charid=gc.charid
						inner join ps_gamedata.dbo.guilds as g
						on gc.guildid=g.guildid
						where gc.guildlevel=2 and g.guildname = '$guild'");
	if (mssql_num_rows($res) == 0) {
		echo "Guild '$guild' does not exist";
	} else {
		$chars = mssql_fetch_array($res);
		echo "<font face=\"Trebuchet MS\"><form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\">Select New Leader :
			<input type=\"hidden\" name=\"guild\" value=\"$guild\">
			<input type=\"hidden\" name=\"guild-id\" value =\"" . $chars['GuildID'] . "\">
			<input type=\"hidden\" name=\"oldlead\" value=\"" . $chars['MasterName'] . "\">
			<select name=\"newlead\" width=\"20\" style=\"width: 100px\">";
		echo "<option value=\"" . $chars['UserUID'] . "," . $chars['UserID'] . "," . $chars['CharName'] . "," . $chars['CharID'] . "\">" . $chars['CharName'] . "</option>";
		while ($chars = mssql_fetch_array($res)) {
			echo "<option value=\"" . $chars['UserUID'] . "," . $chars['UserID'] . "," . $chars['CharName'] . "," . $chars['CharID'] . "\">" . $chars['CharName'] . "</option>";
		}
		echo "</select><input type=\"submit\" value=\"Submit\" name=\"submit2\" /></form></font>";
	}
} else if (isset($_POST['submit2'])) {
	$newlead = $_POST['newlead'];
	$oldlead = $_POST['oldlead'];
	$guild   = $_POST['guild'];
	$guildid = $_POST['guild-id'];
	$newlead = explode(',', $newlead);
	echo "<font face=\"Trebuchet MS\">Guild = $guild<br />Old Leader = $oldlead<br />New Leader = $newlead[2]";
	mssql_query("UPDATE PS_GameData.dbo.GuildChars SET GuildLevel=8 WHERE GuildLevel=1 and GuildID='$guildid'");
	mssql_query("UPDATE PS_GameData.dbo.Guilds SET MasterUserID='$newlead[1]', MasterCharID=$newlead[3],MasterName='$newlead[2]' WHERE GuildName='$guild'");
	mssql_query("UPDATE PS_GameData.dbo.GuildChars SET GuildLevel=1 WHERE CharID='$newlead[3]'");
}
?>
	<html>
	<head>
	<title>Guild Leader Change</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>Guild Leader Change<br>
	<form action="<?php
	echo $_SERVER['PHP_SELF'];
?>" method="POST">
	<table>
	<tr>
	<td>Guild Name:</td><td><input type="text" name="guild" /></td>
	</tr>
	</table>
	<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>