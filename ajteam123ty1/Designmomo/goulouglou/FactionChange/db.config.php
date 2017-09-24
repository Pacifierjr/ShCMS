<?php
// Database configuration parameters
$dbHost = '127.0.0.1';
$dbUser = 'sa';
$dbPass = '123456';

/** 
 * Sanitize user input to prevent SQL injection.  Use this on ALL user input! 
 * This function is from CodeIgniter. 
 * I researched other methods of doing this, and this looked the most solid to me - Abrasive 
 * @param string $data 
 * @return string 
 */ 
function mssql_escape_string($data) { 
    if(!isset($data) or empty($data)) return ''; 
    if(is_numeric($data)) return $data; 
    $non_displayables = array( 
        '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15 
        '/%1[0-9a-f]/',                // url encoded 16-31 
        '/[\x00-\x08]/',            // 00-08 
        '/\x0b/',                    // 11 
        '/\x0c/',                    // 12 
        '/[\x0e-\x1f]/'                // 14-31 
    ); 
    foreach($non_displayables as $regex) 
        $data = preg_replace($regex,'',$data); 
        $data = str_replace("'","''",$data); 
    return $data; 
}
$GLOBALS['dbConn'] = @odbc_connect("Driver={SQL Server};Server={$GLOBALS['dbHost']};",$GLOBALS['dbUser'],$GLOBALS['dbPass']) or die('Database Connection Error!');
if(!$GLOBALS['dbConn']){
	exit("Connection failed:".odbc_errormsg());
}
?>