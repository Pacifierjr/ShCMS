
<?php 
            include("core/styles/nice_table.php");

if($arg == null){ 
$arg = 1;
}
		
		$query = $conn->prepare('SELECT Title FROM Website.dbo.News WHERE Row = ?');
		$query->bindParam(1,$arg,PDO::PARAM_INT);
		$query->execute();
		$title = $query->fetch(PDO::FETCH_ASSOC);
		$title = $title['Title'];
?> 
<h3>Who liked the news <a href="News.id<?=$arg?>"><?=$title?>"</a> ?</h3>
<?php
$query = $conn->prepare('SELECT * FROM Website.dbo.Likes AS A INNER JOIN PS_UserData.dbo.Users_Master AS B ON A.UserUID = B.UserUID WHERE NewID = ? ORDER BY LikeDate Desc');
		$query->bindParam(1,$arg,PDO::PARAM_INT);
		$query->execute();
	?><table class="responstable">
	<tr><th>User</th><th>Like Date</th></tr>
	<?php
		while($like = $query->fetch(PDO::FETCH_ASSOC)){
			?>
			<tr><td><a href="Account.<?=$like["UserUID"]?>"><?=$like["UserID"]?></a></td><td><?=render_date($like["LikeDate"])?></td></tr>
			<?php
			
		}

	?></table>