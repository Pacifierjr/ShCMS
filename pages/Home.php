			<div id="Mcontainer">
<center><div id="newsseparator"></div></center><br/>
Shaiya Europe is a sandbox free to play fantasy MMORPG. Invade enemy territories, craft your items using a nice Job system and enjoy a fresh PVP!<br/>
</div>


	<?                        
     if($isdbg == 1){
		$fin = getmicrotime();
		echo "load time 5.1 :  ".round($fin-$debut, 3) ." secondes.<br />";}                   
$queryNews = $conn->prepare ('SELECT TOP 10 * FROM Website.dbo.News WHERE IsDraft = 0 ORDER BY Row DESC');
$queryNews->execute();
while ($news = $queryNews->fetch(PDO::FETCH_NUM)){
	if($isdbg == 1){
		$fin = getmicrotime();
		echo "load time 5.1.5 :  ".round($fin-$debut, 3) ." secondes.<br />";}
$queryLike = $conn->prepare ('SELECT COUNT(*) FROM Website.dbo.Likes WHERE NewID = \''.$news[0].'\';');
$queryLike->execute();
$queryLike = $queryLike->fetch(PDO::FETCH_NUM);
$TotalLikes = $queryLike[0];
if($isdbg == 1){
		$fin = getmicrotime();
		echo "load time 5.2 :  ".round($fin-$debut, 3) ." secondes.<br />";}
$queryComment = $conn->prepare ('SELECT COUNT(*) FROM Website.dbo.Comments WHERE NewID = \''.$news[0].'\';');
$queryComment->execute();
$queryComment = $queryComment->fetch(PDO::FETCH_NUM);
$TotalComment = $queryComment[0];
$likee = "0";
		if($isdbg == 1){
		$fin = getmicrotime();
		echo "load time 5.3 :  ".round($fin-$debut, 3) ." secondes.<br />";}
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
			<div class="Like'.$likee.'" id="b'.$news[0].'" onclick="ToggleLike('.$news[0].')"></div><span id="l'.$news[0].'">'.$TotalLikes.'</span> <a href="News.id'.$news[0].'#create_comment"><div class="Comment" id="'.$news[0].'"></div>'.$TotalComment.'</a>
			<br>
<center><div id="newsseparator"></div></center><br/>
</div>
';
echo html_entity_decode($NEws);
}if($isdbg == 1){
		$fin = getmicrotime();
		echo "load time 5.4 :  ".round($fin-$debut, 3) ." secondes.<br />";}
                    
                    
?>
<div id="Mcontainer">
<div id="news_pagination"><center><a href="News"><input type="submit" value="ALL NEWS &rarr;" name="submit"/></a></center>	</div>	
</div>
<? 
    include("pages/shoutbox.php");
?>
<?
    $arg = 10;
    include("pages/Notice.php");
    ?>

