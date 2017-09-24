<?php 
if(isset($_POST["message"])){    
    include('config.inc.php');
    session_start();
    $uid = -1;
    if(isset($_SESSION["UserUID"])){
        $uid = $_SESSION["UserUID"];
    }
    include('pdoConnect.inc.php');
    include('classes/Account.class.php');
    $CurrentUser = new Account($uid);
    $query = $conn->prepare("INSERT INTO [Website].[dbo].[Chat] ([message],[user_uid]) VALUES (?,?)");
    $query->bindParam(1,$_POST["message"],PDO::PARAM_STR);
    $query->bindParam(2,$CurrentUser->Get("UserUID"),PDO::PARAM_INT);
    $query->execute();
    echo($_POST["message"]);
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>

