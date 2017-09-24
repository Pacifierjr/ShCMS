<?php
/// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
if(isset($_POST['SCN'])){
$Set = false; //Change to True to have it based off ReqWis, false for custom input.
$Armor = array(16,17,18,19,20,21,31,32,33,34,35,36,67,68,69,70,71,82,83,84,85);
$Long = @mssql_query('SELECT c.Count,c.ItemID,c.Type,c.TypeID,c.Gem1,c.Gem2,c.Gem3,c.Gem4,c.Gem5,Gem6,SUBSTRING(c.Craftname, 1, 2) AS "Str",SUBSTRING(c.Craftname, 3, 2) AS "Dex",SUBSTRING(c.Craftname, 5, 2) AS "Rec",
SUBSTRING(c.Craftname, 7, 2) AS "Int",SUBSTRING(c.Craftname, 9, 2) AS "Wis",SUBSTRING(c.Craftname, 11, 2) AS "Luc",
SUBSTRING(c.Craftname, 13, 2) AS "HP",SUBSTRING(c.Craftname, 15, 2) AS "MP",SUBSTRING(c.Craftname, 17, 2) AS "SP",
SUBSTRING(c.Craftname, 19, 2) AS "Enchant",c.ItemUID,I.ItemName,I.ReqWis,I.Type
FROM PS_GameData.dbo.CharItems c
INNER JOIN PS_GameDefs.dbo.Items I ON I.ItemID=c.ItemID
WHERE c.ItemUID='.$_POST['ItemUID'].'');
$Result = @mssql_fetch_assoc($Long);
$Fields = array('ItemName','ItemUID','ItemID','Type','TypeID','Gem1','Gem2','Gem3','Gem4','Gem5','Gem6','Str','Dex','Rec','Int','Wis','Luc','HP','MP','SP','Enchant','Count');
$NoEdit = array('ItemName','ItemUID');
echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
echo 'IF Weapon Enchant = 1-50<p>If Gear Enchant = 51-99<p> Gem = slots Use TypeID of the lapis to link<p> IE: Max craft = 30007 so Gem would be 7!!';
echo '<table border="1">';
foreach($Fields as $Columns){
echo '<tr><th>'.$Columns.'</th>';
if(in_array($Columns,$NoEdit)){
echo '<th><input type="text" value="'.$Result[$Columns].'" name="'.$Columns.'" style="background:#D0D0D0;" READONLY></th>';}
else{
if($Set){
if($Columns == 'Enchant'){
echo'<td><select style="width:100%;" name="'.$Columns.'">';
echo '<option value="00">00</option>';
if(in_array($Result['Type'],$Armor)){
for($e=50;$e <= 70; $e++){
if($e == $Result[$Columns]){echo '<option value="'.$e.'" selected>'.$e.'</option>';}
echo '<option value="'.$e.'">'.$e.'</option>';}
}else{
for($a=1;$a <= 20; $a++){
$a = str_pad($a,2,0,STR_PAD_LEFT);
if($a == $Result[$Columns]){echo '<option value="'.$a.'" selected>'.$a.'</option>';}
echo '<option value="'.$a.'">'.$a.'</option>';}
}
echo '</select></td>';
}else{
echo'<td><select style="width:100%;" name="'.$Columns.'">';
for($i=0; $i <= $Result['ReqWis']; $i++){
$i = str_pad($i,2,0,STR_PAD_LEFT);
if($i == $Result[$Columns]){
echo '<option value="'.$i.'" selected>'.$i.'</option>';}else{
echo '<option value="'.$i.'">'.$i.'</option>';
}}
echo '</select></td>';
}}else{
echo '<th><input type="text" name="'.$Columns.'" value="'.$Result[$Columns].'" /></th>';
}}
echo '</tr>';
}
echo '</table>';
echo '<input type="Submit" value="Submit" name="CNE">';
echo '</form>';
}


elseif(isset($_POST['CNE'])){
$Craftname=$_POST['Str'].$_POST['Dex'].$_POST['Rec'].$_POST['Int'].$_POST['Wis'].$_POST['Luc'];
$Craftname.=$_POST['HP'].$_POST['MP'].$_POST['SP'].$_POST['Enchant'];
@mssql_query('UPDATE PS_GameData.dbo.CharItems SET ItemID = '.$_POST['ItemID'].',Type = '.$_POST['Type'].', TypeID = '.$_POST['TypeID'].', Gem1 = '.$_POST['Gem1'].', Gem2 = '.$_POST['Gem2'].', Gem3 = '.$_POST['Gem3'].', Gem4 = '.$_POST['Gem4'].', Gem5 = '.$_POST['Gem5'].', Gem6 = '.$_POST['Gem6'].', Count = '.$_POST['Count'].',Craftname=\''.$Craftname.'\' WHERE ItemUID='.$_POST['ItemUID'].'');
foreach($_POST as $Name => $Value){
echo $Name.'=>'.$Value.'<br>';
}
}

elseif(isset($_POST['SC'])){
if(empty($_POST['CharName'])){die('You didn\'t specify a Character Name!');}
//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $_POST['CharName'] . '\',\'Edit '.$_POST['CharName'].' Items. \',GETDATE())');
	$INSERT1 = mssql_query('SELECT * FROM PS_GameData.dbo.Chars where CharName = \'' . $_POST['CharName'] . '\'');
		if (mssql_num_rows($INSERT1) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log1 = mssql_fetch_assoc($INSERT1))
		mssql_query('UPDATE GM_Stuff.dbo.Log SET Account =  \''.$Log1['UserID'].'\' WHERE Account = \'' . $_POST['CharName'] . '\'');
$Chars = @mssql_query('SELECT CharName,CharID FROM PS_GameData.dbo.Chars WHERE CharName = \''.$_POST['CharName'].'\'AND Del =0');
if(@mssql_num_rows($Chars) == 0){echo 'Character search for: "'.$_POST['CharName'].'" returned no results.';}
echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
echo '<table border="1"><tr>
		<th>CharName</th>
		<th>Select</th></tr>';
while($Row = @mssql_fetch_assoc($Chars)){
echo '<tr><td>'.$Row['CharName'].'</td>
	<td><input type="radio" name="CharID" value="'.$Row['CharID'].'"></td>
	</tr>';}
echo '</table>';
echo '<input type="Submit" value="Submit" name="SCI">';
echo '</form>';
}

elseif(isset($_POST['SCI'])){
if(!isset($_POST['CharID'])){die('You didn\'t select a Character!');}
$Bag = array(0=>'Equipped',1=>'Bag 1',2=>'Bag 2',3=>'Bag 3',4=>'Bag 4',5=>'Bag 5');
$res = @mssql_query('SELECT I.ItemName,CI.Bag,CI.Slot,CI.Count,CI.ItemUID FROM PS_GameData.dbo.CharItems CI
					INNER JOIN PS_GameDefs.dbo.Items I ON I.ItemID=CI.ItemID WHERE CI.CharID = '.$_POST['CharID'].' ORDER BY CI.Bag');
if(@mssql_num_rows($res) == 0){echo 'Search returned no results.';}
echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
echo '<table border="1"><tr>
		<th>ItemName</th>
		<th>Bag</th>
		<th>Slot</th>
		<th>Count</th>
		<th>Select</th></tr>';
while($Row = @mssql_fetch_assoc($res)){
echo '<tr><td>'.$Row['ItemName'].'</td>
		<td>'.$Bag[$Row['Bag']].'</td>
		<td>'.$Row['Slot'].'</td>
		<td>'.$Row['Count'].'</td>
		<td><input type="radio" name="ItemUID" value="'.$Row['ItemUID'].'"></td>
		</tr>';}
echo '</table>';
echo '<input type="Submit" value="Submit" name="SCN">';
echo '</form>';
}
?>
<html>
<head>
<title>Player Search</title>
</head>
<body>
<font face="Trebuchet MS">
<center>
<br><br>
<b>Edit Player Items<br>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
<table>
<tr><td>Character Name:</td><td><input type="text" name="CharName"></td></tr>
</table>
<p><input type="submit" value="Submit" name="SC" /></p>
</form>
</center>
</body>
</html>