	<div id="statusas"><center>
			Login Status: <?=check_server_status("login")?>
			Game Status: <?=check_server_status("game")?><br/>
			Players online: <?=check_server_players($conn)?>	</center>
	</div>		 
	<center>
        <a href="Home">
            <div id="logo"></div>
        </a>
    </center>
	<div id="navigacija">
			<a href="../Home">Home</a>
			<a href="../Infos">ShEurope</a>
			<a href="../Rank">PvP Rank</a>
			<a href="../Download">Download</a>
			<a href="../Forum">Forum</a>
			<? if($status == 16){ 
			?>
				<a href="../admin-panel/" target="_Blank">Admin Panel</a>
			<? } 
			?>
			<? 
			if ($uid > 0){ 
			?>

				<div style="float:right;margin-right:5px;">
					<a href="../Logout">Log Out</a>
				</div>

			<? } 
			else { 
			?>
				<div style="float:right;margin-right:5px;">
                    <a href="../Login">Sign In</a>
				<a href="../Register">Sign Up</a></div>
			<? 
			} 
			?>
	</div>
	
		
