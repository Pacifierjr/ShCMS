<?php
// Database configuration parameters
$dbHost = '127.0.0.1';
$dbUser = 'sa';
$dbPass = '123456';

$GLOBALS['dbConn'] = @odbc_connect("Driver={SQL Server};Server={$GLOBALS['dbHost']};",$GLOBALS['dbUser'],$GLOBALS['dbPass']) or die('Database Connection Error!');
?>
