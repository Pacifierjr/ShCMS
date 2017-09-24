<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/ 

Class oIP{
	private static $full;
	private static $expl;
	private static $cont;
	private static $ret;

	
	public static function ret($i, $oip){
		if ($i > 4)
			throw new SystemException('Too many IP Blocks.', 0, 0, __FILE__, __LINE__);
		
		self::$cont = 0;
		self::$ret  = '';
		self::$full = $oip;
		self::$expl = explode('.', self::$full);
		
		if (count(self::$expl) < $i)
			throw new SystemException('Not enough available IP blocks.', 0, 0, __FILE__, __LINE__);
		
		while (self::$cont < $i){
			self::$ret .= self::$expl[self::$cont];
			self::$cont++;
		}
		
		return self::$ret;
	}
	
	public static function eins($oip){
		return self::ret(1, $oip);
	}
	
	public static function zwei($oip){
		return self::ret(2, $oip);
	}
	
	public static function drei($oip){
		return self::ret(3, $oip);
	}
	
	public static function vier($oip){
		return self::ret(4, $oip);
	}
}

?>