<?php
//DSN
if ($dbName=="0"){
		$dbSting="";
	}
else {
		$dbString="Database=".$dbName.";";
	}
$dsn="Driver={SQL Server Native Client 11.0};Server=".$dbHost.";".$dbString;

//SQL Link
$dbConn = odbc_connect($dsn,$dbUser,$dbPass);
?>