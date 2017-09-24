<!-- <center><span style="color:#922424;"> Boost Experience Activated! (during 48H) </span></center> <br> --->

<? 
if (session_id() == ""){
    session_start();
}

if(!isset($_SESSION['UserUID'])){
        $uid = 0;
    }else{
        $uid = $_SESSION['UserUID'];
}

include('../pdoConnect.inc.php');
    $query = $conn->prepare('SELECT TOP 1 Row FROM Website.dbo.chat ORDER BY Row DESC');
    $query->execute();
    $rowQ = $query->FETCH(PDO::FETCH_NUM);
    $row = $rowQ[0] - 50;
    $query2 = $conn->prepare('SELECT Grade FROM PS_UserData.dbo.Users_Master');
    $query2->execute();
    $row2 = $query2->FETCH(PDO::FETCH_NUM);
    $queryMessage = $conn->prepare('SELECT TOP 50 u.Shoutbox, c.message, c.time, c.Row, u.Grade,c.user_uid
                                    FROM Website.dbo.Chat c
                                    JOIN PS_UserData.dbo.Users_Master u ON c.user_uid=u.UserUID
                                    WHERE c.Row > ?
                                    ORDER BY c.row ASC');
    $queryMessage->bindValue(1, $row, PDO::PARAM_INT);
	$queryMessage->execute();
	while ($message = $queryMessage->FETCH(PDO::FETCH_NUM)){
        $color = "";
        switch($message[4]){
        case 'Admin': $color = "red"; break;
        case 'GameMaster': $color = "blue"; break;
        case 'GameSage': $color = "green"; break;        
                
        }
    $query1 = $conn->prepare("SELECT Grade FROM PS_UserData.dbo.Users_Master WHERE UserUID= ?");
    $query1->bindValue(1, $uid, PDO::PARAM_INT);
    $query1->execute();
    $row1 = $query1->fetch(PDO::FETCH_NUM);
    echo '<a href="Account.'.$message[5].'"><span style="font-size:11px;font-weight:bold;">'.$message[0].'</span> </a> <span style="color:'.$color.';font-size:10px;"> '.$message[4].' </span><span style="font-size:9px;color:#D2BDBD;">» '.$message[2].'</span> ';
        if($row1[0] != NULL){ ?><a onclick='javascript:removetext("<? echo $message[3]; ?>");' style="font-size:10px;color:red;cursor:pointer;">(X)</a><? }
    echo '<br> <span>'.$message[1].'</span><br><br>';
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
          
          xmlhttp.open("GET","core/chat/remove.php?row="+id,true);
          xmlhttp.send();
}
</script>
<? } ?>