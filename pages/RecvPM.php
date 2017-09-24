<?php 
include("core/styles/nice_table.php");
if(!$CurrentUser->IsLoggedIn()){
    include("core/reqlogin.inc.php");

}else{
   

?><center>
<h3>My private message list <small>(<a href="SentPM">Sent list</a>) (<a href="SendPlayerPM">Send PM</a>)</small></h3>

<div id="newsseparator"></div>

</center>
<table class="responstable">
    <? 
    $query = $conn->prepare("SELECT * FROM Website.dbo.PlayerPM WHERE DestUID = ? AND (IsNew = 1 OR ForceIsNEw = 1);");
    $query->bindParam(1,$uid,PDO::PARAM_INT);
    $query->execute();
    while($row = $query->fetch(PDO::FETCH_BOTH)){
        $sender = new Account($row["PosterUID"]);
    ?>
    
    <tr><th><img src="img/icon/thread/new.png"/></th><th><a href="Message.<?=$row["ID"]?>">New: <?=$row["Title"]?></a><small> by: <a href="Account.<?=$sender->Get("UserUID")?>"><?=$sender->Get("UserID")?></a></small></th><th><?=render_date($row["Date"])?></th></tr>

    <?
    }
    
    $query = $conn->prepare("SELECT * FROM Website.dbo.PlayerPM WHERE DestUID = ? AND IsNew = 0 AND ForceIsNew != 1");
    $query->bindParam(1,$uid,PDO::PARAM_INT);
    $query->execute();
    while($row = $query->fetch(PDO::FETCH_BOTH)){
        
        $sender = new Account($row["PosterUID"]);
    ?>
    
    <tr><td><img src="img/icon/thread/normal.png"/></td><td><a href="Message.<?=$row["ID"]?>"><?=$row["Title"]?> </a><small>by: <a href="Account.<?=$sender->Get("UserUID")?>"><?=$sender->Get("UserID")?></a></small></td><td><?=render_date($row["Date"])?></td></tr>

    <?
    }
    ?>	
    
    
</table>
<? 
}
?>