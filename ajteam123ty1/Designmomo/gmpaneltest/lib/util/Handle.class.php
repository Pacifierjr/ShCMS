<?php

/**
 * @author		eQuiNoX
 * @copyright	2011 - 2012 Shaiya Productions
**/

class Handle{
	private static $action;
	private static $gm;
	private static $handle;
	
	
	public static function handleAction($action, &$gm){
		self::$action	= $action;
		self::$gm		= $gm;
		
		Lizenz::Ae4uBViOmxES(GM_ID);
		
		if (!file_exists('lib\actions\\'.self::$action.'.class.php'))
			throw new SystemException('Action '.self::$action.' existe pas', 0, 0, __FILE__, __LINE__);
		
		require_once('lib\actions\\'.self::$action.'.class.php');
		
		self::$action = self::$action.'Action';
		
		$handle = new self::$action(self::$gm);
		
		Design::auf(self::$gm);
		
		$handle->execute();
		
		Design::zu();
	}
}

?>