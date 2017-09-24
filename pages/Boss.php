<h1>Shaiya Europe Boss Record</h1>
			<center><img src="img/line.png" /></center><meta http-equiv="refresh" content="60" >
			<?php
            include("core/styles/nice_table.php");

echo '<table class="responstable">
        <tr class="boss-record">
            <th class="boss-record">Boss</th>
            <th class="boss-record">Last Boss Killer</th>
            <th class="boss-record">Next Respawn</th>
        </tr>';
		
// FROM HERE YOU CAN CHANGE ALL BOSSES; ADD MORE REMOVE; CHANGE THE TIME ETC!
// 2472 Dios
// 835  Kimu
// 1069 Pharos
// 2803 Secreta
// 1259 Sera
// 901 Fantasma Troll
// 871 Cloron Troll
// 4783 Errina

@$time = date("Y-m-d H:i:s.000");

// add here more bosses, just the MobID.
@$bosses = array(1 => '2472', '835', '1069', '871', '901', '4783', '4812');

foreach ($bosses as $key => $value) {
$query = $conn->prepare ("SELECT TOP 1 [Text1], [Text3], [ActionTime] FROM PS_GameLog.dbo.ActionLog WHERE Value3= ? AND  ActionType= 173 AND [Text2]='death' ORDER BY ActionTime DESC");
$query->bindValue(1, $value, PDO::PARAM_INT);
$query->execute();
$boss = $query->fetch(PDO::FETCH_NUM);
if ($boss[0] != NULL){
    
// WHEN YOU ADD A MOB REMEMBER TO ADD THE TIME
switch ($value){
    case 2472: $hours = 12; break;
    case 835: $hours = 8; break;
    case 1069: $hours = 6; break;
    case 871: $hours = 12; break;
    case 901: $hours = 12; break;
	case 4783: $hours = 12; break;
	case 4812: $hours = 8; break;
}
@$nextTime = date("Y-m-d H:i:s", strtotime($boss[2].'+'.$hours.' hours'));
     
if ($nextTime < $time){
   $time_Result = '<span style="color:green;">ON</span>';
} else {
    
$newTime = strtotime($nextTime);
$time1 = strtotime($time);
    
$countdown = $newTime - $time1;
$days_left = gmdate("d", $countdown);
$hours_left = gmdate("H", $countdown);
$min_left = gmdate("i", $countdown);
    
$daysstr = "day";
if ($days_left != "1"){
    $daysstr = "days";
}else{
    $daysstr = "";
    $days_left = "";
}
$hstr = "hour";
if ($hours_left != "1"){
    $hstr = "hours";
}
$mstr = "minute";
if ($min_left != "1"){
    $mstr = "minutes";
}
    
  

$time_Result = '<span style="color:red;">'.$days_left.' '.$daysstr.' '.$hours_left.' '.$hstr.' '.$min_left.' '.$mstr.' left</span>';
}
$killerchar = new Char($boss[1]);
echo '
<tr>
    <td>'.$boss[0].'</td>
    <td><a href="Account.'.$killerchar->Get("UserUID").'">'.$boss[1].'</a></td>
    <td>'.$time_Result.'</td>
</tr>';
}
}
echo '</table>';?>


		<center>	<img src="img/line.png" /></center>
