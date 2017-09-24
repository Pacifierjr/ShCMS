<?php
// Database configuration parameters
	$dbHost = '127.0.0.1';
	$dbUser = 'sa';
	$dbPass = '123456';

	$dbConn = @odbc_connect("Driver={SQL Server};Server=".$dbHost.";",$dbUser,$dbPass) or die('Database Connection Error!');
	if(!$dbConn){
		exit("Connection failed:".odbc_errormsg());
	}
?>