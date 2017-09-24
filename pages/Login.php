<h1><center>Login Form test</center></h1>
			<center><img src="img/line.png" /></center>
		
			<script>
					function loginNowa(){
                        
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
				

		

<center>
<?php
if($uid == 0){
?>
						<br/>
								<input type="text" name="login_username" id="login_username" value="" placeholder="Username"/><br/><br/>
								<input type="password" name="login_password" id="login_password" value="" placeholder="Password"/>
								<center><p id="login_error" style="text-align:left;"></p></center>
								<br/>
						
                                <input checked="false" id="RememberMe" name="RememberMe" type="checkbox" value="false" />			
                                <label for="RememberMe">Remember me</label>
                        
						<br/>
						<br/>
								<input type="submit" name="login_submit" value="Login" onclick="loginNowa()"/><br/>
		<?php 
}else{
		?>
		You are now connected to our website.
		<?php 
}
		?>
		<img src="img/line.png" />
	
	
</center>
