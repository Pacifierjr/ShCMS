<?php 
include('config.inc.php');
session_start();

$msgtype = $likecnt = $newid = "";
$uid = 0;

if ((isset($_SESSION['UserUID'])) && (isset($_POST['ID']))){
		
		$uid = $_SESSION['UserUID'];
		
		include('pdoConnect.inc.php');
		
		$query = $conn->prepare('SELECT COUNT (*) as Counter FROM Website.dbo.Likes WHERE UserUID = ? AND NewID = ?');
		$query->bindParam(1,$_SESSION['UserUID'],PDO::PARAM_INT);
		$query->bindParam(2,$_POST['ID'],PDO::PARAM_INT);
		$query->execute();
		$likecnt = $query->fetch(PDO::FETCH_ASSOC);
		$likecnt = intval($likecnt["Counter"]);
		
		if($likecnt < 1){
			$query = $conn->prepare('INSERT INTO [Website].[dbo].[Likes] ([NewID],[UserUID]) VALUES(?,?)');
			$query->bindParam(1,$_POST['ID'],PDO::PARAM_INT);
			$query->bindParam(2,$_SESSION['UserUID'],PDO::PARAM_INT);
			$query->execute();	
			
			$msgtype = "1";

		}else{
			$query = $conn->prepare('DELETE FROM [Website].[dbo].[Likes] WHERE NewID = ? AND UserUID = ?');
			$query->bindParam(1,$_POST['ID'],PDO::PARAM_INT);
			$query->bindParam(2,$_SESSION['UserUID'],PDO::PARAM_INT);
			$query->execute();
			
			$msgtype = "2";
	
		}
		
		$query = $conn->prepare('SELECT COUNT (*) as Counter FROM Website.dbo.Likes WHERE NewID = ?');
		$query->bindParam(1,$_POST['ID'],PDO::PARAM_INT);
		$query->execute();
		$likecnt = $query->fetch(PDO::FETCH_ASSOC);
		$likecnt = intval($likecnt["Counter"]);
		
		$newid = $_POST['ID'];
	}
else{
			$msgtype = "0";
}
header('Access-Control-Allow-Origin: *');
$arr = array ('msg'=>$msgtype,'likecnt'=>$likecnt,'newid'=>$newid,'UserUID'=>$uid);
echo json_encode($arr);
?>