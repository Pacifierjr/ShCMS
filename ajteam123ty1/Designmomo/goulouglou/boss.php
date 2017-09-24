<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
html, body {height:100%; margin:0; padding:0;}
#page-background {position:fixed; top:0; left:0; width:100%; height:100%;}
#content {position:relative; z-index:1; padding:10px;}
body,td,th {
color: #000;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body text="#000000">
<div id="page-background"><img src="pic/i5.png" width="1920" height="1200" alt=""></div>
<div id="content">
<?php
function mssql_escape_string($data) {
if(!isset($data) or empty($data)) return '';
if(is_numeric($data)) return $data;
$non_displayables = array(
'/%0[0-8bcef]/', // url encoded 00-08, 11, 12, 14, 15
'/%1[0-9a-f]/', // url encoded 16-31
'/[\x00-\x08]/', // 00-08
'/\x0b/', // 11
'/\x0c/', // 12
'/[\x0e-\x1f]/' // 14-31
);
foreach($non_displayables as $regex)
$data = preg_replace($regex,'',$data);
$data = str_replace("'","''",$data);
return $data;
}

$host = '127.0.0.1';
$dbuser = 'sa';
$dbpass = '123456';
$database = 'PS_GameLog';
$conn = @odbc_connect("Driver={SQL Server};Server=$host;Database=$database", $dbuser, $dbpass) or die("Database Connection Error!");
$res = odbc_exec($conn, "SELECT [Text1], [Text2], [Text3], [MapID], [ActionTime] FROM ActionLog WHERE [ActionType]='173' AND [Text2]='death'");
$detail=odbc_fetch_array($res);
if (odbc_num_rows($res)==0);
else{
echo "<center>Boss records
<table cellspacing=1 cellpadding=2 border=1 style=\"border-style:hidden;\">
<tr>
<th>Who killed</th>
<th>Boss Name</th>
<th>Death Time</th>
<th>Map ID</th
</tr>";
while($row = odbc_fetch_array($res))
{
echo "<tr>";
echo "<td>". $row['Text3'] ."</td><td>". $row['Text1'] ."</td><td>". $row['ActionTime'] ."</td><td>". $row['MapID'] ."</td>";
echo "</tr>";
}
echo "</table></center>";
}
?>