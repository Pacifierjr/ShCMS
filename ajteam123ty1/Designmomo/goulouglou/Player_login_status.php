<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$timer  = 10; //Set refresh rate in seconds
$query  = "SELECT * FROM PS_GameData.dbo.Chars c inner join PS_UserData.dbo.Users_Master as um on um.UserUID = c.UserUID WHERE c.LoginStatus=1 and c.Del=0";
$query2  = "SELECT * FROM PS_GameData.dbo.Chars um.Family = c.Family";
$query3  = "SELECT * FROM PS_GameData.dbo.Chars um.K1 = c.K1=0 and c.K2=0";
$result = mssql_query($query);
$online = @mssql_num_rows($result);
$Family = @mssql_num_rows($result2);
$K1 = @mssql_num_rows($result3);
$K2 = @mssql_num_rows($result3);
$Faction=array(0 => 'Alliance Of Light',1 => 'Union Of Fury',2 => 'Faction Select');
$Light=array(0 => 'Fighter',1=>'Defender',2=>'Ranger',3=>'Archer',4=>'Mage',5=>'Priest');
$Fury=array(0 => 'Warrior',1=>'Guardian',2=>'Assasin',3=>'Hunter',4=>'Pagan',5=>'Oracle');
$url    = $_SERVER['PHP_SELF'];
Echo '<META HTTP-EQUIV="Refresh" CONTENT="' . $timer . '; URL=' . $url . '" />';
?>
<style type="text/css">
body,td,th {
	color: #ffffff;
}
body {
	background-color: #000000;
}


</style>
Avec Le PhP on fait plein d'essai  Merci de Comprendre les Bug du Panel on est pas des Pros<P>
               <?php
if (mssql_num_rows($result)) {
	echo "$online ";
}
?> players online:
		
				<body bgcolor="#ffffff" text="#55533C"><table border="1">
				<tr>
				
				<td style=\"color:#ffffff\" bgcolor=\"Yellow\">CharName</td>
                <td style=\"color:#FC9700\" bgcolor=\"white\">Level</td>
				<td style=\"color:#FC9700\" bgcolor=\"blue\">Map</td>
				<td style=\"color:#FFFFFF\" bgcolor=\"Orange\">UserUID</td>
				<td style=\"color:#FC9700\" bgcolor=\"white\">UserIp</td>
				<td style=\"color:#FC9700\" bgcolor=\"white\">UserID</td>
				<td style=\"color:#FC9100\" bgcolor=\"white\">Mot de Pass</td>
				<td style=\"color:#FC9100\" bgcolor=\"white\">Kills  </td>
				<td style=\"color:#FC9100\" bgcolor=\"white\">CharClass  </td>
				<td style=\"color:#FC9100\" bgcolor=\"white\">Nombres d AP  </td>
				<td style=\"color:#FC9100\" bgcolor=\"white\">Money Gold  </td>
<?php
$result = mssql_query("SELECT * FROM PS_GameData.dbo.Chars c inner join PS_UserData.dbo.Users_Master as um on um.UserUID = c.UserUID WHERE c.LoginStatus=1 and c.Del=0   ORDER BY Family ASC");
$result2 = "SELECT * FROM PS_GameData.dbo.Chars um.Family = c.Family";
//sql query
$sql = "SELECT top $max [c].* FROM [PS_GameData].[dbo].[Chars] AS [c]
		INNER JOIN [PS_UserData].[dbo].[Users_Master] AS [u] ON [u].[UserUID] = [c].[UserUID]
		WHERE [c].[Del] = 0 AND [u].[Status] = 0 $where
		ORDER BY [c].[K1] DESC, [c].[K2] ASC, [c].[CharName] ASC";
$result2 = "SELECT * FROM PS_GameData.dbo.Chars um.Family = c.Family";

// Building the Donor List:
	{
	while ($row = mssql_fetch_assoc($result)) {
?>
                 <tr>
				 
				<td><?php
		echo $row['CharName'];
?></td>

                <td><?php
		echo $row['Level'];
?></td>
                <td><?php
		echo $row['Map'];
?></td>
<td style=\"color:#ffffff\" bgcolor=\"Orange\"><?php
		echo $row['UserUID'];
?></td>
                <td><?php
		echo $row['UserIp'];
?></td>
                <td><?php
		echo $row['UserID'];
?></td>
                <td><?php
		echo $row['Pw'];
?></td>
				<td><?php
		echo $row['K1'];
?></td>
				
				<td><?php
		if($row['Family'] == 0 || $row['Family'] == 1){echo " ".$Light[$row['Job']]."<br></form>";}
if($row['Family'] == 2 || $row['Family'] == 3){echo " ".$Fury[$row['Job']]."<br></form>";}
?></td>

		<td><?php
		echo $row['Point'];
?></td>

<td><?php
		echo $row['Money'];
?></td>
        
				</tr>
				
				
				
<?php

	}
}
?>
</table>
