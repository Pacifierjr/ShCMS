<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$userid = $_POST['char'];
if (isset($_POST['submit'])) {
	if (empty($userid)) {
		die('You didn\'t specify a Character Name!');
	}
	//SECURE THE CONNECTION
	function sql_quote($value)
	{
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		//check if this function exists
		if (function_exists("mysql_real_escape_string")) {
			$value = mysql_real_escape_string($value);
		}
		//for PHP version < 4.3.0 use addslashes
		else {
			$value = addslashes($value);
		}
		return $value;
	}
	// select PS_ChatLog
	if (!@mssql_select_db("PS_ChatLog", $link)) {
		print "Failed to select database<br>";
	}
	;
	// select PS_GameData
	if (!@mssql_select_db("PS_GameData", $link)) {
		print "Failed to select database<br>";
	}
	;
	date_default_timezone_set('PST');
	echo "<center>";
	echo "<br /><font size=5 face=arial color=white><b><i>Game Chat<br /></font>";
	echo "<i><font size=3 face=arial color=aaaaaa>";
	echo date('l jS \of F Y h:i:s A');
	echo " PST<br /></font></i>";
	echo "
<table border=0 style='table-layout:fixed' cellpadding=2 cellspacing=1><col width=100>
                <tr>
                <tr>
                    <td WIDTH=100 BGCOLOR=#222222><b><font size=2 face=arial color=white><b>Date</td>
                    <td WIDTH=300 BGCOLOR=#111111><font size=2 face=arial color=white><b>Chat</td>
                </tr>
                <tr>
            </table>";
	echo "<br />";
	//SELECT LINES IN THE CHAT LOG TABLE for the specifyed Character
	$result = mssql_query('SELECT CharID, ChatType, TargetName, ChatData, ChatTime, MapID FROM [PS_ChatLog].[dbo].[ChatLog] where CharID = (select CharID FROM PS_GameData.dbo.Chars Where CharName =\'' . $userid . '\') ORDER BY row DESC', $link);
	//reate_log($gmlogin,$cook_sid_escaped,'ChatLog',"View Chat Log");
	//ADDING THE PROPER COLOR AND TAG TO THE CHATS
	while ($row = mssql_fetch_array($result)) {
		if ($row[1] == 1) {
			$chatcolor = "<font size=2 face=\"Trebuchet MS\" color=white>";
		} else {
			if ($row[1] == 2) {
				$chatcolor = "<font size=2 face=\"Trebuchet MS\" color=FF6666>[Whisper]";
			} else {
				if ($row[1] == 3) {
					$chatcolor = "<font size=2 face=\"Trebuchet MS\" color=pink>[Guild]";
				} else {
					if ($row[1] == 4) {
						$chatcolor = "<font size=2 face=\"Trebuchet MS\" color=7affa0>[Party]";
					} else {
						if ($row[1] == 5) {
							$chatcolor = "<font size=2 face=\"Trebuchet MS\" color=fff669>[Trade]";
						} else {
							if ($row[1] == 6) {
								$chatcolor = "<font size=2 face=\"Trebuchet MS\" color=FF0040>[Yelling]";
							} else {
								if ($row[1] == 7) {
									$chatcolor = "<font size=2 face=\"Trebuchet MS\" color=7800ff>[Area]";
								}
							}
						}
					}
				}
			}
		}
		$date  = "<font size=2 face=arial color=white>$row[4] ";
		//ADDING NAMES AND DIVIDE LIGHTS FROM DARKS
		$light = mssql_query("SELECT CharID, CharName, Family FROM [PS_GameData].[dbo].[Chars] WHERE CharID = '$row[0]'", $link);
		//ADDING THE NAME OF A PMer
		if ($row[2] <> NULL) {
			$target = "PM to $row[2]: ";
		} else {
			$target = "";
		}
		//PRINTING CHAT
		echo "
<table border=0 cellpadding=2 cellspacing=1>
<tr>
<tr>";
		echo "<td WIDTH=100 BGCOLOR=#222222>";
		echo "$date</td>";
		echo "<td WIDTH=300 BGCOLOR=#111111>";
		while ($row2 = mssql_fetch_array($light)) {
			echo "$chatcolor" . $row2[1] . " (map " . $row[5] . "): " . $target . "" . $row[3] . "</td>";
		}
		echo "
</tr>
<tr>
</table>";
	}
	echo "</center>";
	@mssql_free_result($result);
	@mssql_free_result($light);
	@mssql_free_result($dark);
	mssql_close($link);
	//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $userid . '\',\' Chat Search for '. $userid.'  \',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $userid . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $userid . '\'');
}
?>
<html>
<head>
<title>Character Chat Search</title>
</head>
<body>
<font face="Trebuchet MS">
<center>
<br><br>
<b>Character Chat Search<br>
<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
 <table>
    <tr><td>CharName:</td><td><input type="text" name="char"/></td></tr>
	</table>
<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>