<?php 
if(isset($_GET["row"])){
    
    include('config.inc.php');
    session_start();
    $uid = -1;
    if(isset($_SESSION["UserUID"])){
        $uid = $_SESSION["UserUID"];
    }
    include('pdoConnect.inc.php');
    include('classes/Account.class.php');
    $CurrentUser = new Account($uid);
    $query = $conn->prepare("SELECT * FROM Website.dbo.Chat WHERE Row = ?");
    $query->bindParam(1,$_GET["row"],PDO::PARAM_INT);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_BOTH);
    
    if($CurrentUser->IsAdm() || ($res["user_uid"] == $CurrentUser->Get("UserUID"))){
            $query = $conn->prepare("DELETE FROM Website.dbo.Chat WHERE Row = ?");
            $query->bindParam(1,$_GET["row"],PDO::PARAM_INT);
            $query->execute();
    }
    
      
}

?>

