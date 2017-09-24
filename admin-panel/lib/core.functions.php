<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

set_error_handler('exception_error_handler');
date_default_timezone_set('Europe/Paris');
session_start();

function __autoload($class){
	if (file_exists(INC_DIR.'lib/util/'.$class.'.class.php'))
		require_once(INC_DIR.'lib/util/'.$class.'.class.php');
	else if (file_exists(INC_DIR.'lib/data/'.$class.'/'.$class.'.class.php'))
		require_once(INC_DIR.'lib/data/'.$class.'/'.$class.'.class.php');
		
	if (file_exists(INC_DIR.'lib/exceptions/'.$class.'.class.php'))
		require_once(INC_DIR.'lib/exceptions/'.$class.'.class.php');	
}



if (isset($_POST['Login']) && isset($_GET['action'])){
	if ($_GET['action'] == 'login')
		$gm = login::check();
} else
	$gm = Session::check();

function BIntString($data){
//$cnvtdint="DECLARE @id bigint = ".$data." 
//select CAST(@id as varchar(max));";
//$res=mssql_fetch_array(mssql_query($cnvtdint));
return $data;
}



?>