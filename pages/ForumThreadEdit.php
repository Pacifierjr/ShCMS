<center>
<?php 
if($arg == null){ $arg = 1; }

$thread = new Thread($arg);
    if(($thread->Get("PosterUID") == $uid) || $CurrentUser->IsAdm()){
        

    if(isset($_POST["Edit"])){
        $query = $conn->prepare("UPDATE Website.dbo.ForumThreads SET Title = ?,Content = ? WHERE ID = ?");
        $query->bindParam(1,$_POST["Title"],PDO::PARAM_INT);
        $query->bindParam(2,$_POST["Content"],PDO::PARAM_INT);
        $query->bindParam(3,$arg,PDO::PARAM_INT);
        $query->execute();
        echo('<font color="green">Thread edited!</font>');
    }
        
    
    ?> 
<h3><a href="ForumThread.<?=$arg?>"><?=$thread->Get("Title")?></a> - Edition</h3>
<br/>
<br/> 
   <form method="POST" action="#">
 
<? 

      $thread = new Thread($arg);
      $parentsection = new Section($thread->Get("SectionID"));
        
      ?>
        <br/><p>Current section: <?=$parentsection->Get("Title")?></p><br/>
    
       
        <input type="text" name="Title" value="<?=$thread->Get("Title")?>" placeholder="Thread Title..."/><br/>
       
         <textarea name="Content" style="width:560px;height:400px;"><?=$thread->Get("Content")?></textarea><br/>
    
            <input type="submit" name="Edit" value="Edit"/>
    <?
        
?>
    </form>

<?php }else{
    include("core/reqadm.inc.php");
}  ?>
    </center>