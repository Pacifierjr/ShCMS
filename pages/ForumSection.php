      
        <? 
            include("core/styles/nice_table.php");
            $p = null;
            if(isset($_POST["send"])){
                $query = $conn->prepare("INSERT INTO [Website].[dbo].[ForumThreads] VALUES (?,?,?,0,?,GETDATE(),null,1,0,null,null,null,0,0)");
                $query->bindParam(1,$_POST["Title"],PDO::PARAM_STR);
                $query->bindParam(2,$_POST["content"],PDO::PARAM_STR);
                $query->bindParam(3,$uid,PDO::PARAM_INT);
                $query->bindParam(4,$arg,PDO::PARAM_INT);
                $query->execute();
                $p = "Thread created!";


            }
            $SectionID = $arg;
            $ParentSection = $conn->prepare("SELECT * FROM Website.dbo.ForumSections WHERE ID = ?;");
            $ParentSection->bindParam(1,$SectionID,PDO::PARAM_INT);
            $ParentSection->execute();
            $ParentSectionF = $ParentSection->fetch(PDO::FETCH_ASSOC);
            SetPageTitle($ParentSectionF["Title"]." | ".$SiteName." - Forum");
                ?> 
<div id="Mcontainer">
    <center>
        <a href="/Home"><?=$SiteName?></a>
                                        →
                <a href="/Forum">Forum</a>  → <a href="/ForumSection.<?=$ParentSectionF["ID"]?>"><?=$ParentSectionF["Title"]?> </a> <br/>
        <br/><?=$p?><br/>
    <table class="responstable">
        <tr><th></th><th>Thread / Thread Starter</th><th>Reply Date</th><th>Replies</th><th>View</th></tr>

        <? 
        $strrr = "";
        if(isset($_POST["page"])){
            $strrr = " AND ID < ?";
        }
        $Threads = $conn->prepare("SELECT TOP ".$FORUM_THREADSPERPAGE." * FROM Website.dbo.ForumThreads WHERE IsFirstPost = 1 AND SectionID = ? ".$strrr." ORDER BY LastReplyDate,ID DESC");
            
            
        $Threads->bindParam(1,$SectionID,PDO::PARAM_INT);
        if(isset($_POST["page"])){
            $Threads->bindParam(2,$_POST["requestedminid"],PDO::PARAM_INT);
        }
        $Threads->execute();
        $counter = 0;
        $next_page_min_id = 0;
        while($thread = $Threads->fetch(PDO::FETCH_ASSOC)){
            $counter++;
            if($counter == 10){
                $next_page_min_id = $thread["ID"];
            }
            
            $PosterUser = new Account($thread["PosterUID"]);
            $lastpost = $lastposter = $lastposteruid = null;
            if($thread["LastReplyDate"] == null){
                $lastpost = $thread["PostDate"];
                $lastposter = $PosterUser->Get("Shoutbox");
                $lastpostreruid = $PosterUser->Get("UserUID");
            }else{
                $lastpost = $thread["LastReplyDate"];
                $query = $conn->prepare("SELECT TOP 1 PosterUID FROM Website.dbo.ForumThreads WHERE ReplyToID = ? ORDER BY ID DESC");
                $query->bindParam(1,$thread["ID"],PDO::PARAM_INT);
                $query->execute();
                $resl = $query->fetch(PDO::FETCH_BOTH);
                $lastpostera = new Account($resl["PosterUID"]);
                $lastposter = $lastpostera->Get("Shoutbox");
                $lastposteruid = $lastpostera->Get("UserUID");
            }
            $replycnt = $conn->prepare("SELECT COUNT(*) as Counter FROM Website.dbo.ForumThreads WHERE ReplyToID = ?");
            $replycnt->bindParam(1,$thread["ID"],PDO::PARAM_INT);
            $replycnt->execute();
            $replycnt = $replycnt->fetch(PDO::FETCH_BOTH)["Counter"];
            ?>
        <tr> <td><img src="img/icon/thread/normal.png" width="32px" height="32px"/></td><td><a href="ForumThread.<?=$thread["ID"]?>"><?=$thread["Title"]?></a><small> by <a href="/Account.<?=$PosterUser->Get("UserUID")?>"><?=$PosterUser->Get("Shoutbox");?></a></small></td><td><?=render_date($lastpost)?> <small>(<a href="/Account.<?=$lastposteruid?>"><?=$lastposter?></a>)</small></td><td><?=$replycnt?></td><td><?=$thread["View"]?></td></tr>

        <?
        }
        ?>
    </table><br/>
        <form action="#" METHOD="POST">
        <input type="number" value="<?=$next_page_min_id?>" name="requestedminid" style="display:none;"/>
        <input type="submit" name="page" value="Next page →"/>
            <p><?=$FORUM_THREADSPERPAGE?> Threads per page limit.</p>
        </form>
    </center>
</div>
<div id="Mcontainer">
    <center>
    <h1>Create a Thread</h1><br/>
        <?php 
        if($CurrentUser->IsLoggedIn()){
            if($ParentSectionF["IsPublic"] == 0 && !$CurrentUser->IsAdm()){
            ?>
            <p>Only admins can post here.</p>
        <?
            }else{
                
                ?>
        
        <form action="#" method="POST">
            <table>
            <tr><td>Thread Title: </td><td><input type="text" name="Title" placeholder="Put here the title of your thread..."></td></tr>
              
            </table>
              <textarea name="content" style="width: 550px; height: 400px;" placeholder="Thread Message..."></textarea>
              <input type="Submit" name="send" value="Send thread">
        </form>
        
        
        <?
            }
        
        }else{ ?>
            <p>You must be logged in to post<p><?
        } ?>
        
    </center>
</div>
            
               

	       
            
           
         
       
    

        
