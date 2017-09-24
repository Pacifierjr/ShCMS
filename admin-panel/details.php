<?php
function mssql_escape_string($data) {
	if(!isset($data) or empty($data)) return '';
	if(is_numeric($data)) return $data;
	$non_displayables = array(
		'/%0[0-8bcef]/',			// url encoded 00-08, 11, 12, 14, 15
		'/%1[0-9a-f]/',				// url encoded 16-31
		'/[\x00-\x08]/',			// 00-08
		'/\x0b/',					// 11
		'/\x0c/',					// 12
		'/[\x0e-\x1f]/'				// 14-31
	);
	foreach($non_displayables as $regex)
		$data = preg_replace($regex,'',$data);
		$data = str_replace("'","''",$data);
	return $data;
}
	$conn = Database::getInstance();
	if (session_id() == ""){
	session_start();}
	elseif(!isset($_SESSION['UserUID'])){
		header("Location: index.php");
		exit;
	}
	$uid = $_SESSION['UserUID'];
    $ticketID = $_REQUEST['ticketID'];    
    
    include('config.inc.php');
	$sql = $conn->prepare("SELECT * FROM Website.dbo.Ticket WHERE ticketID = ? ORDER BY ticketUID DESC");
	$sql->bindParam(1, $ticketID, PDO::PARAM_INT);
    $sql->execute();
	$row = $sql->fetch(PDO::FETCH_ASSOC);
    echo "<div class='col-md-8'>";
    echo "<h5>Category: ".$row[4]."</h5>";

    
 	$ssql = $conn->prepare("SELECT * FROM Website.dbo.Ticket WHERE ticketID = ?  AND Status = 0 ORDER BY ticketUIDC");
	$ssql->bindParam(1, $ticketID, PDO::PARAM_INT);
	$ssql->execute();
    
  while ($rrow = $ssql->fetch(PDO::FETCH_ASSOC)){
    echo "<div class='col-md-8'>";
    echo "<p class='bg-success'> Message: ".$rrow[6]."</p>";
    echo "<p class='bg-danger'> Answer: ".$rrow[10]."</p>";
  }

    echo "<p class='bg-success'> Message: ".$row[6]."<br></p>";
    if ($row[10] != NULL){
    echo "<p class='bg-danger'> Answer: ".$row[10]."</p>";
    }

    if ($row[3] == 1){
if (isset($_POST['submit'])) {
            $status = $_POST['status'];
            $answer = mssql_escape_string($_POST['answer']);
    
            $date= date('d/m/y H:i:s');
			
			$sql = $conn->prepare("UPDATE Website.dbo.Ticket SET Status = ?, Date = ?', New = 1, Answer = ? WHERE ticketUID = ?;");
			$sql->bindParam(1,$status,PDO::PARAM_INT);
			$sql->bindParam(2,$date,PDO::PARAM_INT);
			$sql->bindParam(3,$answer,PDO::PARAM_INT);
			$sql->bindParam(4,$row[0],PDO::PARAM_INT);
			$sql->execute();
    header('location: index.php?action=tickets');
    exit();
}
        
?>
<form action="details.php?ticketID=<? echo $ticketID;?>" method="POST">
<label for='answer'>Answer: </label>
<textarea rows='5' cols='100' name="answer" id='answer'></textarea>
</br>
 Status:<select name="status">
  <option value="1">Active</option>
  <option value="2">Closed</option>
</select>
<p><input type="submit" value="Send" name="submit" style="margin: 30px 0 0 120px;"/></p>
</form>
<?
}
    echo "</div>";
?>
