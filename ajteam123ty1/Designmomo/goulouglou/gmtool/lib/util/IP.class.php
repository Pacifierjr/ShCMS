<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class IP{
	private static $full;
	private static $expl;
	private static $cont;
	private static $ret;

	
	public static function ret($i){
		if ($i > 4)
			throw new SystemException('Trop de blocs d IP.', 0, 0, __FILE__, __LINE__);
		
		self::$cont = 0;
		self::$ret  = '';
		self::$full = $_SERVER['REMOTE_ADDR'];
		self::$expl = explode('.', self::$full);
		
		while (self::$cont < $i){
			self::$ret .= self::$expl[self::$cont];
			self::$cont++;
		}
		
		return self::$ret;
	}
	
	public static function eins(){
		return self::ret(1);
	}
	
	public static function zwei(){
		return self::ret(2);
	}
	
	public static function drei(){
		return self::ret(3);
	}
	
	public static function vier(){
		return self::ret(4);
	}
}

?>