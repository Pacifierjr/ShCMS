<?php

$GLOBALS['isonline'] = 0;

function getmicrotime(){

    list($usec, $sec) = explode(" ",microtime());

    return ((float)$usec + (float)$sec);

}



///////////////////////////////////////////////

//////  Server Online Status   ////////////////

//////////   Functions    /////////////////////

//////  Created By [DEV]Lube   ////////////////

///////////////////////////////////////////////

function check_server_status($service){

        global $sqlHost;
        echo(sqlHost);

        
		//$hostIp = '151.80.177.114'; // Server IP (Leave alone if on same server as script)


        $hostIp = $sqlHost;

		if($service == "game"){

			$portNumbers = array(30810); // Ports to check for a status on		

		}elseif($service == "login"){

			$portNumbers = array(30800); // Ports to check for a status on			

		}

		$portNames = array(''); // Names for the ports checked

		///////////////////////////////////////////////////////////////////////////////

		////////  DO NOT EDIT BELOW THIS UNLESS YOU UNDERSTAND WHAT YOUR DOING ////////

		///////////////////////////////////////////////////////////////////////////////		

		$portStatus='';

		$portStatus.=''; // Begin display creation

		for($i=0;$i<count($portNumbers);$i++){ // Loop the portNumber array

		    $portConn = @fsockopen($hostIp, $portNumbers[$i], $errno, $errstr, 2); // Assign a variable to the connection attempt

			if(is_resource($portConn)){ // Verify the port is open and display

				$portStatus.= '<font color="#b6ff08">Online</font>'; // Add online status of checked port

                if($service == "game"){

                $GLOBALS['isonline'] = 1;}

				fclose($portConn); // Close the port connection

			}else{ // Alternate response given if port is closed

				$portStatus.= '<font color="#cc0000">Offline</font>'; // Add offline status of checked port

			}	

		}

		return $portStatus; // Return the results to the page in teh location called

	}

function check_server_players($conn,$method=null){

	$query = $conn->prepare ('

SELECT g.Country

FROM PS_GameData.dbo.UserMaxGrow g

JOIN PS_GameData.dbo.Chars m ON g.UserUID = m.UserUID

WHERE m.LoginStatus = 1');

$query->execute();

$light = $dark = 0;

$total = $light + $dark;            

while ($row = $query->fetch(PDO::FETCH_NUM)){

	if($method==null){

		switch($row[0]){

			case 0: $light++; break;

			case 1: $dark++; break;        

		} 		

	}else{

		$total = $total + 1;

	}

  

}


if($method ==null){

	



    $light = $light * $light + $light +1;

    $dark = $dark * $dark + $dark +2;

    $total = $light + $dark;

    if($GLOBALS['isonline'] == 0){

        $total = 0;

        $light = 0;

        $dark = 0;

    }

	return $total . " (lights: ".$light."  darks: ".$dark.")";	

}else{

	return $total;	

}



}



 function get_top_character($conn){    

	$sql="SELECT TOP 7 c.*, um.Status, v.Country FROM PS_GameData.dbo.Chars AS c INNER JOIN PS_UserData.dbo.Users_Master AS um ON c.UserUID=um.UserUID INNER JOIN PS_GameData.dbo.UserMaxGrow as v ON c.UserUID = v.UserUID WHERE c.Del=0 AND um.Status=0 ORDER BY (c.K1 / (c.K2+1)) DESC";  

   $query= $conn->prepare($sql);

   $query->execute();

   $cnt=0;

   $return = "";

   while ($row = $query->fetch(PDO::FETCH_BOTH)){    

    $cnt++;

	$return = $return.'

	

	<tr>



    <td><font color="#bb0026">'.$cnt.'</font></td>

	<td><span id="Country'.$row["Country"].'"></span></td>

    <td><div align="left"><a href="Account.'.$row[2].'">'.$row[1].'</a></div></td>



    <td><div align="right"><font color="#bb0026">'.round($row[39]/ ($row[40]+1),2).'</font></div></td>



    </tr>';

	

   }

  

  return $return;

 }



 function IsConnected($uid){

	 $ret = false;

	 if($uid != 0){

		 $ret = true;

	 }else{

		 $ret = false;

		 include('core/reqlogin.inc.php');

	 }

	 return $ret;

 }

 

 function GetID($uid,$conn){

		$ret = $conn->prepare('SELECT TOP 1 UserID FROM PS_UserData.dbo.Users_Master WHERE UserUID = ?');

		$ret->bindParam(1, $uid, PDO::PARAM_INT);

		$ret->execute();

		$id = $ret->fetch(PDO::FETCH_ASSOC);

		return $id["UserID"];  

 }

function showTop($testo, $lunghezza, $puntini) {

     $ellipses = $puntini;

    $testo = strip_tags($testo);

    if (strlen($testo) <= $lunghezza) {

        return $testo;

    }



    $ultimo_spazio = strrpos(substr($testo, 0, $lunghezza), ' ');



    $ant = substr($testo, 0, $ultimo_spazio);

    if ($ellipses) {

        $ant .= ' ...';

    }

    return $ant;

}  

function KillToGrade($kills){

	$grade = 0;

	if ($kills <= 0) { $grade = 0;}

						elseif( $kills < 50 ) { $grade = 1;}

						elseif( $kills < 300 ) { $grade = 2;}

						elseif( $kills < 1000 ) { $grade = 3;}

						elseif( $kills < 5000 ) { $grade = 4;}

						elseif( $kills < 10000 ) { $grade = 5;}

						elseif( $kills < 20000 ) { $grade = 6;}

						elseif( $kills < 30000 ) { $grade = 7;}

						elseif( $kills < 40000 ) { $grade = 8;}

						elseif( $kills < 50000 ) { $grade = 9;}

						elseif( $kills < 70000 ) { $grade = 10;}

						elseif( $kills < 90000 ) { $grade = 11;}

						elseif( $kills < 110000 ) { $grade = 12;}

						elseif( $kills < 130000 ) { $grade = 13;}

						elseif( $kills < 150000 ) { $grade = 14;}

						elseif( $kills < 200000 ) { $grade = 15;}

						elseif( $kills < 250000 ) { $grade = 16;}

						elseif( $kills < 300000 ) { $grade = 17;}

						elseif( $kills < 350000 ) { $grade = 18;}

						elseif( $kills < 400000 ) { $grade = 19;}

						elseif( $kills < 450000 ) { $grade = 20;}

						elseif( $kills < 500000 ) { $grade = 21;}

						elseif( $kills < 550000 ) { $grade = 22;}

						elseif( $kills < 600000 ) { $grade = 23;}

						elseif( $kills < 650000 ) { $grade = 24;}

						elseif( $kills < 700000 ) { $grade = 25;}

						elseif( $kills < 750000 ) { $grade = 26;}

						elseif( $kills < 800000 ) { $grade = 27;}

						elseif( $kills < 850000 ) { $grade = 28;}

						elseif( $kills < 900000 ) { $grade = 29;}

						elseif( $kills < 1000000 ) { $grade = 30;}

						else{

						$grade = 61;}

					return $grade;

}

function SetPageTitle($title){

    



            $buffer=ob_get_contents();

            ob_end_clean();

            $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);



            echo $buffer;

} 

function RenderForumPost($conn,$threadid,$num=1,$viwerip = null,$viwerid = null){

            $ParentSection = $conn->prepare("SELECT * FROM Website.dbo.ForumThreads INNER JOIN PS_UserData.dbo.Users_Master ON Website.dbo.ForumThreads.PosterUID = PS_UserData.dbo.Users_Master.UserUID WHERE Website.dbo.ForumThreads.ID = ?;");

            $ParentSection->bindParam(1,$threadid,PDO::PARAM_INT);

            $ParentSection->execute();

            $thread = $ParentSection->fetch(PDO::FETCH_ASSOC);

            $sthread = new Thread($thread["ID"]);

            

        if((!$sthread->SeenByUsr($viwerid)) && (!$sthread->SeenByIp($viwerip))){

                $query = $conn->prepare("INSERT INTO Website.dbo.ForumViews ([ThreadID],[UserIP],[UserUID],[Date]) VALUES (?, ?, ?, GETDATE());");

                $query->bindParam(1,$threadid,PDO::PARAM_INT);

                $query->bindParam(2,$viwerip,PDO::PARAM_INT);

                $query->bindParam(3,$viwerid,PDO::PARAM_INT);

                $query->execute();

                

                $query = $conn->prepare("UPDATE Website.dbo.ForumThreads SET [View] = [View] + 1 WHERE ID = ?;");

                $query->bindParam(1,$threadid,PDO::PARAM_INT);

                $query->execute();

            }

    

    

            $posteraccount = new Account($thread["UserUID"]);

            global $uid;

            $delcode = "";

            global $CurrentUser;

            if(($CurrentUser->IsAdm()) || (($posteraccount->Get("UserUID") == $uid))){

                $delcode = '<a href="ForumThreadEdit.'.$thread["ID"].'" style="margin-right:10px;"><img src="img/icon/forum/edit_btn.png"/></a>'

                            . '<a href="ForumThreadDelete.'.$thread["ID"].'"><img src="img/icon/forum/remove.png"/></a>';

            }

    ?>

<table id="" class="tborder" cellpadding="6" cellspacing="2" border="0" width="100%" align="center">

	<tbody>

		<tr>

			<td class="thead" style="font-weight:normal; border: 1px solid #EDEDED; border-right: 0px"><img width="10" height="11" class="inlineimg" src="img/icon/forum/post_old.gif" alt="Old" border="0" title="Old"><span itemprop="datePublished" content="2016-08-07T17:50:40+02:00"><?=render_date($thread["PostDate"])?></span></td>

			<td class="thead" style="font-weight:normal; border: 1px solid #EDEDED; border-left: 0px" align="right"><?=$delcode?>&nbsp;#<strong><?=$num?></strong></a></td>

		</tr>

		<tr valign="top">

			<td class="alt2" width="175" style="padding: 10px; border: 1px solid #EDEDED; border-top: 0px; border-bottom: 0px">

				

               

				<div class="smallfont">

				&nbsp;<br>

                <? 

                $PosterUser = new Account($thread["PosterUID"]);

                ?>

                <div class="postbar">

                    <div id="Faction<?=$PosterUser->GetFaction()?>"></div> - <?=$PosterUser->GetFaction("full")?><br/>

				</div><br/><center>

                    	<a class="bigusername" href="/Account.<?=$thread["PosterUID"]?>"><span itemprop="author" itemscope="" itemtype="http://schema.org/Person"><span itemprop="name"><?=$thread["UserID"]?> <?

                                $color = "";

                                switch($PosterUser->Get("Grade")){

                                case 'Admin': $color = "red"; break;

                                case 'GameMaster': $color = "blue"; break;

                                case 'GameSage': $color = "green"; break;     

                                }

                                if($color != ""){

                                    echo(' - <span style="color:'.$color.';font-size:10px;">'.$PosterUser->Get("Grade").'</span>');

                                }

                            ?></span></span></a>

                <?

                if($PosterUser->Get("MainCharID") != null){

                    $PosterMainChar = new Char($PosterUser->Get("MainCharID"));

                    $PosterMainChar->PrintIcon();   

                ?></center><br/>

                    <table style="font-size:12px;" cellspacing="5">

                    <tr><td>Main Char:</td><td><?=$PosterMainChar->Get("CharName")?></td></tr>

                    <tr><td>Money:</td><td><?=$PosterMainChar->Get("Money")?> <img src="img/icon/forum/gold.gif" width="12" height="14" style="vertical-align:middle" alt=""></td></tr>

                    <tr><td>Grade:</td><td><div id="Grade<?=KillToGrade($PosterMainChar->Get("K1"))?>"></div></td></tr>

                    </table>

    

		  

                    <?

                     }

                ?>

                     <table style="font-size:12px;" cellspacing="5">

                    <tr><td>Join Date:</td><td><?=render_date($thread["JoinDate"])?></td></tr>

                    <tr><td>Threads:</td><td><?=$PosterUser->ThreadsCnt()?></td></tr>

                    <tr><td>Posts:</td><td><?=$PosterUser->PostsCnt()?></td></tr>

                    </table>

				</div>

			</td>

			<td class="alt1" id="td_post_34968280" style="border-right: 1px solid #EDEDED">

				 

				<div class="smallfont" style="margin:10px;">

					<strong><?=$thread["Title"]?></strong>

				</div>

				<br>

				 

				 

				<div id="post_message_34968280" itemprop="text">

                    <?php 

                    global $parser;



                    $text = $thread["Content"];



                    $parser->parse($text);



                    print $parser->getAsHtml();

                    

                    ?>

				</div>

				 

				 <? 

                if($thread["AttachedURL"] != NULL){

                    

                

                ?>

				<div style="padding:6px">

					<fieldset class="fieldset">

					<legend>Attached Files</legend>

						<table cellpadding="0" cellspacing="3" border="0">

							<tbody><tr>

							<td><img class="inlineimg" src="http://www.elitepvpers.com/forum/images/attach/rar.gif" alt="File Type: rar" width="16" height="16" border="0" style="vertical-align:baseline" title="File Type: rar"></td>

							<td>

							SSE_R1.1.rar

							(3.36 MB, 125 views)

							</td>

							<td>

							</td>

							</tr>

							</tbody>

						</table>

					</fieldset>

				</div>

                <? } 

                ?>

				 

				<br>

				<hr style="float:left;margin-bottom:15px;height:1px;width:150px;border:none;color:#000;background-color:#000"><br/>

                <?php 



                    $text = $PosterUser->Get('Sign');



                    $parser->parse($text);



                    print $parser->getAsHtml();

                    

                    ?>

				<div class="clear"></div>

				 

		

				<br>

				</td>

		</tr>

	</tbody>

</table>

<?

}

function render_date($datetime) {

    $timestamp = strtotime($datetime);

    $date = date('d/m/Y', $timestamp);



    if($date == date('d/m/Y')) {

      $date = 'Today';

    } 

    else if($date == date('d/m/Y', date('d/m/Y') - (24 * 60 * 60))) {

      $date = 'Yesterday';

    }

    return $date . ' ' . date('H:i', $timestamp);;

}

function send_pm($destuid,$title,$content, $posteruid = DEFAULT_ADM){

            global $conn;

            sleep (2);

            $destaccount = new Account($destuid);

            $title = str_replace("<userid>",$destaccount->Get("UserID"),$title);

            $content = str_replace("<userid>",$destaccount->Get("UserID"),$content);



            $query = $conn->prepare("INSERT INTO Website.dbo.PlayerPM VALUES (?,?,1,?,?,GETDATE(),0);");

            $query->bindParam(1,$title,PDO::PARAM_STR);

            $query->bindParam(2, $content,PDO::PARAM_STR);

            $query->bindParam(3, $posteruid,PDO::PARAM_INT);

            $query->bindParam(4, $destuid,PDO::PARAM_INT);

            $query->execute();

}

?>