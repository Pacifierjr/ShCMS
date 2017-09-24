<?php 
session_start();
if ((isset($_SESSION['UserUID'])) && (isset($_POST['CommentAction']))){
		
		include('pdoConnect.inc.php');
		
		$uid = $_SESSION['UserUID'];
		$Action = $_POST['CommentAction'];
				$QueryPUID = $conn->prepare("SELECT Status FROM [PS_UserData].[dbo].[Users_Master] WHERE UserUID = ?;");
				$QueryPUID->bindParam(1,$uid,PDO::PARAM_INT);
				$QueryPUID->execute();
				$row = $QueryPUID->fetch(PDO::FETCH_ASSOC);
				$Status = $row["Status"];
		
		if($Action == "Post"){//no check needed
			if(isset($_POST['Comment']) && isset($_POST['NewID'])){
				$CommentContent = $_POST["Comment"];
				$NewID = $_POST["NewID"];
				$QueryInsert = $conn->prepare("INSERT INTO [Website].[dbo].[Comments]([NewID],[Comment],[UserUID],[CommentDate]) VALUES (?,?,?,(GETDATE()))");
				$QueryInsert->bindParam(1,$NewID,PDO::PARAM_INT);
				$QueryInsert->bindParam(2,$CommentContent,PDO::PARAM_INT);
				$QueryInsert->bindParam(3,$uid,PDO::PARAM_INT);
				$QueryInsert->execute();
			}
			
			
		}else{
					

			$PosterUID = "0";
			if(isset($_POST['CommentID'])){
				$CommentID = $_POST["CommentID"];
				$QueryPUID = $conn->prepare("SELECT UserUID FROM [Website].[dbo].[Comments] WHERE CommentID = ?;");
				$QueryPUID->bindParam(1,$CommentID,PDO::PARAM_INT);
				$QueryPUID->execute();
				$row = $QueryPUID->fetch(PDO::FETCH_ASSOC);
				$PosterUID = $row["UserUID"];
			}
			
			
			if(($Action == "Delete") && (($PosterUID == $uid) || ($Status == 16) )){//need uid check
				if(isset($_POST['NewID'])){
					$NewID = $_POST["NewID"];
					$QueryInsert = $conn->prepare("DELETE FROM [Website].[dbo].[Comments] WHERE CommentID = ?;");
					$QueryInsert->bindParam(1,$CommentID,PDO::PARAM_INT);
					$Query->execute();
				}
			}
			if(($Action == "Edit") && (($PosterUID == $uid) || ($Status == 16) )){//need uid check
				if(isset($_POST['Comment']) && isset($_POST['CommentID'])){	
					$CommentContent = $_POST["Comment"];
					$CommentID = $_POST["CommentID"];
					$QueryInsert = $conn->prepare("UPDATE [Website].[dbo].[Comments] SET Comment = ? WHERE CommentID = ?");
					$QueryInsert->bindParam(2,$CommentID,PDO::PARAM_INT);
					$QueryInsert->bindParam(1,$CommentContent,PDO::PARAM_INT);
					$QueryInsert->execute();
				}
			}
		}

		
	}
header("Access-Control-Allow-Origin: *");
header("Location: ".$_SERVER['HTTP_REFERER']."");
?>