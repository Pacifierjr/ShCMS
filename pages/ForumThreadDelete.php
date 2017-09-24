<center>
<?php 
if($arg == null){ $arg = 1; }

$thread = new Thread($arg);
    if(($thread->Get("PosterUID") == $uid) || $CurrentUser->IsAdm()){
        
    if(isset($_POST["Delete"])){
        $query = $conn->prepare("DELETE FROM Website.dbo.ForumThreads WHERE ((ID = ?) || (ReplyToID = ?))");
        $query->bindParam(1, arg, PDO::PARAM_INT);
        $query->bindParam(1,$arg, PDO::PARAM_INT);
        $query->execute();
        echo('<font color="green">Thread deleted.</font>');
    }
    if(isset($_POST["Move"])){
        $query = $conn->prepare("UPDATE Website.dbo.ForumThreads SET SectionID = ? WHERE ((ID = ?) OR (ReplyToID = ?))");
        $query->bindParam(1,$_POST["SectionID"],PDO::PARAM_INT);
        $query->bindParam(2,$arg,PDO::PARAM_INT);
        $query->bindParam(3,$arg,PDO::PARAM_INT);
        $query->execute();
        echo('<font color="green">Thread moved.</font>');
    }
        
    
    ?> 
<h3>Are you sure that you want to delete the thread <a href="ForumThread.<?=$arg?>">"<?=$thread->Get("Title")?>"</a> ?</h3>
<br/>

<form method="POST" action="#">
<input type="submit" name="Delete" value="Delete"><br/>
    </form>
    
   <form method="POST" action="#">
 
<? 
  if($thread->Get("IsFirstPost") == 1){
      
      $parentsection = new Section($thread->Get("SectionID"));
      ?>
        <br/><p>Current section: <?=$parentsection->Get("Title")?></p><br/>
    
    
            <select name="SectionID">
                   <?
                        $query = $conn->prepare("SELECT * FROM Website.dbo.ForumSections WHERE (IsParentCat = 0) AND (ID != ?);");
                        $query->bindParam(1,$parentsection->Get("ID"),PDO::PARAM_INT);
                        $query->execute();
                        while($row = $query->fetch(PDO::FETCH_BOTH)){
                            ?>
                            <option value="<?=$row["ID"]?>"><?=$row["Title"]?></option>
                            <?
                        }
                    ?>
            </select><br/>
    
            <input type="submit" name="Move" value="Move"/>
    <?
  }      
?>
    </form>

<?php }else{
    include("core/reqadm.inc.php");
}  ?>
    </center>