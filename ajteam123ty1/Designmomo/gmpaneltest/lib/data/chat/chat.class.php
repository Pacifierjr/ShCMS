<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
    <HEAD>
        <title>Game Chats</title>
</HEAD>

 <BODY bgcolor=MediumPurple >

<?php
include "db_connect.php";
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
//AUTOREFRESH, $timer = 180 IS REFERED IN SECONDS
$ip = $_SERVER['REMOTE_ADDR'];
$timer = 180;
$gid   = 1;
$url   = $_SERVER['PHP_SELF'] . '?id=' . $gid;
Echo '<META HTTP-EQUIV="Refresh" CONTENT="' . $timer . '; URL=' . $url . '" />';
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
$timezone = 'EST';

echo "<center>";
echo "<br /><font size=5 face=comic ms color=Blue><b><i>Ce que l'on aime faire pendant que l'on ce fait chier   Lire la LOVE story <br /></font>";
echo "<i><font size=3 face=comic ms color= 8B008B>";
echo date('l j \of F Y H:i:s ');

Echo " <small><font face=arial color=green>Self Refresh - $timer Secs</font></large><br/><br/></i></b>";
echo "
<table border=0 style='table-layout:fixed' cellpadding=2 cellspacing=1><col width=100>
                <tr>
                <tr>
                    <td WIDTH=150 BGCOLOR=#FF4500><b><font size=2 face=arial color=white><b>Date a voir et a trouver comment regler</td>
                    <td WIDTH=300 BGCOLOR=#111111><font size=2 face=arial color=white><b>Light</td>
                    <td WIDTH=300 BGCOLOR=#222222><font size=2 face=arial color=white><b>Dark</td>
                </tr>
                <tr>
            </table>";
echo "<br />";
//SELECT THE LAST 1000 LINES IN THE CHAT LOG TABLE
$result = mssql_query("SELECT TOP 1000 CharID, ChatType, TargetName, ChatData, ChatTime, MapID FROM [PS_ChatLog].[dbo].[ChatLog] ORDER BY ChatTime desc ", $link);
//reate_log($gmlogin,$cook_sid_escaped,'ChatLog',"View Chat Log");
//ADDING THE PROPER COLOR AND TAG TO THE CHATS
while ($row = mssql_fetch_array($result)) {
	if ($row[1] == 1) {
		$chatcolor = "<font size=1 face=\"Trebuchet MS\" color=white>";
	} else {
		if ($row[1] == 2) {
			$chatcolor = "<font size=1 face=\"Trebuchet MS\" color=FF6666>[Whisper]";
		} else {
			if ($row[1] == 3) {
				$chatcolor = "<font size=1 face=\"Trebuchet MS\" color=pink>[Guild]";
			} else {
				if ($row[1] == 4) {
					$chatcolor = "<font size=1 face=\"Trebuchet MS\" color=7affa0>[Party]";
				} else {
					if ($row[1] == 5) {
						$chatcolor = "<font size=1 face=\"Trebuchet MS\" color=fff669>[Trade]";
					} else {
						if ($row[1] == 6) {
							$chatcolor = "<font size=1 face=\"Trebuchet MS\" color=FF0040>[Yelling]";
						} else {
							if ($row[1] == 7) {
								$chatcolor = "<font size=1 face=\"Trebuchet MS\" color=7800ff>[Area]";
							}
						}
					}
				}
			}
		}
	}
	$date = "<font size=2 face=arial color=BLue>$row[4] ";
	//ADDING NAMES AND DIVIDE LIGHTS FROM DARKS
	$light = mssql_query("SELECT CharID, CharName, Family FROM [PS_GameData].[dbo].[Chars] WHERE CharID = '$row[0]' AND Family <= 1", $link);
	$dark  = mssql_query("SELECT CharID, CharName, Family FROM [PS_GameData].[dbo].[Chars] WHERE CharID = '$row[0]' AND Family >= 2", $link);
	//ADDING THE NAME OF A PMer
	if ($row[2] <> NULL) {
		$target = "PM to $row[2]: ";
	} else {
		$target = "";
	}
	//PRINTING LIGHTS AND DARKS CHATS
	echo "
<table border=0 cellpadding=2 cellspacing=1>
<tr>
<tr>";
	echo "<td WIDTH=150 BGCOLOR=#FFD700>";
	echo "$date</td>";
	echo "<td WIDTH=300 BGCOLOR=#111111>";
	while ($row2 = mssql_fetch_array($light)) {
		echo "$chatcolor" . $row2[1] . " (map " . $row[5] . "): " . $target . "" . $row[3] . "</td>";
	}
	echo "<td WIDTH=300 BGCOLOR=#222222>";
	while ($row3 = mssql_fetch_array($dark)) {
		echo "$chatcolor" . $row3[1] . " (map " . $row[5] . "): " . $target . "" . $row[3] . "</td>";
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
?>
</BODY>
</HTML>