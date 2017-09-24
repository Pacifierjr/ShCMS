<?php 
            include("core/styles/nice_table.php");


?>
<h1>Shaiya Europe Support</h1>
			<center><img src="img/line.png" /></center>
<?=$SiteName?> Staff List:
<br/>
<table class="responstable">
    <tr><th>Pseudo</th><th>Skype</th><th>Send a ticket</th></tr>
<? 

$queryy = $conn->prepare("SELECT * FROm PS_UserData.dbo.Users_Master WHERE ((Status = 16) OR (Grade != null));");
$queryy->execute();
$cnttt = 0;
while($staffuser = $queryy->fetch(PDO::FETCH_BOTH)){
    $cnttt++;
    $account = new Account($staffuser["UserUID"]);
    
    $color = "";
    
                                switch($account->Get("Grade")){
                                case 'Admin': $color = "red"; break;
                                case 'GameMaster': $color = "blue"; break;
                                case 'GameSage': $color = "green"; break; 
                                default : $color = "gray"; break; 
                                }

    ?><tr>
        <td><a href="Account.<?=$account->Get("UserUID")?>"><?=$account->Get("Shoutbox")?></a> - <span style="color:<?=$color?>;font-size:10px;"><?=$account->Get("Grade")?></span> 
        <br/><small>(
            <?
            $query = $conn->prepare("SELECT COUNT(*) AS Counter FROM PS_GameData.dbo.Chars WHERE LoginStatus = 1 AND UserUID = ?");
            $query->bindParam(1,$staffuser["UserUID"],PDO::PARAM_INT);
            $query->execute();
            $staffuser = $query->fetch(PDO::FETCH_BOTH);

            if($staffuser["Counter"] > 0){
                echo("<font color='green'>In Game</font>");
            }else{
                echo("<font color='orange'>Not In Game right now</font>");
            }
            ?>
        )</small>
        </td>
        <td><a href="skype:<?=$account->Get("Skype")?>?chat"><?=$account->Get("Skype")?></a></td>
        <td><a href="SendPlayerPM.<?=$account->Get("UserUID")?>">Send a ticket to <?=$account->Get("Shoutbox")?></a></td>
     </tr><?
}

?>
</table><?=$cnttt?> staff members.<br/>
<p>Please note that:<br/>
    Developer are here to fix and develop new content<br/>
    Game Masters are here to plan events and to solve player-related bugs<br/>
    Game Sages are here to manage game community and to temp ban bad players<br/>
    
</p>

		<center>	<img src="img/line.png" /></center>