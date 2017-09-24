<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$query  = "SELECT * FROM GM_Stuff.dbo.StatPadder ";
$result = mssql_query($query);
$online = @mssql_num_rows($result);
?>
<style type="text/css">
body,td,th {
	color: #FFF;
}
body {
	background-color: #000;
}
</style>

              <b> <?php
if (mssql_num_rows($result)) {
	echo "$online ";
}
?> Posable Stat Padders</b>
		
				<body bgcolor="#000000" text="#FFFFFF"><table border="3">
				<tr>
				<td>Killer's Toon</td>
                <td>Killer's IP</td>
                <td>Killer's ID</td>
                <td>Dead Toon</td>
                <td>Dead Toon's IP</td>
                <td>Dead Toon's ID</td>
                <td>Date</td>
                <td>Map</td></tr>
<?php
// Building the Donor List:
	{
	while ($row = mssql_fetch_assoc($result)) {
?>
                 <tr>
                <td><?php
		echo $row['KillerToon'];
?></td>
                <td><?php
		echo $row['KillerIP'];
?></td>
                <td><?php
		echo $row['KillerID'];
?></td>
                <td><?php
		echo $row['DeadToon'];
?></td>
				<td><?php
		echo $row['DeadIP'];
?></td>
                <td><?php
		echo $row['DeadID'];
?></td>
                <td><?php
		echo $row['Date'];
?></td>
                <td><?php
		echo $row['Map'];
?></td>
				</tr>
<?php
	}
}
?>
</table>
