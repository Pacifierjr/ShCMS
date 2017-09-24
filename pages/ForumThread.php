<style>
    a:hover{
        color:cyan;
    }
</style>

        
        <?  include("core/styles/nice_table.php");
            $SectionID = $arg;
            $ParentSection = $conn->prepare("SELECT * FROM Website.dbo.ForumThreads WHERE (ReplyToID = ?) OR (IsFirstPost = 1 AND ID = ?) ORDER BY ID ASC;");
            $ParentSection->bindParam(1,$arg,PDO::PARAM_INT);
            $ParentSection->bindParam(2,$arg,PDO::PARAM_INT);
            $ParentSection->execute();
            $thread = $ParentSection->fetch(PDO::FETCH_ASSOC);

 
                ?>
<div id="Mcontainer">
    <?
       
        $parentcat = $conn->prepare("SELECT * FROM Website.dbo.ForumSections WHERE ID = ?;");
        $parentcat->bindParam(1,$thread["SectionID"], PDO::PARAM_INT);
        $parentcat->execute();
        $parentcat = $parentcat->fetch(PDO::FETCH_ASSOC);
        $p = "";
     if(isset($_POST["send"])){
         
                $query = $conn->prepare("INSERT INTO [Website].[dbo].[ForumThreads] VALUES (?,?,?,0,?,GETDATE(),null,0,?,null,null,null,0,0)");
                $query->bindParam(1,$_POST["Title"],PDO::PARAM_STR);
                $query->bindParam(2,$_POST["content"],PDO::PARAM_STR);
                $query->bindParam(3,$uid,PDO::PARAM_INT);
                $query->bindParam(4,$parentcat["ID"],PDO::PARAM_INT);
                $query->bindParam(5,$arg,PDO::PARAM_INT);
                $query->execute();
                $p = "Message created!";


            }
    ?>
        <center> <a href="/Home"><?=$SiteName?></a>
                                    →
            <a href="/Forum">Forum</a>  → <a href="/ForumSection.<?=$parentcat["ID"]?>"><?=$parentcat["Title"]?> </a> <br/>
        ↪ <?=$thread["Title"]?> </center> <br/><br/>


        <?
            SetPageTitle($parentcat["Title"]." → ".$thread["Title"]." | ".$SiteName." - Forum");
            echo("<br/>");
            RenderForumPost($conn,$thread["ID"],1,$_SERVER['REMOTE_ADDR'],$CurrentUser->Get("UserUID"));
            
        $query = $conn->prepare("SELECT * FROM Website.dbo.ForumThreads WHERE (ReplyToID = ? AND IsFirstPost = 0) ORDER BY ID ASC;");
        $query->bindParam(1,$thread["ID"],PDO::PARAM_INT);
        $query->execute();
        $cnt = 1;
        while($row = $query->fetch(PDO::FETCH_BOTH)){
            $cnt++;
            RenderForumPost($conn,$row["ID"],$cnt);
        }      
        ?>
</div>
<div id="Mcontainer">
    <center><br/>
        <p><?=$p?></p>
    <h1>Reply to thread</h1><br/>
        <?php 
        if($CurrentUser->IsLoggedIn()){
            if($parentcat["IsPublic"] == 0 && !$CurrentUser->IsAdm()){
            ?>
            <p>Only admins can post here.</p>
        <?
            }else{
                
                ?>
        
        <form action="#" method="POST">
            <table>
            <tr><td>Post Title: </td><td><input type="text" name="Title" placeholder="Put here the title of your thread..."></td></tr>
            </table>
              <textarea name="content" style="width: 550px; height: 400px;" placeholder="Thread Message..."></textarea>
              <input type="Submit" name="send" value="Send message">
        </form>
        
        
        <?
            }
        
        }else{ ?>
            <p>You must be logged in to post<p><?
        } ?>
        
    </center>
</div>
               

	       
            
           
         
       
    

        
