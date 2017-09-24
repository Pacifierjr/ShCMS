<?php
$host = '127.0.0.1';
$user = 'sa';
$pass = '123456';

$conn = @odbc_connect("Driver={SQL Server};Server=$host;", $user, $pass) or die("Database Connection Error!");

$res = odbc_exec($conn,"SELECT TOP 1000
	c.CharName,
	c.Str + characterItems.ConstStr + lapisSum.ConstStr AS [Str],
	c.Dex + characterItems.ConstDex + lapisSum.ConstDex AS [Dex],
	c.Rec + characterItems.ConstRec + lapisSum.ConstRec AS [Rec],
	c.Int + characterItems.ConstInt + lapisSum.ConstInt AS [Int],
	c.Wis + characterItems.ConstWis + lapisSum.ConstWis AS [Wis],
	c.Luc + characterItems.ConstLuc + lapisSum.ConstLuc AS [Luc],
	c.Str + characterItems.ConstStr + lapisSum.ConstStr + c.Dex + characterItems.ConstDex + lapisSum.ConstDex + c.Rec + characterItems.ConstRec + lapisSum.ConstRec + c.Int + characterItems.ConstInt + lapisSum.ConstInt + c.Wis + characterItems.ConstWis + lapisSum.ConstWis + c.Luc + characterItems.ConstLuc + lapisSum.ConstLuc AS TotalStat,
	c.Rec + characterItems.ConstRec + lapisSum.ConstRec + characterItems.Defense + lapisSum.Defense AS Defense,
	c.Wis + characterItems.ConstWis + lapisSum.ConstWis + characterItems.MagicResist + lapisSum.MagicResist AS MagicResist,
	characterItems.Absorb + lapisSum.Absorb AS Absorb,
	CASE
		WHEN c.Job < 3 THEN
			(c.Str + characterItems.ConstStr + lapisSum.ConstStr) * 1.3 + (c.Dex + characterItems.ConstDex + lapisSum.ConstDex) * .2 + characterItems.Attack + lapisSum.Attack
		WHEN c.Job = 3 THEN
			(c.Str + characterItems.ConstStr + lapisSum.ConstStr) + (c.Dex + characterItems.ConstDex + lapisSum.ConstDex) * .2 + (c.Luc + characterItems.ConstLuc + lapisSum.ConstLuc) * .3 + characterItems.Attack + lapisSum.Attack
		ELSE
			(c.Int + characterItems.ConstInt + lapisSum.ConstInt) + (c.Wis + characterItems.ConstWis + lapisSum.ConstWis) * .2 + characterItems.Attack + lapisSum.Attack
		END AS AttackMin,
	CASE
		WHEN c.Job < 3 THEN
			(c.Str + characterItems.ConstStr + lapisSum.ConstStr) * 1.3 + (c.Dex + characterItems.ConstDex + lapisSum.ConstDex) * .2 + characterItems.Attack + lapisSum.Attack + characterItems.AttackModifier + lapisSum.AttackModifier
		WHEN c.Job = 3 THEN
			(c.Str + characterItems.ConstStr + lapisSum.ConstStr) + (c.Dex + characterItems.ConstDex + lapisSum.ConstDex) * .2 + (c.Luc + characterItems.ConstLuc + lapisSum.ConstLuc) * .3 + characterItems.Attack + lapisSum.Attack + characterItems.AttackModifier + lapisSum.AttackModifier
		ELSE
			(c.Int + characterItems.ConstInt + lapisSum.ConstInt) + (c.Wis + characterItems.ConstWis + lapisSum.ConstWis) * .2 + characterItems.Attack + lapisSum.Attack + characterItems.AttackModifier + lapisSum.AttackModifier
		END AS AttackMax
FROM [Ps_GameData].[dbo].[Chars] c
INNER JOIN PS_UserData.dbo.Users_Master AS u ON c.UserUID = u.UserUID
INNER JOIN (
	SELECT
		DISTINCT ci.CharID AS CharID,
		SUM(i.ConstStr + CASE WHEN i.ReqWis > 0 AND LEN(ci.CraftName) = 20 THEN CONVERT(int,SUBSTRING(ci.CraftName,1,2)) ELSE 0 END) AS ConstStr,
		SUM(i.ConstDex + CASE WHEN i.ReqWis > 0 AND LEN(ci.CraftName) = 20 THEN CONVERT(int,SUBSTRING(ci.CraftName,3,2)) ELSE 0 END) AS ConstDex,
		SUM(i.ConstRec + CASE WHEN i.ReqWis > 0 AND LEN(ci.CraftName) = 20 THEN CONVERT(int,SUBSTRING(ci.CraftName,5,2)) ELSE 0 END) AS ConstRec,
		SUM(i.ConstInt + CASE WHEN i.ReqWis > 0 AND LEN(ci.CraftName) = 20 THEN CONVERT(int,SUBSTRING(ci.CraftName,7,2)) ELSE 0 END) AS ConstInt,
		SUM(i.ConstWis + CASE WHEN i.ReqWis > 0 AND LEN(ci.CraftName) = 20 THEN CONVERT(int,SUBSTRING(ci.CraftName,9,2)) ELSE 0 END) AS ConstWis,
		SUM(i.ConstLuc + CASE WHEN i.ReqWis > 0 AND LEN(ci.CraftName) = 20 THEN CONVERT(int,SUBSTRING(ci.CraftName,11,2)) ELSE 0 END) AS ConstLuc,
		SUM(i.Effect1 + CASE WHEN i.ReqWis > 0 AND LEN(ci.CraftName) = 20 AND (CONVERT(int,SUBSTRING(ci.CraftName,19,2)) BETWEEN 1 AND 20) THEN 
			CASE
				WHEN SUBSTRING(ci.CraftName,19,2) = '01' THEN 7 WHEN SUBSTRING(ci.CraftName,19,2) = '02' THEN 14 WHEN SUBSTRING(ci.CraftName,19,2) = '03' THEN 21
				WHEN SUBSTRING(ci.CraftName,19,2) = '04' THEN 31 WHEN SUBSTRING(ci.CraftName,19,2) = '05' THEN 41 WHEN SUBSTRING(ci.CraftName,19,2) = '06' THEN 51
				WHEN SUBSTRING(ci.CraftName,19,2) = '07' THEN 64 WHEN SUBSTRING(ci.CraftName,19,2) = '08' THEN 77 WHEN SUBSTRING(ci.CraftName,19,2) = '09' THEN 90
				WHEN SUBSTRING(ci.CraftName,19,2) = '10' THEN 106 WHEN SUBSTRING(ci.CraftName,19,2) = '11' THEN 122 WHEN SUBSTRING(ci.CraftName,19,2) = '12' THEN 138
				WHEN SUBSTRING(ci.CraftName,19,2) = '13' THEN 157 WHEN SUBSTRING(ci.CraftName,19,2) = '14' THEN 176 WHEN SUBSTRING(ci.CraftName,19,2) = '15' THEN 195
				WHEN SUBSTRING(ci.CraftName,19,2) = '16' THEN 217 WHEN SUBSTRING(ci.CraftName,19,2) = '17' THEN 239 WHEN SUBSTRING(ci.CraftName,19,2) = '18' THEN 261
				WHEN SUBSTRING(ci.CraftName,19,2) = '19' THEN 286 WHEN SUBSTRING(ci.CraftName,19,2) = '20' THEN 311 
			END
		ELSE 0 END) AS Attack,
		SUM(i.Effect2) AS AttackModifier,
		SUM(i.Effect3) AS Defense,
		SUM(i.Effect4) AS MagicResist,
		SUM(CASE WHEN i.ReqWis > 0 AND (CONVERT(int,SUBSTRING(ci.CraftName,19,2)) BETWEEN 51 AND 70) THEN ((CONVERT(int,SUBSTRING(ci.CraftName,19,2)) - 50) * 5) ELSE 0 END) AS Absorb
	FROM [Ps_GameData].[dbo].[CharItems] ci
		INNER JOIN [Ps_GameDefs].[dbo].Items i ON i.ItemID = ci.ItemID
	WHERE ci.Bag = 0
		AND ci.Slot >= 0
		AND ci.Slot != 13
	GROUP BY ci.CharID
) AS characterItems ON c.CharID = characterItems.CharID
LEFT JOIN (
	SELECT
		DISTINCT ci.CharID AS CharID,
		SUM(ISNULL(lapis.ConstStr,0)) AS ConstStr,
		SUM(ISNULL(lapis.ConstDex,0)) AS ConstDex,
		SUM(ISNULL(lapis.ConstRec,0)) AS ConstRec,
		SUM(ISNULL(lapis.ConstInt,0)) AS ConstInt,
		SUM(ISNULL(lapis.ConstWis,0)) AS ConstWis,
		SUM(ISNULL(lapis.ConstLuc,0)) AS ConstLuc,
		SUM(ISNULL(lapis.Effect1,0)) AS Attack,
		SUM(ISNULL(lapis.Effect2,0)) AS AttackModifier,
		SUM(ISNULL(lapis.Effect3,0)) AS Defense,
		SUM(ISNULL(lapis.Effect4,0)) AS MagicResist,
		SUM(ISNULL(lapis.Exp,0)) AS Absorb
	FROM [Ps_GameData].[dbo].[CharItems] ci
		INNER JOIN [Ps_GameDefs].[dbo].Items i ON ci.ItemID = i.ItemID
		LEFT JOIN [Ps_GameDefs].[dbo].Items lapis ON lapis.Type = 30 AND lapis.TypeID IN(ci.Gem1,ci.Gem2,ci.Gem3,ci.Gem4,ci.Gem5,ci.Gem6)
	WHERE ci.Bag = 0
		AND ci.Slot >= 0
		AND ci.Slot != 13
	GROUP BY ci.CharID
) AS lapisSum ON c.CharID = lapisSum.CharID
WHERE
	c.Del = 0
	AND u.Status = 0
ORDER BY TotalStat DESC;");

echo "<center><strong>Top Players</strong></center><br><br>
		  <center><table cellspacing=1 cellpadding=2 border=10 style=\"border-style:hidden;\">
		  <tr>
		  
		  <th>CharName</th>
		  <th>STR</th>
		  <th>DEX</th>
		  <th>REC</th>
		  <th>INT</th>
		  <th>WIS</th>
		  <th>LUC</th>
		  <th>Total Stats</th>
		  <th>Defense</th>
		  <th>Resist</th>
		  <th>Absorption</th>
		  <th>AttackMin</th>
		  <th>AttackMax</th>
		  
		  
		  </tr>";
while($row = odbc_fetch_array($res))
	{	
		echo "<tr>";
		echo "
		
		<td>". $row['CharName'] ."</td>
		<td>". $row['Str'] ."</td>
		<td>". $row['Dex'] ."</td>
		<td>". $row['Rec'] ."</td>
		<td>". $row['Int'] ."</td>
		<td>". $row['Wis'] ."</td>
		<td>". $row['Luc'] ."</td>
		<td>". $row['TotalStat'] ."</td>
		<td>". $row['Defense'] ."</td>
		<td>". $row['MagicResist'] ."</td>
		<td>". $row['Absorb'] ."</td>
		<td>". $row['AttackMin'] ."</td>
		<td>". $row['AttackMax'] ."</td>
		
		";
		echo "</tr>";
	}
		echo "</table>";
?>