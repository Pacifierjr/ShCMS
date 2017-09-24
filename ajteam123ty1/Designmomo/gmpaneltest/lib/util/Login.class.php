<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
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
	
	public static function show($fehler = ''){
		if (strlen($fehler) > 1)
			echo '<font color="red">'.$fehler.'</font><br>';
		
		 self::$action = '?action=login';
		
		echo '<form action="'.$_SERVER['PHP_SELF'].self::$action.'" method="POST">
			  <table border="0">
			  <tr>
				<td>Username: </td><td><input type="text" name="benutzername" maxlength="18"></td>
			  </tr>
			  <tr>
				<td>Password: </td><td><input type="password" name="passwort" maxlength="12"></td>
			  </tr>
			  <tr>
				<td></td><td><input type="submit" name="Login" value="Einloggen"></td>
			  </tr>	
			  </table>	
			  </form>';
		exit();
	}
	
	public static function check(){
		self::$userid = Parser::validate($_POST['benutzername']);
		self::$pw	  = Parser::validate($_POST['passwort']);
		
		self::$sql = "SELECT [UserUID] FROM [PS_UserData].[dbo].[Users_Master] WHERE [UserID] = '".self::$userid."' AND [Pw] = '".self::$pw."'";
		self::$res = mssql_query(self::$sql);
		
		if (mssql_num_rows(self::$res) != 1)
			self::show('Nom dutilisateur ou mot de passe incorrect.');
		
		self::$fet = mssql_fetch_array(self::$res);
		self::$uid = self::$fet[0];
		
		self::$user = new user(self::$uid);
		
		if (!self::$user->isAdm())
			self::show('Vous devez avoir les privileges GM pour accéder a cette page.');
		
		Session::set(self::$uid);
		
		return self::$user;
	}
}

?>