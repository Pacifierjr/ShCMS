<style>
    #MTitle{
        background-color:rgba(63, 191, 191, 0.44);        
    }
    h3
    a:hover{
        color:cyan;
    }
</style>
<?  include("core/styles/nice_table.php"); ?>
<div id="Mcontainer">
    <?
    
    if($arg == null){
        $arg=0;
    }
    if(!$CurrentUser->IsLoggedIn()){
        include("core/reqlogin.inc.php"); 
    }else{
        $p = "";
        $query = $conn->prepare("SELECT * FROM Website.dbo.PlayerPM WHERE ID = ?;");
        $query->bindParam(1,$arg,PDO::PARAM_INT);
        $query->execute();
        $message = $query->fetch(PDO::FETCH_BOTH);
        if(($message["DestUID"] == $CurrentUser->Get('UserUID') )|| (($message["PosterUID"]) == ($CurrentUser->Get("UserUID"))) || ($CurrentUser->IsAdm())){
              ?>
        <center> <a href="/Home"><?=$SiteName?></a>                                  →
        <a href="/RecvPM">Private Mesage</a>  → <a href="/Message.<?=$message["ID"]?>"><?=$message["Title"]?> </a> <br/></center> <br/><br/>
        <?
        SetPageTitle($SiteName." - Private Message : " . $message["Title"]);
        echo("<br/>");
        ?>
        <h3 id="MTitle"><center><br/><?=$message["Title"]?><br/><br/></center></h3><br/>
        <?
        if(isset($_POST["ForceIsNew"])){
            $query = $conn->prepare("UPDATE Website.dbo.PlayerPM SET ForceIsNew = ? WHERE ID = ?");
            $query->bindParam(1,$_POST["ForceIsNew"],PDO::PARAM_INT);
            $query->bindParam(2,$arg,PDO::PARAM_INT);
            $query->execute();
        }
        if($message["ForceIsNew"] != 1){
            $query = $conn->prepare("UPDATE Website.dbo.PlayerPM SET IsNew = 0 WHERE ID = ?");
            $query->bindParam(1,$arg,PDO::PARAM_INT);
            $query->execute();
            $p = "Marked as unread.";
        }
        $postacc = new Account($message["PosterUID"]);
        $destacc = new Account($message["DestUID"]);
        $parser->parse($message["Message"]);
        ?>
    <hr><br/><br/>
        <?=$parser->getAsHtml()?><br/><br/><hr><br/>
        <small>Posted by: <a href="<?=$postacc->Get("UserUID")?>"><?=$postacc->Get("UserID")?></a> on the <?=render_date($message["Date"])?>.</small><br/><br/>
         Mark as unread:  
        <form action="#" method="POST">
                                   <select name="ForceIsNew">
                                       <? 
                                   if($message["ForceIsNew"] == 1){?>
                                             <option value="1">Yes</option><option value="0">No</option>
                                       <?
                                    }else{
                                                                   ?>
                                              <option value="0">No</option><option value="1">Yes</option>
                                       <?
                                          }


                                                                    ?>
                                    </select>
                                    <input type="Submit" name="IsNewBtn"/>
        </form>
        </div>
        <div id="Mcontainer">
           <?php 
            if($postacc->Get("UserUID") == $CurrentUser->Get("UserUID")){
                $value = $destacc->Get("UserUID");
            }else{
                $value = $postacc->Get("UserID");
            }
            $msgtitle = "RE : " . $message["Title"];
            include('pages/SendPlayerPM.php'); 
            ?>
        </div>

    
    <?
        }else{
            include("core/reqadm.inc.php");
            ?>
                </div>
            <?
        }
      
    }
   ?>
           
         
       
    

        
