				<script>
				//var jqxhr = $.post( "core/test.php", { func: "getNameAndTime" }, function( data ) {
 // alert( data.name ); // John
  //alert( data.time ); // 2pm
//}, "json");



					function loginNow(){	
						var username = $("#login_username").val();
						var password = $("#login_password").val();
						$("#login_error").text("Now loading...");
                        $.post('./core/login.call.php',
                            {
                                user: username,
                                pass: password
                            
                            }, function(data) {
                                $("#login_error").text(JSON.parse(data)["msg"]);
                            if(JSON.parse(data)["msg"] == "Successful authentication. Please wait.."){
                                window.location.replace("/Home");
                            }
                        });
					}
				</script>
				
	<div id="sonas" >

						<div id="Scontainer">
						<a href=#><strong><br/><h3>Member Area</h3></strong></a><br/>
						<? if ($uid == 0){ ?>


						<br/>
								<input type="text" name="login_username" id="login_username" value="" placeholder="Username"/><br/><br/>
								<input type="password" name="login_password" id="login_password" value="" placeholder="Password"/>
								<p id="login_error" style="text-align:left;"></p>
								<br/>
						
                                <input checked="false" id="RememberMe" name="RememberMe" type="checkbox" value="false" />			
                                <label for="RememberMe">Remember me</label>
                        
						<br/>
						<br/>
														<center>
<input type="submit" name="login_submit" value="Login" onclick="loginNow()"/>
								</center>
								

						<? } else {
                            
                            $query = $conn->prepare("SELECT COUNT(*) AS Counter FROM Website.dbo.PlayerPM WHERE DestUID = ? AND (IsNew = 1 OR ForceIsNEw = 1);");
                            $query->bindParam(1,$uid,PDO::PARAM_INT);
                            $query->execute();
                            $res = $query->fetch(PDO::FETCH_BOTH);
                            
                            ?>

						
							Welcome <span style="font-weight:bold;"><? echo($username); ?></span>
							<br/>
							<div><img class="player_coin" src="img/europepoints.png" title="Elements Points"> <? echo($points); ?></div>
						<ul id="left_menu">
						<li><a href="Account">Edit Account</a></li>
                         <li><a href="RecvPM">My PM <br/> - <?=$res["Counter"]?> new message(s).</a></li>

						<li><a href="Shoutbox">Shoutbox</a></li>
						<li><a href="Support">Tickets</a></li>
						<li><a href="Donate">Donation</a></li>
						<li><a href="Rules">Server Rules</a></li>
						<li><a href="Boss">Boss Countdown</a></li>
						<li><a href="Vote">Vote</a></li>
						<li><a href="Store">Store</a></li>


						</ul>
					   
						<? } ?><br/><br/>

						</div>
			
			
						<div class="tarpastarpnaujienu"></div>

			
			
			
			
			<div id="leader">
			<?php 
			$leaderoftheweek = file_get_contents('LeaderOfTheWeek.txt');
            $leaderoftheweek = new Account($leaderoftheweek);
			?>
				Every week, most PvP kills earned player will be awarded!<br />This week leader - 
				<a href="Account.<?=$leaderoftheweek->Get("UserUID");?>"><?=$leaderoftheweek->Get('Shoutbox');?></a> Congratulations!
			</div>
						<div class="tarpastarpnaujienu"></div>

			<div id="Scontainer"><strong><a href=""><h3><center>Networks</center></h3></a></strong><br/>
						<div id = "leftpix">
	
	<!--<h4><a href="https://www.facebook.com/Shaiya-Element-355984278136112/" target="_blank"><center>Our Facebook</center></a></h4><br/>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<center><div class="fb-page" data-href="https://www.facebook.com/Shaiya-Element-355984278136112/" 
data-tabs="timeline" 
data-width="140" 
data-height="430" 
data-small-header="false" 
data-adapt-container-width="true" 
data-hide-cover="false" 
data-show-facepile="true">
<blockquote cite="https://www.facebook.com/Shaiya-Element-355984278136112/" class="fb-xfbml-parse-ignore">
<a href="https://www.facebook.com/Shaiya-Element-355984278136112/"><center>Shaiya Europe</center></a></blockquote></div>
	<br/><br><h4><a href="https://www.youtube.com/channel/UCwN6ZiZGKr77faWm8pVIyvQ?sub_confirmation=1" 
	target="_blank">
	-->
	
	
	<center>Our Youtube</center></a></h4><br/>
		<script src="https://apis.google.com/js/platform.js" gapi_processed="true"></script>
		<div id="___ytsubscribe_0" 
		style="text-indent: 0px; margin: 0px; padding: 0px; background: transparent; border-style: none; float: none; line-height: normal; font-size: 1px; vertical-align: baseline; display: inline-block; width: 166px; height: 48px;">
		
		<iframe frameborder="0" hspace="0" marginheight="0" marginwidth="0" scrolling="no" 
		style="position: static; top: 0px; width: 166px; margin: 0px; border-style: none; left: 0px; visibility: visible; height: 48px;" 
		tabindex="0" vspace="0" width="100%" id="I0_1482781608176" 
		name="I0_1482781608176" 
		src="https://www.youtube.com/subscribe_embed?usegapi=1&amp;channel=LyrosGames&amp;layout=full&amp;count=default&amp;gsrc=3p&amp;ic=1&amp;jsh=m%3B%2F_%2Fscs%2Fapps-static%2F_%2Fjs%2Fk%3Doz.gapi.fr.hWHekVwD76U.O%2Fm%3D__features__%2Fam%3DAQ%2Frt%3Dj%2Fd%3D1%2Frs%3DAGLTcCPikVhw-X4P7ITWq7y-RFaQ7y4MdA#_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe%2C_renderstart%2Concircled%2Cdrefresh%2Cerefresh%2Conload&amp;pfname=&amp;rpctoken=28643452" data-gapiattached="true"></iframe>
		</div>
	
		

	
					<br/><br/><h4><center></center></h4><br/>
					</div>
					
					
					</div>
					
					
			
			<br/>
			
					<div id="top10">
			<table width="100%" border="0" CELLSPACING="0" cellpadding="1">
			Weekly, random best KDR players will earn a gift!<br/>
			<?=get_top_character($conn);?><br/>
	</table>					
</div>	
	<div class="tarpastarpnaujienu"></div>
	<a href="Donate"><div id="donate">
        </div></a>
	
			<div class="tarpastarpnaujienu"></div>

			<div id="vote">
				<div id="Scontainer">
				<a href="Vote"><h3><center>Vote for us!</center></h3><br/>
				<div id ="leftpix">
				<!--- balsavimo linkai --->		
				<img src="img/xtreme.jpg" border="0" name="sub_but"/>
				<img src="img/oxygene.jpg" border="0" name="sub_but1"/>
				<img src="img/gaming.jpg" border="0" name="sub_but2"/>
				<img src="img/tog.jpg" border="0" name="sub_but3"/>
				<!--- balsavimo linkai --->
</div></a>
				</div>
			</div>
		</div>