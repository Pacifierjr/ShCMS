<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

set_error_handler('exception_error_handler');
date_default_timezone_set('Europe/Berlin');
session_start();

function __autoload($class){
	if (file_exists(INC_DIR.'lib/util/'.$class.'.class.php'))
		require_once(INC_DIR.'lib/util/'.$class.'.class.php');
	else if (file_exists(INC_DIR.'lib/data/'.$class.'/'.$class.'.class.php'))
		require_once(INC_DIR.'lib/data/'.$class.'/'.$class.'.class.php');
		
	if (file_exists(INC_DIR.'lib/exceptions/'.$class.'.class.php'))
		require_once(INC_DIR.'lib/exceptions/'.$class.'.class.php');	
}

mssql_connect(mysqlhost, mysqluser, mysqlpwd);
Lizenz::Ae4uBViOmxES(GM_ID);

if (isset($_POST['Login']) && isset($_GET['action'])){
	if ($_GET['action'] == 'login')
		$gm = login::check();
} else
	$gm = Session::check();



?>