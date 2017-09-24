<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

class Login{
	private static $uid;
	private static $user;
	private static $userid;
	private static $pw;
	private static $action;
	private static $sql;
	private static $res;
	private static $fet;
	private static $conn;

	public static function show($fehler = ''){
		echo  '<head>
				<title>GM Tool v. '.GM_TOOL_VERSION.' | Login</title>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<meta name="language" content="en">
				<meta name="Robots" content="noindex, nofollow">
				<meta http-equiv="expires" content="0">
				<meta name="copyright" content="Trayne & eQuiNox | www.shaiya.pf-control.de">
				<meta name="copyright" content="Trayne & eQuiNox | www.shaiya.pf-control.de">
				<meta http-equiv="content-type" content="text/html; charset=UTF-8">
				<meta http-equiv="content-script-type" content="text/javascript">
				<meta http-equiv="content-style-type" content="text/css">
				<link rel="stylesheet" type="text/css" href="css/style.css">	
				<link rel="SHORTCUT ICON" href="images/favicon.ico" type="image/x-icon">
				<link rel="stylesheet" href="js/jquery-ui.min.css">
				<script type="text/javascript" src="js/jquery-latest.min.js"></script>
				<script src="js/jquery-ui.min.js"></script>
				<style>
				tr,th,td { 
					border: 0px;
				}
				</style>
			</head>
			<body>';
		if (strlen($fehler) > 1)
			echo '<font color="red">'.$fehler.'</font><br>';
		
		 self::$action = '?action=login';
		
		echo '<center>
				<form action="'.$_SERVER['PHP_SELF'].self::$action.'" method="POST" style="margin-top:30%;background-color:rgba(0,0,0,0.5);width:340;">
					<table border="0" border-collapse: collapse;>
					  <tr>
						<td>Username: </td><td><input type="text" name="username" maxlength="18"></td>
					  </tr>
					  <tr>
						<td>password: </td><td><input type="password" name="password" maxlength="12"></td>
					  </tr>
					  <tr>
						<td></td><td><input type="submit" name="Login" value="Login"></td>
					  </tr>	
					</table>	
				</form>
			  </center>';
		echo  '</body>';
		exit();
	}
	
	public static function check(){
		self::$conn = dbConn::getConnection();
		self::$userid = Parser::validate($_POST['username']);
		self::$pw	  = Parser::validate($_POST['password']);
		
		self::$sql = self::$conn->prepare("SELECT [UserUID] FROM [PS_UserData].[dbo].[Users_Master] WHERE [UserID] = '".self::$userid."' AND [Pw] = '".self::$pw."'");
		self::$sql->execute();
		
		
		self::$fet = self::$sql->fetch(PDO::FETCH_BOTH);		
        if(isset(self::$fet[0])){
            if (self::$fet[0] != null){
                self::$uid = self::$fet[0];
        

                self::$user = new user(self::$uid);

                if (!self::$user->isAdm())
                    self::show('You need full GM privileges to access this page.');

                Session::set(self::$uid);

                return self::$user;
            }else{
                self::show('Wrong User and/or Password');
            }
             self::show('Wrong User and/or Password');
        }
	}
}

?>