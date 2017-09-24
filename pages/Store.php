<h1>Shaiya Europe Store</h1>
			<center><img src="img/line.png" /></center>

<?php
            include("core/styles/nice_table.php");
if($CurrentUser->IsAdm()){?><table class="responstable">
<?
    if(isset($_POST["Buy"])){
            $query = $conn->prepare("SELECT TOP 1 * FROM PS_GameDefs.dbo.ProductList WHERE ProductCode = ?");
            $query->bindParam(1,$_POST["package"],PDO::PARAM_STR);
            $query->execute();
            $res = $query->fetch(PDO::FETCH_BOTH);
            if(($CurrentUser->Get("Point") - ($_POST["count"] * $res["BuyCost"])) > 0){
                $query = $conn->prepare("UPDATE PS_UserData.dbo.Users_Master SET Point = Point - ? WHERE UserUID = ?");
                $val = ($_POST["count"] * $res["BuyCost"]);
                $query->bindParam(1,$val,PDO::PARAM_INT);
                $query->bindParam(2,$uid,PDO::PARAM_INT);
                $query->execute();
                $ItemInPack = 1;
                    while(($res["ItemID".$ItemInPack]) > 0){
                        $Item = new Item($res["ItemID".$ItemInPack]);//$pack['ItemCount'.$ItemInPack]
                      
                        $ItemInPack++;
                        
                        $query = $conn->prepare("DECLARE @UserID varchar(18), @UserUID bigint, @ItemID int, @ItemCount tinyint, @OrderNumber int, @BuyDate datetime, @ProductCode varchar(20), @Slot tinyint, @empty smallint  SET @OrderNumber = 1 SET @BuyDate = GETDATE() SET @UserUID = (SELECT UserUID FROM PS_UserData.dbo.Users_Master WHERE UserUID = '".$uid."') SET @Slot = 0 SET @empty = -1 WHILE (@Slot <= 239) BEGIN  SET @empty = (SELECT COUNT(Slot) FROM PS_Billing.dbo.Users_Product WHERE UserUID = '".$uid."' AND Slot = @Slot) IF (@empty <= 0) BREAK ELSE SET @Slot = @Slot+1 END INSERT INTO PS_Billing.dbo.Users_Product (UserUID, Slot, ItemID, ItemCount, ProductCode, OrderNumber, BuyDate) VALUES ('".$uid."', @Slot, '".$res["ItemID".$ItemInPack]."', '".$res['ItemCount'.$ItemInPack]."','".$res['ProductCode']."', @OrderNumber, @BuyDate);");
                        $query->execute();
                        
                    }
                echo('<font color="green">Success! (Check your bank teller in game)</font>');
                
            }else{
                echo("You don't have enough points to buy this ! You can buy point <a href='Donate'>here</a> or you can <a href='Vote'>vote for us</a>. (".($CurrentUser->Get("Point") - ($_POST["count"] * $res["BuyCost"]))." EP missing.)");
            }
        
        
        
              
        }
    
    $query = $conn->prepare("SELECT * FROM PS_GameDefs.dbo.ProductList;");
    $query->execute();
    while($pack = $query->fetch(PDO::FETCH_BOTH)){
        ?>
                
        <tr><td><h3>Pack: <?=$pack["ProductName"]?> (<?=$pack["BuyCost"]?> <img class="player_coin" src="img/europepoints.png" title="Elements Points">)</h3><br/>
            <p>Contains:</p><br/>
                <?
                    $ItemInPack = 1;
                    while(($pack["ItemID".$ItemInPack]) > 0){
                        $Item = new Item($pack["ItemID".$ItemInPack]);
                        ?>
                        <table style="color:black;"><tr><td><?php  echo("♢ - ".$pack['ItemCount'.$ItemInPack]." x "); ?></td><td><?php  $Item->PrintIcon(); ?></td><td><small><?=$Item->Get("ItemName");?></small></td></tr></table>
                        <?
                        $ItemInPack++;
                    }
                ?>
            
            
            </td><td style="width:180px;"><form action="#" METHOD="POST"><table><tr><td><input type="text" name="package" value="<?=$pack["ProductCode"]?>" style="display:none;"><input type="number" name="count" value="1" style="width:50px;"/></td><td><input type="Submit" name="Buy" value="Buy"></td></tr></table></form></td></tr>
        <?
    }
                ?></table><?
}else{
include("core/reqlogin.inc.php");
}
?>
		<center>	<img src="img/line.png" /></center>
