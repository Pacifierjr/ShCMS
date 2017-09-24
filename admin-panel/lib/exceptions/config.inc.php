<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2016 Shaiya Productions
**/

define('INC_DIR', dirname(__FILE__).'/');
define('GM_TOOL_VERSION', '1');

//Database
define('DB_HOST', '5.196.208.25');
define('DB_USER', 'Shaiya');
define('DB_PASS', 'Shaiya123');

$info=array( "UID"=>DB_USER, "PWD"=>DB_PASS);
$conn=mssql_connect(DB_HOST, $info);
?>