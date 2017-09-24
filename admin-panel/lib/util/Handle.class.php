<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class Handle{
	private static $action;
	private static $gm;
	private static $handle;
	
	
	public static function handleAction($action, &$gm){
		self::$action	= $action;
		self::$gm		= $gm;
			
		if (!file_exists('lib\actions\\'.self::$action.'.Class.php'))
			throw new SystemException('Action '.self::$action.' does not exist', 0, 0, __FILE__, __LINE__);
		
		require_once('lib\actions\\'.self::$action.'.Class.php');
		
		self::$action = self::$action.'Action';
		
		$handle = new self::$action(self::$gm);
		
		Design::auf(self::$gm);
		
		$handle->execute();
		
		Design::zu();
	}
}

?>
