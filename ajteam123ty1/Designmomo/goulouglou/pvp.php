<?php

//initialize variables
$page		= 1;
$persite	= 25;
$cssicon	= 0;
$cssjob		= 0;
$where		= '';
$addlink	= '';
$maxlevel	= 90; //just for a html output
$scripturl	= $_SERVER['PHP_SELF'];
$pvp		= 4;

//change to your timezone


//the most sql drivers are buggy, use this as a little fix
function _odbc_num_rows($res){
	$rows = 0;
	while (odbc_fetch_array($res)){
		$rows++;
	}
	return $rows;
}

//function for showing next pages
function pages($seite, $maxseite, $url = "", $anzahl = 4, $get_name = "page"){ 
	if (preg_match("/\?/", $url))
		$anhang = "&amp;";
	else
		$anhang = "?";

	if (substr($url, -1, 1) == "&")
		$url = substr_replace($url, "", -1, 1);
	else if (substr($url, -1, 1) == "?") {
		$anhang	= "?";
		$url	= substr_replace($url, "" , -1, 1);
	}

	if ($anzahl%2 != 0)
		$anzahl++; //Wenn $anzahl ungeraden, dann $anzahl++ 

	$a			= $seite - ($anzahl/2);
	$b			= 0;
	$blaetter	= array();
	
	while ($b <= $anzahl){ 
		if ($a > 0 && $a <= $maxseite){ 
			$blaetter[] = $a; 
			$b++; 
		} 
		else if ($a > $maxseite && ($a-$anzahl-2)>=0){ 
			$blaetter = array(); 
			$a -= ($anzahl+2); 
			$b = 0; 
		} 
		else if ($a > $maxseite && ($a-$anzahl-2)<0) { 
			break; 
		} 

		$a++; 
	}
	
	$return = ""; 
	
	if (!in_array(1, $blaetter) && count($blaetter) > 1){ 
		if (!in_array(2, $blaetter)) 
			$return .= "&nbsp;<div style=\"display: inline; position: relative; top: 5px;\"><a href=\"{$url}{$anhang}{$get_name}=1\"><img src=\"left.png\" alt=\"\"></a></div>"; 
		else 
			$return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}=1\">1</a>&nbsp;"; 
	} 

	foreach ($blaetter as $blatt){ 
		if ($blatt == $seite) 
			$return .= "&nbsp;<b>$blatt</b>&nbsp;"; 
		else
			$return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}=$blatt\">$blatt</a>&nbsp;"; 
	} 

	if (!in_array($maxseite, $blaetter) && count($blaetter) > 1) { 
		if (!in_array(($maxseite-1), $blaetter)) 
			$return .= "&nbsp;<div style=\"display: inline; position: relative; top: 5px;\"><a href=\"{$url}{$anhang}{$get_name}=$maxseite\"><img src=\"next.png\" alt=\"\"></a></div>&nbsp;"; 
		else
			$return .= "&nbsp;<a href=\"{$url}{$anhang}{$get_name}=$maxseite\">$maxseite</a>&nbsp;"; 
	} 

	if (empty($return)) 
		return  "&nbsp;<b>1</b>&nbsp;"; 
	else 
		return $return; 
} 

//include guild class
require_once('guild.class.php');

//connect to database
if (!$link = @odbc_connect("Driver={SQL Server};Server=127.0.0.1;", 'sa', '123456'))
	die ("Couln't connect to Database.");

//check level area
if (isset($_GET['pvp']) && !empty($_GET['pvp']) && preg_match('#^[0-9]*$#', $_GET['pvp'])){
	$pvp = $_GET['pvp'];
	
	if ($pvp == 1)
		$where = 'AND [c].[Level] BETWEEN 1 AND 15';
	else if ($pvp == 2)
		$where = 'AND [c].[Level] BETWEEN 16 AND 30';
	else if ($pvp == 3)
		$where = 'AND [c].[Level] > 31';
}

//check current page
if (isset($_GET['page']) && !empty($_GET['page']) && preg_match('#^[0-9]*$#', $_GET['page'])){
	$page		= $_GET['page'];
	$addlink	= '&amp;page='.$page;
}

//calculate begin and end
$begin	= ($page - 1) * $persite;
$max	= $page * $persite;

//output HTML
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
	  <html>
	  <head>
		<title>PvP Ranking</title>
		<link rel="stylesheet" type="text/css" href="pvp.css">
	  </head>
	  <body>
		<script type="text/javascript" src="wz_tooltip.js"></script>
		<center>';

//output links for level area
echo '<a href="'.$scripturl.'?pvp=1'.$addlink.'">1-15</a>';
echo '<div style="padding-left: 30px; display: inline;"></div>';
echo '<a href="'.$scripturl.'?pvp=2'.$addlink.'">16-30</a>';
echo '<div style="padding-left: 30px; display: inline;"></div>';
echo '<a href="'.$scripturl.'?pvp=3'.$addlink.'">31-'.$maxlevel.'</a>';
echo '<div style="padding-left: 30px; display: inline;"></div>';
echo '<a href="'.$scripturl.'?pvp=4'.$addlink.'">All</a>';
echo "\n<br>\n";
echo "<br>\n";

//output table header
echo '<table border=0 cellspacing=5 cellpadding=1>
		<tr>
			<th>Rank</th>
			<th>Name</th>
			<th>Job</th>
			<th>Level</th>
			<th>Faction</th>
			<th>Guild</th>
			<th>Status</th>
			<th>Map</th>
			<th>Kills</th>
			<th>Death</th>
			<th>KDR</th>
			<th>Icon</th>
		</tr>';
	  
//sql query
$sql = "SELECT top $max [c].* FROM [PS_GameData].[dbo].[Chars] AS [c]
		INNER JOIN [PS_UserData].[dbo].[Users_Master] AS [u] ON [u].[UserUID] = [c].[UserUID]
		WHERE [c].[Del] = 0 AND [u].[Status] = 0 $where
		ORDER BY [c].[K1] DESC, [c].[K2] ASC, [c].[CharName] ASC";
$res = odbc_exec($link, $sql);

for ($i = 1; $char = odbc_fetch_array($res); $i++){
	if ($i >= $begin) {
		$cssjob = $char['Job'] + 17;
		
		//light or dark
		if ($char['Family'] < 2)
			$faction = '<font color="#FFE4E1">Light</font>';
		else
			$faction = '<font color="#000000">Dark</font>';
		
		//guild
		$gsql = "SELECT [GuildID] FROM [PS_GameData].[dbo].[GuildChars] WHERE [CharID] = '".$char['CharID']."' AND [Del] = 0";
		$gres = odbc_exec($link, $gsql);
		
		if (_odbc_num_rows($gres) == 1){
			//get a new odbc result
			$gsql = "SELECT [GuildID] FROM [PS_GameData].[dbo].[GuildChars] WHERE [CharID] = '".$char['CharID']."' AND [Del] = 0";
			$gres = odbc_exec($link, $gsql);
			$gfet	= odbc_fetch_array($gres);
			$guild	= new guild($gfet['GuildID'], $link);
		}
		else
			$guild = false;
			
		//online status
		if (isset($char['LoginStatus'])){
			if ($char['LoginStatus'] == 0)
				$online = '<font color="#FF0000">Offline</font>';
			else
				$online = '<font color="#00FF00">Online</font>';
		}
		else
			$online = '<font color="#696969">Unknown</font>';
		
		//map
		$maps = array('D-Water', 'Erina', 'Reikeuseu', 'D-Water', 'D-Water', "Cornwell's Ruin", "Cornwell's Ruin", 'Argilla Ruin', 'Argilla Ruin', // [8]
					  'D-Water', 'D-Water', 'D-Water', "Cloron's Lair", "Cloron's Lair", "Cloron's Lair", "Fantasma's Lair", "Fantasma's Lair", // [16]
					  "Fantasma's Lair", 'Proelium', 'Willieoseu', 'Keuraijen', 'Maytreyan', 'Maytreyan', 'Aidion Nekria', 'Aidion Nekria', // [24]
					  'Elemental Cave', 'Ruber Chaos', 'Ruber Chaos', 'Adellia', 'Adeurian', 'Cantabilian', 'Paros Temple', 'Rapioru Maze', // [32]
					  'Fedion Temple', 'Khalamus House', 'Apulune', 'Iris', 'Cave of Stigma', 'Aurizen Ruin', 'Secret Battle Arena', // [39]
					  'Underground Stadium', 'Prison', 'Auction House', 'Skulleron', 'Astenes', 'Deep Desert 1', 'Deep Desert 2', 'Stable Erde', // [47]
					  'Cryptic Throne', 'Cryptic Throne', 'GRB', 'Guild House', 'Guild House', 'Guild Management Office', 'Guild Management Office', // [54]
					  'Sky City', 'Sky City', 'Sky City', 'Sky City', 'Fedion Temple', 'Elemental Cave', 'Cave of Stigm', 'Khalamus House', 'Aurizen Ruin', // [63]
					  'Oblivion Insula', 'Caelum Sacra', 'Caelum Sacra', 'Caelum Sacra', 'Valdemar Regnum', 'Palaion Regnum', 'Kanos Illium', 'Queen Servus', 
					  'Queen Caput');
		
		if ($char['Map'] > (count($maps) - 1))
			$map = 'Unknown';
		else
			$map = $maps[$char['Map']];
		
		//KDR
		if ($char['K2'] == 0)
			$kdr = $char['K1'];

			
		else
			$kdr = number_format($char['K1']/$char['K2'], 2, '.', '');
			$kdr = '<font color="# 	00FFFF">La-Aussi</font>';
			$char['K2'] = '<font color="#7B68EE">tuverapas</font>';
		
		if ($char['K1'] >= 200000)
			$cssicon = 16;
		else if ($char['K1'] >= 150000)
			$cssicon = 15;
		else if ($char['K1'] >= 130000)
			$cssicon = 14;
		else if ($char['K1'] >= 110000)
			$cssicon = 13;
		else if ($char['K1'] >= 90000)
			$cssicon = 12;
		else if ($char['K1'] >= 70000)
			$cssicon = 11;
		else if ($char['K1'] >= 50000)
			$cssicon = 10;
		else if ($char['K1'] >= 40000)
			$cssicon = 9;
		else if ($char['K1'] >= 30000)
			$cssicon = 8;
		else if ($char['K1'] >= 20000)
			$cssicon = 7;
		else if ($char['K1'] >= 10000)
			$cssicon = 6;
		else if ($char['K1'] >= 5000)
			$cssicon = 5;
		else if ($char['K1'] >= 1000)
			$cssicon = 4;
		else if ($char['K1'] >= 300)
			$cssicon = 3;
		else if ($char['K1'] >= 50)
			$cssicon = 2;
		else if ($char['K1'] >= 1)
			$cssicon = 1;
		else
			$cssicon = 0;
		
		//output
		echo '<tr>';
		echo '<td class="center">'.$i.'</td>';
		echo '<td class="center">'.$char['CharName'].'</td>';
		echo '<td class="i'.$cssjob.'"></td>';
		echo '<td class="center">'.$char['Level'].'</td>';
		echo '<td class="center">'.$faction.'</td>';
		if ($guild != false)
			echo '<td><center><div style="display: inline;" onmouseover=\'Tip("'.$guild->getToolTipHtml().'")\' onmouseout="UnTip()">'.$guild->getName().'</center></td>';
		else
			echo '<td></td>';
		echo '<td class="center">'.$online.'</td>';
		echo '<td class="center">'.$map.'</td>';
		echo '<td class="center">'.$char['K1'].'</td>';
		echo '<td class="center">'.$char['K2'].'</td>';
		echo '<td class="center">'.$kdr.'</td>';
		echo '<td class="i'.$cssicon.'"></td>';
		echo '</tr>'."\n";
	}
}

echo '</table>';

//show next pages
$csql = "SELECT Count([c].[CharID]) AS [Count] FROM [PS_GameData].[dbo].[Chars] AS [c]
		 INNER JOIN [PS_UserData].[dbo].[Users_Master] AS [u] ON [u].[UserUID] = [c].[UserUID]
		 WHERE [c].[Del] = 0 AND [u].[Status] = 0 $where";
$cres = odbc_exec($link, $csql);
$cfet = odbc_fetch_array($cres);


$ccount = $cfet['Count'];
$cpages = $ccount/$persite;

echo pages($page,  ceil($cpages), $url=$scripturl.'?pvp='.$pvp);

?>