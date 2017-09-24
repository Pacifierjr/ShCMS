<center>
    <?php 
        
    if(($arg > 0) && ($pagename == "SendPlayerPM")){
        $value = $arg;
    }
    
    if(isset($value)){
        $account = new Account($value);
        $value = $account->Get("UserID");
        $readonly = "readonly";
    }
    
    if((!isset($readonly)) || (!isset($value))){
        $readonly = $value = "";
    }
    
    if(!$CurrentUser->IsLoggedIn()){
        include('core/reqlogin.inc.php');
    }
    else{
        if(isset($_POST["send"])){
            $user = new Account($_POST["UserName"]);
            if($user->Exists()){
                send_pm($user->Get("UserUID"),$_POST["Title"], $_POST["Content"], $uid);
                echo("Message sent!");          
            }else{
                echo("User doesn't exists!");
            }
        }
        if(!isset($msgtitle)){
            $msgtitle = "";
    }
    
    ?>
   <br/>
    <form action="/SendPlayerPM" method="POST">
    UserName (/!\ not display name): <input type="text" name="UserName" value="<?=$value?>" <?=$readonly?>/><br/>
    
    <input type="text" name="Title" placeholder="Message Title" value="<?=$msgtitle?>" style="width: 550px;"/><br/>
    <textarea name="Content" style="width: 550px; height: 400px;" placeholder="Message..." ></textarea>
        
    <input type="Submit" name="send" value="Send message">
    
    </form>
    </center>
    <?
    }
?>