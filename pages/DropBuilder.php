<?php 
if($status == 16){
	set_time_limit(9999);
	$QueryMobs = $conn->prepare("SELECT MAX(MobID) AS Counter FROM PS_GameDefs.dbo.Mobs;");
	$QueryMobs->execute();
	$row = $QueryMobs->fetch(PDO::FETCH_ASSOC);
	$MaxMobID = intval($row["Counter"]);

	
	$QueryMobs = $conn->prepare("TRUNCATE TABLE PS_GameDefs.dbo.MobItems; SELECT * FROM PS_GameDefs.dbo.Mobs ORDER BY MobID ASC;");
	$QueryMobs->execute();
	while($row = $QueryMobs->fetch(PDO::FETCH_ASSOC)){
		
		$percent = (((intval($row["MobID"])) / $MaxMobID) * 100);
				echo($row["MobID"]."... ");

		$QueryMobItems = $conn->prepare("INSERT INTO [dbo].[MobItems]([MobID],[ItemOrder],[Grade],[DropRate])VALUES (".$row["MobID"].",1,0,0);");
		$QueryMobItems->execute();	
		$QueryMobItems = $conn->prepare("INSERT INTO [dbo].[MobItems]([MobID],[ItemOrder],[Grade],[DropRate])VALUES (".$row["MobID"].",2,0,0);");
		$QueryMobItems->execute();
		$QueryMobItems = $conn->prepare("INSERT INTO [dbo].[MobItems]([MobID],[ItemOrder],[Grade],[DropRate])VALUES (".$row["MobID"].",2,0,0);");
		$QueryMobItems->execute();
		$QueryMobItems = $conn->prepare("INSERT INTO [dbo].[MobItems]([MobID],[ItemOrder],[Grade],[DropRate])VALUES (".$row["MobID"].",3,0,0);");
		$QueryMobItems->execute();
		$QueryMobItems = $conn->prepare("INSERT INTO [dbo].[MobItems]([MobID],[ItemOrder],[Grade],[DropRate])VALUES (".$row["MobID"].",4,0,0);");
		$QueryMobItems->execute();
		$QueryMobItems = $conn->prepare("INSERT INTO [dbo].[MobItems]([MobID],[ItemOrder],[Grade],[DropRate])VALUES (".$row["MobID"].",5,0,0);");
		$QueryMobItems->execute();
		$QueryMobItems = $conn->prepare("INSERT INTO [dbo].[MobItems]([MobID],[ItemOrder],[Grade],[DropRate])VALUES (".$row["MobID"].",6,0,0);");
		$QueryMobItems->execute();
		$QueryMobItems = $conn->prepare("INSERT INTO [dbo].[MobItems]([MobID],[ItemOrder],[Grade],[DropRate])VALUES (".$row["MobID"].",7,0,0);");
		$QueryMobItems->execute();
		$QueryMobItems = $conn->prepare("INSERT INTO [dbo].[MobItems]([MobID],[ItemOrder],[Grade],[DropRate])VALUES (".$row["MobID"].",8,0,0);");
		$QueryMobItems->execute();
		$QueryMobItems = $conn->prepare("INSERT INTO [dbo].[MobItems]([MobID],[ItemOrder],[Grade],[DropRate])VALUES (".$row["MobID"].",9,0,0);");
		$QueryMobItems->execute();
		
		echo('<font color="green">done</font> ('.number_format($percent,2).' %)<br/>');
		
	}
}


?>

		<center>	<img src="img/line.png" /></center>
