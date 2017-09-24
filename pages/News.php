<?php 

if($arg == null){ 
$arg = 1;
}
		if(substr($arg, 0, 2) == "id"){
		//this is a single article
		
	
	
		$row = substr($arg, 2, 50);
		$queryNews = $conn->prepare ('SELECT * FROM Website.dbo.News WHERE Row= ?');
		$queryNews->bindParam(1, $row, PDO::PARAM_INT);
		$queryNews->execute();
		$news =$queryNews->fetch(PDO::FETCH_NUM);
		$queryLike = $conn->prepare ('SELECT COUNT(*) FROM Website.dbo.Likes WHERE NewID = \''.$news[0].'\';');
$queryLike->execute();
$queryLike = $queryLike->fetch(PDO::FETCH_NUM);
$TotalLikes = $queryLike[0];

$queryComment = $conn->prepare ('SELECT COUNT(*) FROM Website.dbo.Comments WHERE NewID = \''.$news[0].'\';');
$queryComment->execute();
$queryComment = $queryComment->fetch(PDO::FETCH_NUM);
$TotalComment = $queryComment[0];
$likee = "0";
if($uid != 0){
	$query = $conn->prepare('SELECT COUNT (*) as Counter FROM Website.dbo.Likes WHERE UserUID = ? AND NewID = ?');
	$query->bindParam(1,$uid,PDO::PARAM_INT);
	$query->bindParam(2,$news[0],PDO::PARAM_INT);
	$query->execute();
	$likecnt = $query->fetch(PDO::FETCH_ASSOC);
	$likecnt = intval($likecnt["Counter"]);
	if($likecnt > 0){
		$likee = "1";
	}
}
		$News = '
		<div id="Mcontainer">
		<h1>'.$news[1].'</h1>
					<center><img src="img/line.png" /></center>
			<font style="font-family: Arial; font-size: 11px; color: #cf9139;">Author: <a href="Account.'.$news[3].'"><font style="color: #585858;">'.GetID($news[3],$conn).'</font></a> Date: '.$news[4].' </font><br />
	<br/>
		'.htmlspecialchars($news[2]).'<div class="clear"></div><br/><br/>
		<a href="LikeAnalyser.'.$news[0].'">Who liked this?</a><br/>
					<div class="Like'.$likee.'" id="b'.$news[0].'" onclick="ToggleLike('.$news[0].')"></div><span id="l'.$news[0].'">'.$TotalLikes.'</span> 
					
					<a href="#create_comment"><div class="Comment" id="'.$news[0].'"></div>'.$TotalComment.'</a>
<br/>
							<center><img src="img/line.png" /></center>		
							<div id="news_pagination"><center><a href="Main"><input type="submit" value="&larr; Back" name="submit"/></a></center></div>

							</div>
';
		echo html_entity_decode($News);
		
		$queryComment = $conn->prepare ('SELECT COUNT(*) FROM Website.dbo.Comments WHERE NewID = \''.$news[0].'\';');
		$queryComment->execute();
		$queryComment = $queryComment->fetch(PDO::FETCH_NUM);
		$TotalComment = $queryComment[0];
?>
		<div id="Mcontainer">
		<h3><?=$TotalComment?> Comments</h3><br><br>
		<?php 
		$queryComments = $conn->prepare ('SELECT * FROM Website.dbo.Comments AS A INNER JOIN PS_UserData.dbo.Users_Master AS B ON A.UserUID = B.UserUID WHERE NewID = ? ORDER BY CommentDate Desc');
		$queryComments->bindParam(1,$news[0],PDO::PARAM_INT);
		$queryComments->execute();
		while ($row = $queryComments->fetch(PDO::FETCH_ASSOC)){
		
		?>
		<hr>
		<small><i>Posted by <a href="Account.<?=$row["UserUID"]?>"><?=$row["Shoutbox"]?></a> on the <?=$row["CommentDate"]?></i></small><br/>
	
		<?php if($row["UserUID"] == $uid || intval($status) == 16){ ?>
				<small><i><a href="CommentEditor.<?=$row["CommentID"]?>">Edit it</a>|<a href="CommentDelete.<?=$row["CommentID"]?>">Remove it</a><br/></small></i>
			<?php	} ?>
		<p><?=html_entity_decode($row["Comment"])?></p>
		<br/>
		<?php 
		}
		?>
		
		</div>
		
		<div id="Mcontainer">
		<div id="create_comment"></div>
		<?php if($uid != 0){  ?>
	<form action="core/doComment.call.php" method="POST">
	<input type="text" value="Post" name="CommentAction" style="display:none;"/>
	<input type="text" value="<?=substr($arg,2)?>" name="NewID" style="display:none;"/>

	<br/>
	<center><b>Hello <a href="Account.<?=$uid?>"><?=$username?></a>,</b></center>
	<br/>
    <center><textarea name="Comment" id="txtInDiv" cols="75" rows="15">Some <b>Test</b> comment.</textarea></center><br/><center>
	<input type="submit" value="Send comment" name="submit"/></center>
    </form><center><input type="submit" value="Clear" name="submit" onclick="document.getElementById('txtInDiv').value = ''"/></center>	</div>
		
		<?php
		}else{
			?>
			<center><p>Please <a href="Login">login</a> to put a comment.</p></center></div>
			<?php
		}
		
		
		}else{
		//this is the list of all news with pages
			
$results_per_page = 20;	
		
				$page  = $arg;
				
$start_from = ($page-1) * $results_per_page;

$sql = "SELECT * FROM Website.dbo.News WHERE IsDraft = 0 ORDER BY Row ASC OFFSET $start_from ROWS FETCH NEXT ".$results_per_page."ROWS ONLY";
$rs_result = $conn->prepare($sql);
$rs_result->execute();
 
 while($news = $rs_result->fetch(PDO::FETCH_NUM)) {
	 $queryLike = $conn->prepare ('SELECT COUNT(*) FROM Website.dbo.Likes WHERE NewID = \''.$news[0].'\';');
$queryLike->execute();
$queryLike = $queryLike->fetch(PDO::FETCH_NUM);
$TotalLikes = $queryLike[0];

$queryComment = $conn->prepare ('SELECT COUNT(*) FROM Website.dbo.Comments WHERE NewID = \''.$news[0].'\';');
$queryComment->execute();
$queryComment = $queryComment->fetch(PDO::FETCH_NUM);
$TotalComment = $queryComment[0];
$likee = "0";
if($uid != 0){
	$query = $conn->prepare('SELECT COUNT (*) as Counter FROM Website.dbo.Likes WHERE UserUID = ? AND NewID = ?');
	$query->bindParam(1,$uid,PDO::PARAM_INT);
	$query->bindParam(2,$news[0],PDO::PARAM_INT);
	$query->execute();
	$likecnt = $query->fetch(PDO::FETCH_ASSOC);
	$likecnt = intval($likecnt["Counter"]);
	if($likecnt > 0){
		$likee = "1";
	}
}
$NEws =  '
			<div id="Mcontainer">

<a title="Go to the news" href="News.id'.$news[0].'" class="top"><font style="font-family: Trajan pro; font-size: 20px; color: #ffffff;">'.$news[1].'</font></a><br />
			<font style="font-family: Arial; font-size: 11px; color: #cf9139;">Author: <a href="Account.'.$news[3].'"><font style="color: #585858;">'.GetID($news[3],$conn).'</font></a> Date: '.$news[4].' </font><br />
			<br>
			<br>
			'.showTop(htmlspecialchars($news[2]),'6520','...').'
			<br>
			<a href="LikeAnalyser.'.$news[0].'">Who liked this?</a><br/>
			<div class="Like'.$likee.'" id="b'.$news[0].'" onclick="ToggleLike('.$news[0].')"></div><span id="l'.$news[0].'">'.$TotalLikes.'</span> <div class="Comment" id="'.$news[0].'"></div>'.$TotalComment.'
			<br>
<center><div id="newsseparator"></div></center><br/>
</div>
';
echo html_entity_decode($NEws);
}; 

$sql = "SELECT COUNT(Row) AS total FROM  Website.dbo.News";
$result = $conn->prepare($sql);
$result->execute();

$row = $result->fetch(PDO::FETCH_NUM);
$total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
  echo('<div id="Mcontainer"><center>');
for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
            echo "<a href='News.".$i."'";
            if ($i==$page)  echo " class='curPage'";
			echo "><input type=\"submit\" value=\"".$i."\" name=\"submit\"/></a> "; 
}; 
echo('</center></div>');
			
		//end pages
			
		}


?>

