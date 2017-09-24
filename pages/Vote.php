<h1>Shaiya Europe Vote 4 DP</h1>
			<center><img src="img/line.png" /></center>

<link rel="stylesheet" type="text/css" href="css/styles_vote.css" />
<link rel="stylesheet" type="text/css" href="css/default.theme.css" />
<link href="css/dark-hive/jquery-ui-1.10.4.custom.css" rel="stylesheet">


<div id="modal_popup"><div id="modal_container"><div id="modal_close" onclick="modal_close();"><span style="font-family:Wingdings">&#251;</span></div><div id="modal_content"></div></div></div>
<div id="body"><br/><br/><br/>

<div id="register_frame">
                            <form name="Vote" method="POST" action="Vote" id="Vote" target="_new">

<fieldset>

    <div>


        <table>
            <div id="wb_Text1" align="left">
            </div>


            <div id="container">
                <div id="wb_Form1" align="left">
                           <div id="wb_Text1" align="left">

                          <tr>  
                            <div id="wb_Text2" align="left">
                                
                                <?php
                                
                                if(isset($_POST["Vote"])){
                                    $site = "";
                                    $site = $_POST["site"];
                                    
                                    $query = $conn->prepare("SELECT TOP 1 date FROM Website.dbo.Users_Vote WHERE ip = ? AND site = ? ORDER BY date ASC");
                                    $query->bindParam(1,$_SERVER['REMOTE_ADDR'],PDO::PARAM_INT);
                                    $query->bindParam(2,$site,PDO::PARAM_STR);
                                    $query->execute();
                                    $res = $query->fetch(PDO::FETCH_BOTH);
                                    
                                    $date = date("Y-m-d H:i:s", time() - $WaitHours * 3600);
                                    
                                    if ( strtotime($res["date"]) < strtotime($date) ) {
                                        
                                        $query = $conn->prepare("INSERT INTO Website.dbo.Users_Vote VALUES (?,?,GETDATE(),?)");
                                        $query->bindParam(1,$uid,PDO::PARAM_INT);
                                        $query->bindParam(2,$_SERVER['REMOTE_ADDR'],PDO::PARAM_STR);
                                        $query->bindParam(3,$site,PDO::PARAM_STR);
                                        $query->execute();
                                        
                                        $query = $conn->prepare("UPDATE PS_UserData.dbo.Users_Master SET Point = Point + ".$PointsPerVote." WHERE UserUID = ?");
                                        $query->bindParam(1,$uid,PDO::PARAM_INT);
                                        $query->execute();

                                        
                                        
                                        echo("<font color='green'>*  Vote sucess.</font><br/><br/>");
                                        
                                        
                                        echo('<script type="text/JavaScript"> setTimeout(function () {
   window.location.href = "'.$vote_site[$site].'"; //will redirect to your blog page (an ex: blog.html)
}, 2000); //will call the function after 2 secs.</script>');
                                        
                                    } else {
                                        echo("<font color='red'>*  You must wait 12 hours beteween votes.</font><br/><br/>");

                                    }
                                    
                                }
                                
                                ?>
                                <br/>
                                You can vote each 12 hours.<br/>You'll earn 25 DP per vote.<br/>
                                <br>
                            </div>
                               </tr>
                            <tr><input type="radio" name="site" value="nr1" checked> XtremeTop100 (last vote: <?  
                                                                                                                $query = $conn->prepare("SELECT TOP 1 date FROM Website.dbo.Users_Vote WHERE UserID = ? AND site = 'nr1' ORDER BY date ASC");
                                                                                                                $query->bindParam(1,$uid,PDO::PARAM_INT);
                                                                                                                $query->execute();
                                                                                                                $res = $query->fetch(PDO::FETCH_BOTH);
                                                                                                                if($res == null){
                                                                                                                    $res = "Never.";
                                                                                                                }else{
                                                                                                                    $res = render_date($res["date"]);
                                                                                                                }
                                                                                                                echo($res);
                                                                                                                ?>)<br>
                            <input type="radio" name="site" value="nr2"> OxigenTop100 (last vote: <?  
                                                                                                                $query = $conn->prepare("SELECT TOP 1 date FROM Website.dbo.Users_Vote WHERE UserID = ? AND site = 'nr2' ORDER BY date ASC");
                                                                                                                $query->bindParam(1,$uid,PDO::PARAM_INT);
                                                                                                                $query->execute();
                                                                                                                $res = $query->fetch(PDO::FETCH_BOTH);
                                                                                                                if($res == null){
                                                                                                                    $res = "Never.";
                                                                                                                }else{
                                                                                                                    $res = render_date($res["date"]);
                                                                                                                }
                                                                                                                echo($res);
                                                                                                                ?>)<br>
                            <input type="radio" name="site" value="nr3"> GamingTop100 (last vote: <?  
                                                                                                                $query = $conn->prepare("SELECT TOP 1 date FROM Website.dbo.Users_Vote WHERE UserID = ? AND site = 'nr3' ORDER BY date ASC");
                                                                                                                $query->bindParam(1,$uid,PDO::PARAM_INT);
                                                                                                                $query->execute();
                                                                                                                $res = $query->fetch(PDO::FETCH_BOTH);
                                                                                                                if($res == null){
                                                                                                                    $res = "Never.";
                                                                                                                }else{
                                                                                                                    $res = render_date($res["date"]);
                                                                                                                }
                                                                                                                echo($res);
                                                                                                                ?>)<br>
                            <input type="radio" name="site" value="nr4"> Top of Games (last vote: <?  
                                                                                                                $query = $conn->prepare("SELECT TOP 1 date FROM Website.dbo.Users_Vote WHERE UserID = ? AND site = 'nr4' ORDER BY date ASC");
                                                                                                                $query->bindParam(1,$uid,PDO::PARAM_INT);
                                                                                                                $query->execute();
                                                                                                                $res = $query->fetch(PDO::FETCH_BOTH);
                                                                                                                if($res == null){
                                                                                                                    $res = "Never.";
                                                                                                                }else{
                                                                                                                    $res = render_date($res["date"]);
                                                                                                                }
                                                                                                                echo($res);
                                                                                                                ?>)<br><br/></tr>

                                                
                            </div>
                              
                            <tr>   <td> Account:</td><td><input type="text" id="Editbox1"  name="UserID" value="<?=$CurrentUser->Get("UserID")?>" placeholder="Utilisateur" autocomplete="off" maxlength="12" readonly></td></tr>

                </div>
                    
                </div>
                </table>		<br/>

    </div>

    <tr><img style="opacity:0.6;filter:alpha(opacity=60)" src="img/votenew.jpg" border="0" alt="Shaiya Servers" >
    <img style="opacity:0.6;filter:alpha(opacity=60)" src="img/button_1.gif" border="0" alt="Shaiya Servers" >
            <img style="opacity:0.6;filter:alpha(opacity=60)" src="img/vote.gif" border="0" alt="Shaiya Servers" >
            <img style="opacity:0.6;filter:alpha(opacity=60)" src="img/0006xbhs.gif" border="0" alt="Shaiya Servers" ></tr><br/>
    <center><div class="table_frame">

    <table>
    <tr><input type="submit" id="Button1" name="Vote" value="Vote!"></tr>
        </table>

        </div>

        </center>
         

</fieldset>                        </form>

                </div><br/><br/><br/>
</div>






		<center>	<img src="img/line.png" /></center>
