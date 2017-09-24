<?php
include('config.inc.php');
$msg = '';

	if (isset($_POST['user']) && isset($_POST['pass'])){
			session_start();
			
			if (isset($_SESSION['UserUID'])){			
				unset($_SESSION['UserUID']);
			}
		
			include('pdoConnect.inc.php');
			$query = $conn->prepare('SELECT UserUID, Pw, Status FROM PS_UserData.dbo.Users_Master WHERE UserID = ?');	
			$query->bindParam(1, $_POST['user'], PDO::PARAM_INT);	
			$query->execute();	
			$row = $query->fetch(PDO::FETCH_ASSOC);
			
	
			if (!is_numeric($row['UserUID']))
			{
				$query->closeCursor();
				$msg = 'Your account name is invalid. Try Again.';
			} 
			else 
			{
				$uid = $row['UserUID'];
				$pwd = $row['Pw'];
				$status = $row['Status'];
				
				$query->closeCursor();
				if ($pwd == '' || ''.$pwd != $_POST['pass']){
					$msg = 'Invalid password.';
				}
				else {
					$_SESSION['UserUID'] = $uid;
					$_SESSION['Status'] = $status;
							$msg = 'Successful authentication. Please wait..';      
					}
			}
	} 
	else
	{
        $msg = 'Insert a username and password.';
	}
		
echo json_encode(array("msg"=>$msg));
?>