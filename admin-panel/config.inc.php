<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

define('INC_DIR', dirname(__FILE__).'/');
define('GM_TOOL_VERSION', '3.0');

//Database
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'sa');
define('DB_PASS', '123456');

define('GM_ID', 6);


class dbConn{
    protected static $conn;
    private function __construct(){
       
    }
    public static function getConnection(){
       try {
				self::$conn  = new PDO("sqlsrv:Server=".DB_HOST.";Database=PS_GameDefs", DB_USER, DB_PASS);
			}
		catch (PDOException $e){
				die($e->getMessage()."<br/>".phpinfo());
			}
        return self::$conn;
    }
}
?>