<?php 
  include("core/styles/nice_table.php");
if($arg == null){ 
$arg = 1;
}

		
		$query = $conn->prepare('SELECT * FROM Website.dbo.Comments AS A INNER JOIN PS_UserData.dbo.Users_Master AS B ON A.UserUID = B.UserUID WHERE CommentID = ?');
		$query->bindParam(1,$arg,PDO::PARAM_INT);
		$query->execute();
		$title = $query->fetch(PDO::FETCH_ASSOC);
		$PosterUID = $title['UserUID'];
		$Comment = $title['Comment'];
		$CommentDate = $title['CommentDate'];
?> 
<h3>Posted by <i><a href="Account.<?=$PosterUID?>"><?=$title['Shoutbox']?></a></i> - on the <?=$CommentDate?><i> | <a href="News.id<?=$title['NewID']?>">> back to the news <</a></i></h3>
	
	
	<form action="core/doComment.call.php" method="POST">
	<input type="text" value="Edit" name="CommentAction" style="display:none;"/>
	<input type="text" value="<?=$arg?>" name="CommentID" style="display:none;"/>

	<center><textarea name="Comment" id="txtInDiv" cols="75" rows="15"><?=html_entity_decode($Comment)?></textarea></center><br/><center>
	<input type="submit" value="Edit comment" name="submit"/></center>
    </form>
	
	<center>
	<input type="submit" value="Clear" name="submit" onclick="document.getElementById('txtInDiv').value = ''"/></center>	
		
