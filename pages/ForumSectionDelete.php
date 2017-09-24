<center>
<?php 
if($arg == null){ $arg = 1; }

$a = new Account($uid);
if($a->IsAdm()){
    
        if(isset($_POST["Move"])){
            $query= $conn->prepare('UPDATE Website.dbo.ForumThreads SET SectionID = ? WHERE SectionID = ?; UPDATE Website.dbo.ForumSections SET ParentID = ? WHERE ParentID = ?; DELETE FROM Website.dbo.ForumSections WHERE ID = ?;');
            $query->bindParam(1, $_POST["section"], PDO::PARAM_INT);
            $query->bindParam(2, $arg,PDO::PARAM_INT);
            $query->bindParam(3, $_POST["section"], PDO::PARAM_INT);
            $query->bindParam(4, $arg,PDO::PARAM_INT);
            $query->bindParam(5, $arg,PDO::PARAM_INT);
            $query->execute();
            echo("Section moved!<br/>");
             header('Location: /Forum');
        }
        if(isset($_POST["Delete"])){
           $query= $conn->prepare('DELETE FROM Website.dbo.ForumSections WHERE ID = ?; DELETE FROM Website.dbo.ForumThreads WHERE SectionID = ?;');
            $query->bindParam(1, $arg, PDO::PARAM_INT);
            $query->bindParam(2,$arg,PDO::PARAM_INT);
            $query->execute();
            echo("Section & all post deleted!<br/>");
             header('Location: /Forum');
        }
		
		$query = $conn->prepare('SELECT * FROM Website.dbo.ForumSections WHERE ID = ?');
		$query->bindParam(1,$arg,PDO::PARAM_INT);
		$query->execute();
		$title = $query->fetch(PDO::FETCH_ASSOC);
		$title = $title['Title'];
?> 
<h3>Are you sure that you want to delete the section <a href="ForumSection.<?=$arg?>">"<?=$title?>"</a> ?</h3>
<br/>
<p>Move all posts and threads in an other section and delete the section <?=$title?> :</p>
<form method="POST" action="#">
    <select name="section">
        <?php 
        $query = $conn->prepare('SELECT * FROM Website.dbo.ForumSections WHERE IsParentCat = 0;');
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_BOTH)){
            ?>
                <option value="<?=$row["ID"]?>"><?=$row["Title"]?></option>

        <?
        }
        ?>
    </select>
    <input type="submit" name="Move" value="Move & Delete">
</form>
<br/>
<p>Delete the section, and all its posts & threads</p>
<form method="POST" action="#">
<input type="submit" name="Delete" value="Delete">
</form>
<?php }else{
    include("core/reqadm.inc.php");
}  ?>
    </center>