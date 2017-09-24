<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class Session{
	private static $user;
	
	public static function check(){
		
		if (!isset($_SESSION['Login']) || !isset($_SESSION['IP']) || !isset($_SESSION['UserUID']))
			login::show();
		
		if (oIP::vier($_SESSION['IP']) != IP::vier())
			login::show('session expirée.');
		
		if (!Parser::gint($_SESSION['UserUID']))
			login::show('session expirée.');
		
		self::$user = new user($_SESSION['UserUID']);
		
		if (!self::$user->isAdm())
			login::show('Vous devez avoir les privilèges GM pour accéder à cette page.');
		
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