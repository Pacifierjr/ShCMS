<section id="content">
<?php 
/*
DESC: 			This page don't need changes to work
INCLUDED BY: 	N/A
CREATOR:		Trayne01
LAST DATE:		27/07/2016 4 h 43 pm
*/

?>
		<center>
			<h2>Shaiya Drop Finder !</h2>
			<form action = "#" method="post">
			<small>You can press the first letter of your item name to find it quickly!</small>
				<p>Item Name <select name = "Var1">
				
		<?php
	$query = $conn->prepare("SELECT * FROM PS_GameDefs.dbo.Items WHERE LEFT(ItemName, 1) != '?' AND ItemID not in ".$item_blacklist." ORDER BY ItemName Asc");
	$query->execute();
    while ($row=$query->fetch(PDO::FETCH_BOTH)) {
        echo('<option value="'.$row['ItemID'].'">'.$row['ItemName'].'</option>');
    }
?>
							</select>
							<br />
				</p>
				<br/>
				<input type="submit" name="send_price" value="Find">
			</form>
            
            
			<br/>
			<?php 
			if(isset($_POST["Var1"])){
			$ele = array(0 => 'None', 1 => 'Fire', 2=> 'Water', 3=> 'Earth', 4=> 'Wind');
			
            $itemid = $_POST["Var1"];


            $query = $conn->prepare("SELECT TOP 1 ItemName FROM PS_GameDefs.dbo.Items WHERE ItemID = ? ;");
            $query->bindParam(1,$itemid,PDO::PARAM_INT);
            $query->execute();
            while($row = $query->fetch(PDO::FETCH_BOTH)) {
                $DisplayItemName=$row["ItemName"];


                }
         //       echo("SELECTED ITEM: ".$DisplayItemName."<br/>");
         //   $queryy = $conn->prepare("USE PS_GameDefs SELECT dbo.Mobs.MobID, dbo.Mobs.MobName, dbo.Mobs.HP, dbo.Mobs.Level, dbo.Mobs.Attrib, dbo.MobItems.DropRate, dbo.MobItems.ItemOrder, dbo.MapNames.MapName FROM dbo.MobItems INNER JOIN Mobs ON dbo.Mobs.MobID = dbo.MobItems.MobID JOIN MapNames ON dbo.Mobs.MapID = dbo.MapNames.MapID WHERE Grade = (SELECT TOP 1 Grade FROM PS_GameDefs.dbo.Items WHERE ItemID = 1001) ORDER BY dbo.MobItems.DropRate DESC;");     
            //$queryy->bindParam(':id',$itemid, PDO::PARAM_INT);
        //    $queryy->execute();
            $countt=0;
          //      while ($row=$queryy->fetch(PDO::FETCH_BOTH)) {
        //            echo("a");
        //        }
                
                
            //    echo("SELECTED ITEM: ".$DisplayItemName."<br/>");
        $query = $conn->prepare("SELECT M.MobID, M.MobName, M.HP, M.Level, M.Attrib, MI.DropRate, MI.ItemOrder, MN.MapName 
            FROM PS_GameDefs.dbo.MobItems MI WITH (NOLOCK) 
                  JOIN PS_GameDefs.dbo.Mobs M WITH (NOLOCK) ON M.MobID = MI.MobID  
                  JOIN PS_GameDefs.dbo.MapNames MN WITH (NOLOCK) ON M.MapID = MN.MapID 
                  JOIN PS_GameDefs.dbo.Items I WITH (NOLOCK) ON MI.Grade = I.Grade 
        WHERE I.ItemID = ? ORDER BY MI.DropRate DESC  ;");
        $query->bindParam(1,$itemid,PDO::PARAM_INT);
        $query->execute();
        //while ($rowa = $query->fetch(PDO::FETCH_BOTH)) {
      //      echo($rowa[0]);
       // }
                
     while($rowa = $query->fetch(PDO::FETCH_BOTH)) {
            if($countt == 0){
                    echo "<center>Monsters who are dropping: " . $DisplayItemName . " 
                     <table cellspacing=1 cellpadding=2 border=1 style=\"border-style:hidden;\">
                     <tr>
                     <th>Name Monster</th>
                  <th>Mob HP</th>
                     <th>Mob Level</th>
                     <th>Mob Ele</th>
                     <th>Drop Percentage Rate</th>
                  <th>Map Name</th>
                     </tr>";
                     $countt=1;
              }

                      echo "<tr>";
                       echo "<td>";				
                    echo utf8_encode($rowa['MobName']);
                      echo "</td>";
                    echo "<td>";
                echo $nombre_format_francais = number_format($rowa['HP'], 2, '.', ',');
                      echo "</td>";
                      echo "<td>";
                echo ($rowa['Level']);
                       echo "</td>";
                        echo "<td>";
                     echo ($ele[$rowa['Attrib']].' <img src="img/ele_'.$rowa['Attrib'].'.png" />');
                        echo "</td>";
                        echo "<td>";
                      $DropRate=$rowa['DropRate'];
                            if ($row['ItemOrder'] > 4)
                            {
                                $DropRate=($DropRate/100000);
                            }
                            if ($DropRate > 100)
                            {
                                $DropRate=100;
                            }
                        echo (($DropRate)." %");
                        echo "</td>";
                        echo "<td>";
                        echo ($rowa['MapName']);
                        echo "</td>";
                        echo "</tr>";
                }
                
             
             if($countt==1){
                   echo "</table></center>";  
              }
              else
             {
                echo"The wished items: $DisplayItemName can't be dropped for now! Contact our staff if you think that it an error!";
        }
			
			
			
			
			}
		
		
	

?>
			<br/>
		</center>
		</section>			<center><div id="footer"><small> <font color="white">Original programming by Trayne01, 2017.</font></small></div></center>

		<center>	<img src="img/line.png" /></center>
