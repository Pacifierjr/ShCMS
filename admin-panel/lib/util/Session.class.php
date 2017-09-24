<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class Session{
	private static $user;
	
	public static function check(){
		
		if (!isset($_SESSION['Login']) || !isset($_SESSION['IP']) || !isset($_SESSION['UserUID']))
			login::show();
		
		if (oIP::vier($_SESSION['IP']) != IP::vier())
			login::show('Session expired. (IP)');
		
		if (!Parser::gint($_SESSION['UserUID']))
			login::show('Session expired.');
		
		self::$user = new user($_SESSION['UserUID']);
		
		if (!self::$user->isAdm())
			login::show('You need full GM privileges to access this page.');
		
		return self::$user;
	}
	
	public static function set($uid){
		$_SESSION['Login']		= true;
		$_SESSION['IP']			= $_SERVER['REMOTE_ADDR'];
		$_SESSION['UserUID']	= $uid;
	}
	
	public static function delete(){
		unset($_SESSION['Login']);
		unset($_SESSION['IP']);
		unset($_SESSION['UserUID']);
	}
}

?>