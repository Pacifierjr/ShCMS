<div id="Mcontainer"><center>
<div id="newsseparator"></div><br/>
    <h2><a href="Notice">Last In-Game notice</a></h2><?
    if(!isset($arg)){
        $arg = 0;
    }
    if(!is_numeric($arg)){
        $arg = 0;
    }
    if ($arg < 15){
        $arg = 100;
    }
    
    $result_notice = $conn->prepare("SELECT TOP ".$arg." CharName, Text1, Text3, ActionTime FROM PS_GameLog.dbo.ActionLog WHERE Text1 = 'NoticeAll' ORDER BY ActionTime DESC");
    $result_notice->execute();
    while($notice = $result_notice->fetch(PDO::FETCH_BOTH))
    {
        $char = new Char($notice['CharName']);
        $user = new Account($char->Get("UserUID"));
        
        echo '<font color=#3C69A8>
            '.$notice['CharName'].' (<a href="Account.'.$user->Get("UserUID").'">'.$user->Get("Shoutbox").'</a>)</font> said: <br/>
             '.render_date($notice['ActionTime']).' :<br/>
            '.$notice['Text3'].'<br/><br/>';
    } ?>
</center></div>
