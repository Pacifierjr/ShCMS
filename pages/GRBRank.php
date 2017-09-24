
                     <div id="Mcontainer">
                        <center>
                                <a href="/Home"><?=$SiteName?></a>
                                → <a href="/Rank">Rank</a>  →
                                <a href="/<?=$pagename?>"><?=$pagename?></a>
                            
                        </center>
                         <br/>
                         
<center><?php
            include("core/styles/nice_table.php");

$Rank=$Light=$Fury=1;
$Faction = array (0=>'Alliance',1=>'Fury');
$query = $conn->prepare("SELECT TOP 25* FROM PS_GameData.dbo.Guilds WHERE Del=0 ORDER BY GuildPoint DESC");
$query->execute();
echo '<table class="responstable">';
echo "<tr><th>Rank</th>
        <th>Guild Name</th>
        <th>Members</th>
        <th>Leader</th>
        <th>Faction</th>
        <th>Faction Rank</th>
        <th>Points</th></tr>";

while($row = $query->fetch(PDO::FETCH_BOTH))
{
      echo "<tr>";
      echo "<td>".$Rank."</td>";
      echo "<td>".$row['GuildName']."</td>";
      echo "<td>".$row['TotalCount']."</td>";
      echo "<td>".$row['MasterName']."</td>";
    if($row['Country']==0){
      echo "<td>".$Faction[$row['Country']]. "</td>";
      echo "<td>".$Light."</td>";
    }else{
      echo "<td>".$Faction[$row['Country']]. "</td>";
      echo "<td>".$Fury."</td>";
    }
      echo "<td>".$row['GuildPoint']."</td>";
      echo "</tr>";
    switch($row['Country']){
    case 0: $Light++;break;
    case 1: $Fury++;break;
    }
      $Rank++;
}
echo "</table>";
?></center>
</div>