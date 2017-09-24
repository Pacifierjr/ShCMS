<?
if (session_id() == ""){
    session_start();
}
include('../pdoConnect.inc.php');
$query1 = $conn->prepare("SELECT Grade FROM PS_UserData.dbo.Users_Master WHERE UserUID= ?");
$query1->bindValue(1, $uid, PDO::PARAM_INT);
$query1->execute();
$row1 = $query1->fetch(PDO::FETCH_NUM);
if(row1[0] != NULL){
    
        $row = $_GET['row'];  

    $queryPoint = $conn->prepare('DELETE FROM Website.dbo.Chat WHERE Row > 0');
	$queryPoint->bindValue(1, $row, PDO::PARAM_INT);
	$queryPoint->execute();
}

?>