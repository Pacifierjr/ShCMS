<?
if (session_id() == ""){
    session_start();
}
if(!isset($_SESSION['UserUID'])){
        $uid = 0;
    }else{
        $uid = $_SESSION['UserUID'];
        $desc = $_POST['text'];
    }

include('../pdoConnect.inc.php');

$date = date("H:i:s A",strtotime("+2 hours"));

    $queryPoint = $conn->prepare('INSERT INTO Website.dbo.Chat (user_uid, message, time) VALUES (?,?,?)');
	$queryPoint->bindValue(1, $uid, PDO::PARAM_INT);
	$queryPoint->bindValue(2, $desc, PDO::PARAM_INT);
	$queryPoint->bindValue(3, $date, PDO::PARAM_INT);
	$queryPoint->execute();

?>