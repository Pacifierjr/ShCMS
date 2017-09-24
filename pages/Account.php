<?php 	

if(!is_numeric($arg)){
    $arg = $uid;
}

if(($arg != 0) || ($CurrentUser->IsLoggedIn())){
    if(isset($_POST["savec"])){
        $query = $conn->prepare("UPDATE PS_UserData.dbo.Users_Master SET Shoutbox = ?, Sign = ?, Skype = ?, MainCharID = ?, Email = ?, Grade = ? WHERE UserUID = ?");
        $query->bindParam(1, $_POST["sb"],PDO::PARAM_STR);
        $query->bindParam(2, $_POST["sign"],PDO::PARAM_STR);
        $query->bindParam(3, $_POST["skype"],PDO::PARAM_STR);
        $query->bindParam(4, $_POST["MainChar"], PDO::PARAM_INT);
        $query->bindParam(5, $_POST["email"], PDO::PARAM_STR);
        if($CurrentUser->IsAdm()){
              $query->bindParam(6, $_POST["grade"],PDO::PARAM_STR);

        }else{
              $query->bindParam(6, "", PDO::PARAM_STR);

        }
        $query->bindParam(7, $uid,PDO::PARAM_INT);
        $query->execute();
        echo("<font color='green'>Changes saved!</font>");
        
    }

$queryo = $conn->prepare('SELECT TOP 1 * FROM PS_UserData.dbo.Users_Master AS A LEFT JOIN PS_GameData.dbo.UserMaxGrow AS B ON A.UserUID = B.UserUID WHERE A.UserUID = ?');
$queryo->bindParam(1,$arg,PDO::PARAM_INT);
$queryo->execute();
$acc = $queryo->fetch(PDO::FETCH_ASSOC);
$email=$acc["Email"];
$duser=$acc["Shoutbox"];
$skype=$acc["Skype"];
$faction=$acc["Country"];
$sign = $acc["Sign"];
if($faction == "0"){
	$dfaction = 'Aliance of Light';
}else{
	$dfaction = 'Union of Fury';
}
if($email == ""){
	$email="Unknow";
}
if($skype == ""){
	$skype="Unknow";
}
$usern=$acc["UserID"];
      include("core/styles/nice_table.php");
?>	

<h1>Public Profile - <?=$acc["UserID"]?></h1><br/>
<center><img src="img/line.png" /></center>
<form method="POST" action="#">
<?php 
    
    $mainchar = new Char($acc["MainCharID"]);
    
    $readonly = "";
    if($acc["UserUID"] != $CurrentUser->Get("UserUID")){
        $readonly = "readonly";
    }
    
    $readonlyg = "readonly";
    if($CurrentUser->IsAdm()){
        $readonlyg = "";
    }
?>
<table>
<tr><td>Display Username:</td><td><input name = "sb" type="text" value="<?=$duser;?>" <?=$readonly?>/></td></tr>
<tr><td>Grade:</td><td><input name = "grade" type="text" value="<?=$acc["Grade"];?>" <?=$readonlyg?>/></td></tr>
<tr><td>Email</td><td><input type="text" name = "email"  value="<?=$email;?>" <?=$readonly?>></td></tr>
<tr><td>Skype id:</td><td><input type="text" name = "skype" value="<?=$skype;?>" <?=$readonly?>></td></tr>
<tr><td>Main Character:</td><td><select style="width:180px;"name="MainChar" <?=$readonly?>>
     <?   
                $cid = "";
            if($mainchar->Get("CharID") > 0){
                    ?> 
                <option value="<?=$mainchar->Get("CharID")?>">Main: <?=$mainchar->Get("CharName")?></option>
                    <?
                        $cid = $mainchar->Get("CharID");
            }else{
                    $cid = 0;
            }
        
    ?>
    <? 
        $query = $conn->prepare("SELECT * FROM PS_GameData.dbo.Chars WHERE UserUID = ? AND Del = 0 AND CharID != ?;");
        $query->bindParam(1,$acc["UserUID"],PDO::PARAM_INT);
        $query->bindParam(2,$cid,PDO::PARAM_INT);
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_BOTH)){
            $char = new Char($row["CharID"]);
        ?>
            <option value="<?=$char->Get("CharID")?>"><?=$char->Get("CharName")?></option>
        <?
        }
        ?>
   
        </select></td></tr>
<tr><td>Faction:</td><td><input type="text" value="<?=$dfaction;?>" readonly><?php if($faction=='0'){echo('<div id="FactionAoL"></div>');}else{echo('<div id="FactionUoF"></div>');} ?></td></tr>
<tr><td>Forum Sign:</td><td><textarea name="sign" style="width: 450px; height: 200px;" placeholder="Thread Message..." <?=$readonly?>><?=$acc["Sign"]?></textarea></td></tr>
<br/>
</table>
<h1>All characters:</h1><br/>
			<center><img src="img/line.png" /></center>
			<table class="responstable">
<?php 


$query = $conn->prepare('SELECT * FROM PS_GameData.dbo.Chars WHERE UserUID = ? AND Del = 0');
$query->bindParam(1,$arg,PDO::PARAM_INT);
$query->execute();
$cnt = 0;
while($char = $query->fetch(PDO::FETCH_ASSOC)){
	$cnt++;
	
	$grade = 0;
	
	$grade = KillToGrade($char["K1"]);
	
    $character = new Char($char["CharID"]);
    $character_guild = new Guild($character->GetGuildID());
	
	?>
<tr><td><?=$character->Get('CharName')?></td><td><div id="Class<?=$character->Get('Job')?>"></div></td><td><?=$character->Get('K1');?> kill(s) <div id="Grade<?=$grade;?>"></div> </td><td>Lvl. <?=$character->Get('Level')?></td><td><? if($character_guild->Get('GuildName') != ""){echo("Guild: " . $character_guild->Get('GuildName'));}else{echo("Not member of a guild.");}?></td></tr>
	<?php
	
}
if($cnt == 0){
	?>
	<tr><th>No alive character.</th></tr>
	<?php
}
?>	

</table>
<center><a href="Home"><input type="button" value="Back to home" name="submit"/></a><a href="SendPlayerPM.<?=$arg?>"><input type="submit" value="Send a message" name="submit"/></a>
    
    <? if((($acc["UserUID"] == $CurrentUser->Get("UserUID")) && $CurrentUser->IsLoggedIn())){ ?>
    
    <input type="submit" value="Save changes" name="savec"/>
    <? 
    }else{
    ?>
    
<a href="Account.<?=$uid?>"><input type="button" value="Open my own profile" name="submit"/></a>
    <?
}
    ?></center>

</form>
	<center>	<img src="img/line.png" /></center>
<?php  
    
    }else{
    include("core/reqlogin.inc.php");
}
    
    
    ?>
