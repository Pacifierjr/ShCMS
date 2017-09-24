<h1><center>Shaiya Europe Registration</center></h1>
			<center><img src="img/line.png" /></center><h1 class="top">Sign Up</h1>
<br/>
<?php
$error = 0;
if (isset($_POST['accountname']) && isset($_POST['shoutname']) && isset($_POST['password']) && isset($_POST['rePassword'])){
    echo '<span style="font-size:15px;font-weight:bold;">Failure to create your account. Please read the information below fields.</span>';
	//	enable cookies
	//	clear any previously defined IDs
		if (isset($_SESSION['UserUID']))
			unset($_SESSION['UserUID']);
	
	//	setup a query to get information on player account
		$query = $conn->prepare('SELECT UserUID FROM PS_UserData.dbo.Users_Master WHERE UserID=?');
		if ($query === false)
			die(FormatErrors($query->errorInfo()));
	//	bind the parameter
		$query->bindParam(1, $_POST['accountname'], PDO::PARAM_STR);
	//	execute the query
		if ($query->execute() === false)
			die(FormatErrors($query->errorInfo()));
	//	get response (a single row is expected)
		$row = $query->fetch(PDO::FETCH_NUM);
		if ($row != null){
		//	UserID was valid ...
            $error = 1;
		} 
        elseif(is_numeric($_POST['accountname'])){
        //only numbers issue
            $error = 44;
        }
		else {
            echo("poire");
		//	verify password, depending on actual DB you may have to verify a hash
			if ($_POST['password'] != $_POST['rePassword']){
			//	password was invalid
			$error = 2; 
			} 
			//else if(file_get_contents("http://lyrosgames.com/forum/sdk.php?do=register&mail=".$_POST["email"]."&usr=".$_POST["accountname"]."&pwd=".$_POST["password"]) != "true"){
			//$error = 4;
			//}
			else {
        $query2 = $conn->prepare('SELECT Email FROM PS_UserData.dbo.Users_Master WHERE Email= ?');
		$query2->bindParam(1, $_POST['emailAddress'], PDO::PARAM_STR);
        $query2->execute();
		$row2 = $query2->fetch(PDO::FETCH_NUM);
                $bday = "20/02/1990";
            if(isset($_POST["bday"])){
                if($_POST["bday"] != ""){
                                    $bday = $_POST["bday"];

                }
            }
				if ($_POST['emailAddress'] != $row2[0]){
					$userip = $_SERVER['REMOTE_ADDR'];                            
					$query = $conn->prepare("INSERT INTO PS_UserData.dbo.Users_Master (UserID, Pw, JoinDate, Admin, AdminLevel, UseQueue, Status, Leave, LeaveDate, UserType, Point, EnPassword, UserIp, Birth, IsNew, Shoutbox, Email, Skype, MainCharID, Sign)VALUES (?,?,GETDATE(),0,0,'False',0,0,GETDATE(),'N',100,'',?,?,1,?,?,'','','')");
					$query->bindParam(1, $_POST['accountname'], PDO::PARAM_STR);
					$query->bindParam(2, $_POST['password'], PDO::PARAM_STR);
					$query->bindParam(3, $userip, PDO::PARAM_STR);
                    $query->bindParam(4, $bday,PDO::PARAM_STR);
					$query->bindParam(5, $_POST['shoutname'], PDO::PARAM_STR);
					$query->bindParam(6, $_POST['emailAddress'], PDO::PARAM_STR);
					$query->execute();
					$row = $query->fetch(PDO::FETCH_NUM);

					$query1 = $conn->prepare('SELECT UserUID FROM PS_UserData.dbo.Users_Master WHERE UserID= ?');
					$query1->bindParam(1, $_POST['accountname'], PDO::PARAM_STR);
					$query1->execute();
					$row1 = $query1->fetch(PDO::FETCH_NUM);
					$uid = $row1[0];
					
						$_SESSION['UserUID'] = $uid;
						$_SESSION['Status'] = 0;
                    
                        if((NEW_PLAYER_PM_TITLE != "") && (NEW_PLAYER_PM_MESSAGE != "")){
                            send_pm($row1[0],NEW_PLAYER_PM_TITLE, NEW_PLAYER_PM_MESSAGE);
                        }
                        header("Location: /Home");
						//	redirect to Char selection page
						
							
				} else {
					$error = 3;
				}
				
			}
		}
		//	setup a query to get information on player account
		$query4 = $conn->prepare('SELECT UserUID FROM PS_UserData.dbo.Users_Master WHERE Shoutbox=?');
		if ($query4 === false)
			die(FormatErrors($query4->errorInfo()));
	//	bind the parameter
		$query4->bindParam(1, $_POST['shoutname'], PDO::PARAM_STR);
	//	execute the query
		if ($query4->execute() === false)
			die(FormatErrors($query4->errorInfo()));
	//	get response (a single row is expected)
		$row4 = $query4->fetch(PDO::FETCH_NUM);
		if ($row4 != null){
		//	UserID was valid ...
            $error = 4;
		}
		if(strlen($_POST['password']) < 4 || strlen($_POST['password']) > 12) {
			$error = 5;
		}
		if(strlen($_POST['accountname']) < 4 || strlen($_POST['accountname']) > 12) {
			$error = 6;
		}
		
}
?>
<article>
    	<section class="body">
		<form action="Register" class="page_form" method="post" accept-charset="utf-8">

        <table style="width:80%">
		<tr>
		<td><label for="Username">Username</label></td>
			<td>
				<input type="text" name="accountname" id="accountname" placeholder="Must contain between 4 and 12 characters." value=""/>
                <br>
                <?  if ($error == 1){
                 echo '<span style="color:red; id="username_error">Username already in use. Find another one.</span>';
                    }
                    if ($error == 6){
                 echo '<span style="color:red; id="username_error">Username must contain between 4 and 12 characters.</span>';
					}
                    if($error == 44){
                 echo '<span style="color:red; id="username_error">Username can not contain only numbers.</span>';
 
                    }?>
			</td>
		</tr>
		<tr>
		<td><label for="ShoutName">ShoutName</label></td>
			<td>
				<input type="text" name="shoutname" id="shoutname" placeholder="This pseudo will be used for the ShoutBox." value=""/>
                <br>
                <? if ($error == 4){
                 echo '<span style="color:red; id="username_error">ShoutName already in use. Find another one.</span>';
                }
                 ?>
			</td>
		</tr>
		<tr>
		<td><label for="Email">Email Adress</label></td>
			<td>
				<input type="email" name="emailAddress" id="emailAddress" placeholder="Email Adress" value=""/>
                <br>
                <? if ($error == 3){
                 echo '<span style="color:red; id="email_error">E-mail already in use. Find another one.</span>';
                } ?>
			</td>
		</tr>
		<tr>
		<td><label for="Password">Password</label></td>
			<td>
				<input type="password" name="password" id="password" placeholder="Must contain between 4 and 12 characters." value=""/>
				<br>
				<? if ($error == 5){
                 echo '<span style="color:red; id="password_error">Your password must contain between 4 and 12 characters.</span>';
                } ?>
			</td>
		</tr>
		<tr>
		<td><label for="Confirm Password">Confirm Password</label></td>
			<td>
				<input type="password" name="rePassword" id="rePassword" placeholder="Confirm Password" value="" />
                <br>
                <? if ($error == 2){
                 echo '<span style="color:red; id="password_error">Passwords do not match. Try again.</span>';
                } ?>
			</td>
		</tr>
        <tr>
        <td><label for="Birth">Birthday</label></td>
            <td>
                <input type="date" name="bday" placeoldaer="Birth"/>
            </td>
        </tr>
			</table>
	<center style="margin-bottom:10px;">
		<input type="submit" name="login_submit" value="Register" />
	</center>
</form>    
</article>






		<center>	<img src="img/line.png" /></center>
