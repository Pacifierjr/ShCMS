<?php
//Connecting to database
$host = '127.0.0.1';
$user = 'sa';
$pass = '123456';
$conn = @odbc_connect("Driver={SQL Server};Server=$host;", $user, $pass) or die("Database Connection Error!");

//Setting Database Queries
$char = odbc_exec($conn,"SELECT Family,Job,Level FROM PS_GameData.dbo.Chars");
$user = odbc_exec($conn,"SELECT * FROM PS_UserData.dbo.Users_Master");
$count = odbc_num_rows(odbc_exec($conn,"SELECT * FROM PS_UserData.dbo.Users_Master WHERE JoinDate >= DATEADD(s, (".$_SERVER['REQUEST_TIME']."-86400), '19700101')"));
$mone = odbc_result(odbc_exec($conn,"SELECT SUM(CASE WHEN C.Money < 0 THEN C.Money+4294967296 ELSE C.Money END) AS Gold FROM PS_GameData.dbo.Chars C INNER JOIN PS_UserData.dbo.Users_Master U ON U.UserUID=C.UserUID WHERE U.Status=0 AND C.Money > 0"),'Gold');
$umg = odbc_exec($conn,"SELECT * FROM PS_GameData.dbo.UserMaxGrow");

//Setting variables
$users = odbc_num_rows($user);
$chars = odbc_num_rows($char);
$money = number_format($mone);
$total = odbc_num_rows($umg);
$human = $elf = $vail = $nordein = $normal = $banned = $und = $GM = $fw = $dg = $ra = $ah = $mp = $po = $fif = $thi = $six = $fury = $light = 0;

//Running the loops
while($raw = odbc_fetch_array($char)){
	switch($raw['Family'])
	{
		case 0: $human++;break;
		case 1: $elf++;break;
		case 2: $vail++;break;
		case 3: $nordein++;break;
	};
	switch($raw['Job'])
	{
		case 0: $fw++;break;
		case 1: $dg++;break;
		case 2: $ra++;break;
		case 3: $ah++;break;
		case 4: $mp++;break;
		case 5: $po++;break;
	};
	switch($raw['Level'])
	{
		case 15: $fif++;break;
		case 30: $thi++;break;
		case 70: $six++;break;
	};
};

while($raw1 = odbc_fetch_array($umg)){
	switch($raw1['Country'])
	{
		case 0: $light++;break;
		case 1: $fury++;break;
		case 2: $und++;break;
	};
};

while($raw2 = odbc_fetch_array($user)){
	switch($raw2['Status'])
	{
		case 0: $normal++;break;
		case 16: $GM++;break;
		case -5: $banned++;break;
	};
};

//Calculating percentage
$tf = round($fury * 100 / $total)."%";
$tl = round($light * 100 / $total)."%";
$tu = round($und * 100 / $total)."%";

//Showing the information
echo "<h1>Server Statistics</h1>";
echo "TIl y a ".$money."gold en circulation .<br>";
echo "En ce Momment, ".$tf." de la population du serveur est Dark, ".$tl." de la population du serveur est Light, et ".$tu." n'a pas choisi de camp.";
echo "<h1>User statistics</h1>";
echo "IL y a ".$users." Comptes en jeu.<br>";
echo $normal." est normal players. ".$banned." are banned. ".$GM." are GMs.<br>";
echo $count." users have been online in the past 24 hours.";
echo "<h1>Character Statistics</h1>";
echo "There are currently ".$chars." characters created.<br>";
echo $human." are humans. ".$elf." are elves. ".$nordein." are deatheaters. ".$vail." are vails.<br>";
echo $fw." are Fighters/Warriors. ".$dg." are Defenders/Guardians. ".$ra." are Rangers/Assassins. ".$ah." are Archers/Hunters. ".$mp." are Mages/Pagans. ".$po." are Priests/Oracles.<br>";
echo $fif." are currently level 15. ".$thi." are currently level 30. ".$six." are currently level 70.";
echo "<br><br><br>";
echo "<sub>NOTE: User and Character Statistics include GMs!</sub>";

?>