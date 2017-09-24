
<?
    session_start();
    $uid = -1;
    if(isset($_SESSION["UserUID"])){
        $uid = $_SESSION["UserUID"];    
    }
    include('config.inc.php');
    include('pdoConnect.inc.php');

    //HTML Purifier//
        require_once 'lib/HTMLPurifier.auto.php';

        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);  

        require_once 'classes/Account.class.php';

    $CurrentUser = new Account($uid);
    $query = $conn->prepare('SELECT TOP 1 Row FROM Website.dbo.chat ORDER BY Row DESC');
    $query->execute();
    $rowQ = $query->FETCH(PDO::FETCH_NUM);
    $row = $rowQ[0] - 50;
    $query2 = $conn->prepare('SELECT Grade FROM PS_UserData.dbo.Users_Master');
    $query2->execute();
    $row2 = $query2->FETCH(PDO::FETCH_NUM);
    $queryMessage = $conn->prepare('SELECT TOP 20 u.Shoutbox, c.message, c.time, c.Row, u.Grade, c.user_uid
                                    FROM Website.dbo.Chat c
                                    JOIN PS_UserData.dbo.Users_Master u ON c.user_uid=u.UserUID
                                    WHERE c.Row > (? - 1)
                                    ORDER BY c.row ASC');
    $queryMessage->bindValue(1, $row, PDO::PARAM_INT);
	$queryMessage->execute();
	while ($message = $queryMessage->FETCH(PDO::FETCH_BOTH)){
        $color = "";
        switch($message[4]){
        case 'Admin': $color = "red"; break;
        case 'GameMaster': $color = "blue"; break;
        case 'GameSage': $color = "green"; break;        
                
        }

    $query1 = $conn->prepare("SELECT Grade FROM PS_UserData.dbo.Users_Master WHERE UserUID= ?");
    $query1->bindValue(1, $uid, PDO::PARAM_INT);
    $query1->execute();
    $row1 = $query1->fetch(PDO::FETCH_BOTH);
     if ($message[0] == ""){
       $message[0] = "Unknown";
    }
    echo '<a href="Account.'.$message["user_uid"].'"><span style="font-size:11px;font-weight:bold;">'. $purifier->purify($message[0]).'</span></a> <span style="color:'.$color.';font-size:10px;"> '. $purifier->purify($message[4]).' </span><span style="font-size:9px;color:#D2BDBD;">» '. $purifier->purify($message[2]).'</span> ';
        if($CurrentUser->IsAdm() || ($message["user_uid"] == $CurrentUser->Get("UserUID"))){ ?><a onclick='javascript:removetext("<? echo  $purifier->purify($message[3]); ?>");' style="font-size:10px;color:red;cursor:pointer;">(X)</a><? }
    echo '<br> <span>'. $purifier->purify($message[1]).'</span><br><br>';
	}
if($row2[0] != NULL){
?>
<script>
function removetext(id){
          if (window.XMLHttpRequest) {
            xmlhttp=new XMLHttpRequest();
          } else {
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            }
          }
          
          xmlhttp.open("GET","core/DelChat.call.php?row="+id,true);
          xmlhttp.send();
}
</script>
<? } ?>