<?php
include("core/styles/nice_table.php");
if(!$CurrentUser->IsLoggedIn()){
    include("core/reqlogin.inc.php");

}else{
   

?><center>
<h3>My private sent message list <small>(<a href="RecvPM">Sent list</a>) (<a href="SendPlayerPM">Send PM</a>)</small></h3>

<div id="newsseparator"></div>

</center>
<table class="responstable">
    <? 
    $query = $conn->prepare("SELECT * FROM Website.dbo.PlayerPM WHERE PosterUID = ?;");
    $query->bindParam(1,$uid,PDO::PARAM_INT);
    $query->execute();
    while($row = $query->fetch(PDO::FETCH_BOTH)){
        $sender = new Account($row["PosterUID"]);
    ?>
    
    <tr><th><img src="img/icon/thread/new.png"/></th><th><a href="Message.<?=$row["ID"]?>"><?=$row["Title"]?></a><small>by: <a href="Account.<?=$sender->Get("UserUID")?>"><?=$sender->Get("UserID")?></a></small></th><th><?=render_date($row["Date"])?></th></tr>

    <?
    } ?>  
</table>
<? 
}
?>